<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use App\Business\Traits\Presenters\ProductPresenter;
use App\Business\Traits\SluggableTrait;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App
 *
 * @property string $_id
 * @property string $name
 * @property string $description
 * @property string $currency
 * @property Brand $brand
 * @property string $tags_list
 * @property-read Image $front_image
 * @property-read Image $front_image_hover
 * @property-read Category $category
 *
 * @method static Builder whereSlug($slug)
 * @method static Builder whereBrandId($brandId)
 */
class Product extends Model
{
    use SoftDeletes, SluggableTrait, ProductPresenter;

    /** @var string $table Defined for inheritance in PublishedProduct */
    protected $table = 'products';

    const DRAFT = 1;
    const PUBLISHED = 2;
    const HIDDEN = 3;

    const DRAFT_CLASS = 'bg-danger';
    const PUBLISHED_CLASS = 'bg-primary';
    const HIDDEN_CLASS = 'bg-info';

    protected $appends = [ 'tags_list', 'currency'];
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'generic_name', 'slug', 'status', 'introduction', 'description', 'is_featured', 'tags', 'meta_title', 'meta_description', 'meta_slug', 'external_id', 'prices', 'stock', 'is_discounted', 'categories'];
    protected $casts = ['is_featured' => 'boolean', 'is_discounted' => 'boolean'];

    /**
     * Colors defined for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function attributes()
    {
        return $this->embedsMany(Attribute::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function variations()
    {
        return $this->embedsMany(Variation::class);
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
     * Labels attached to the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function labels()
    {
        return $this->embedsMany(Label::class);
    }

    /**
     * Images from the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function images()
    {
        return $this->embedsMany(Image::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function faqs()
    {
        return $this->embedsMany(Faq::class);
    }

    /**
     * @param $attributes
     * @return Variation
     */
    public function productVariation($attributes)
    {
        return $this
            ->variations()
            ->first(function ($key, $value) use ($attributes) {
                return array_diff($value->_id, array_values($attributes)) == [];
            });
    }

    /**
     * Get the price of a product. If has multiple attributes with different prices should work too.
     * @param array $attributes
     * @return int
     */
    public function finalPrice($attributes = [])
    {
        $variation = $this->productVariation($attributes);
        return $variation->price;
    }
}
