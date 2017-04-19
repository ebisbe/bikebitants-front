<?php

namespace App\Business\Integration\WooCommerce\Models;

class Review extends ApiImporter
{

    protected $fillable = ['external_id', 'name', 'email', 'comment', 'verified', 'rating', 'product_id'];

    protected $attributes = [
        'verified' => false
    ];

    /**
     * Comments on a comment
     *
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function children()
    {
        return $this->embedsMany(Review::class);
    }

    public function customImport($product, $external_id)
    {
        $this->wooCommerceCallback("products/{$external_id}/reviews");
        $this->iterator(',');
        $this->pageSeparator('');
        return parent::import(false, $product, 'reviews');
    }

    public function sync($entity)
    {
        $entity['product_id'] = $this->parent_id;
        $entity['comment'] = $entity['review'];
        $entity['created_at'] = $this->convertDate($entity['date_created']);

        $this->fill($entity);
    }
}
