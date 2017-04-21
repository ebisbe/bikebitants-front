<?php

namespace App\Business\Integration\WooCommerce\Models;

use App\Business\Integration\WooCommerce\Properties;
use Illuminate\Support\Collection;

class Product extends ApiImporter
{
    const DRAFT = 1;
    const PUBLISHED = 2;
    const HIDDEN = 3;

    public $wooCommerceCallback = 'products';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'slug',
        'status',
        'introduction',
        'description',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_slug',
        'external_id',
        'prices',
        'stock',
        'is_discounted',
        'categories',
        'rating',
        'menu_order'
    ];

    protected $attributes = [
        'categories' => []
    ];

    protected $casts = ['is_featured' => 'boolean', 'is_discounted' => 'boolean', 'review_allowed' => 'boolean'];

    /**
     * Colors defined for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function properties()
    {
        return $this->embedsMany(Property::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function variations()
    {
        return $this->embedsMany(Variation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function up_sell()
    {
        return $this->belongsToMany(self::class, null, 'up_sell_ids', 'up_sell_product_ids');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cross_sell()
    {
        return $this->belongsToMany(self::class, null, 'cross_sell_ids', 'cross_sell_product_ids');
    }

    /**
     * Brand of the product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Tag or tags of the product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }


    /**
     * Reviews made by the users for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function reviews()
    {
        return $this->embedsMany(Review::class);
    }

    /**
     * Images from the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function images()
    {
        return $this->embedsMany(Image::class);
    }

    public function sync($entity)
    {
        $status = $this->statusSyncro($entity['status'], $entity['catalog_visibility']);
        if ($status == self::DRAFT) {
            return false;
        }

        $this->_id = $entity['sku'];
        $entity['status'] = $this->statusSyncro($entity['status'], $entity['catalog_visibility']);
        $entity['is_featured'] = $entity['featured'];
        $entity['slug'] = $this->slugFromPermalink($entity);
        $entity['description'] = $this->stripVCRow($entity['description']);
        $entity['introduction'] = $entity['short_description'];
        $entity['meta_title'] = $entity['meta']['_yoast_wpseo_title'] ?? '';
        $entity['meta_description'] = $entity['meta']['_yoast_wpseo_metadesc'] ?? '';

        $this->fill($entity);

        $this->images->each->delete();
        collect($entity['images'])->each(function ($wpImage) {
            $image = Image::firstOrNew(['external_id' => $wpImage['id']]);
            $this->images()->associate($image->sync($wpImage));
        });
    }

    public function afterSync($entity)
    {
        $this->variations->each->delete();
        /** @var Variation $variations */
        $variations = ModelFactory::make('variation');
        if (!empty($entity['variations'])) {
            $variations->customImport($this, $entity['external_id']);
        } else {
            $variations->parent_id = $this->_id;
            $variations->sync($entity);
            $this->variations()->save($variations);
        }

        $this->reviews->each->delete();
        $reviews = ModelFactory::make('review');
        $reviews->customImport($this, $entity['external_id']);

        //$this->addUpSellProducts($entity['upsell_ids']);
        $this->addCrossSellProducts($entity['cross_sell_ids']);

        $properties = new Properties($this);
        $properties->syncProperties($entity['attributes'], $entity['default_attributes'] ?? []);

        $this->relateCategories($entity);
        $this->relateTags($entity);
    }

    /**
     * Never use slug again. It doesn't updates correctly
     * @param $entity
     * @return string
     */
    protected function slugFromPermalink($entity): string
    {
        return collect(explode('/', $entity['permalink']))->filter()->last();
    }

    /**
     * Filter non-desired text from wordpress itself
     * @param $text
     * @return mixed
     */
    public function stripVCRow($text)
    {
        return preg_replace('#\[(/)?vc_.+\]?#', '', $text);
    }

    /**
     * Return status from Product or -1 in case of unknown.
     * @param $status
     * @param $catalog_visibility
     * @return int
     */
    public function statusSyncro($status, $catalog_visibility)
    {
        $statusValues = [
            'draft' => self::DRAFT,
            'publish' => self::PUBLISHED,
            'hidden' => self::HIDDEN
        ];

        if (!isset($statusValues[$status])) {
            return -1;
        }

        return $statusValues[$status] == self::PUBLISHED
        && in_array($catalog_visibility, ['hidden', 'search'])
            ? self::HIDDEN
            : $statusValues[$status];
    }

    /**
     * @param $upsell_ids
     */
    protected function addUpSellProducts($upsell_ids)
    {
        $related_product = $this->productsList($upsell_ids);
        $this->up_sell()->saveMany($related_product);
    }

    /**
     * @param $cross_sell_ids
     */
    protected function addCrossSellProducts($cross_sell_ids)
    {
        $related_product = $this->productsList($cross_sell_ids);
        $this->cross_sell()->saveMany($related_product);
    }

    /**
     * @param $array
     * @return Collection
     */
    protected function productsList($array)
    {
        return collect($array)->map(function ($id) {
            return self::whereExternalId($id)->first();
        })->filter();
    }

    /**
     * @param $entity
     */
    protected function relateCategories($entity)
    {
        $categories = collect($entity['categories'])
            ->pluck('id')
            ->map(function ($id) {
                return Category::whereExternalId($id)->first();
            });
        $this->category()->saveMany($categories);
    }

    /**
     * @param $entity
     */
    protected function relateTags($entity)
    {
        collect($entity['tags'])
            ->pluck('id')
            ->map(function ($id) {
                return Tag::whereExternalId($id)
                    ->first()
                    ->products()
                    ->save($this);
            });
    }
}
