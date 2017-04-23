<?php

namespace App\Business\Integration\WooCommerce\Models;

class Category extends ApiImporter
{
    public $wooCommerceCallback = 'products/categories';

    protected $attributes = [
        'products_count' => 0
    ];

    protected $fillable = [
        'name',
        'slug',
        'filename',
        'products_count',
        'meta_title',
        'meta_description',
        'meta_slug',
        'external_id',
        'order'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'father_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function father()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * @param $entity
     */
    public function sync($entity)
    {
        //TODO use WooCommerce defaults values
        $entity['order'] = $entity['menu_order'];
        $entity['products_count'] = $entity['count'];
        $entity['filename'] = $this->saveImage($entity['image']);

        $this->fill($entity);

        if (!empty($entity['parent'])) {
            /** @var Category $father */
            $father = self::whereExternalId($entity['parent'])->first();
            if (!is_null($father)) {
                $father->children()->save($this);
            }
        }
    }
}
