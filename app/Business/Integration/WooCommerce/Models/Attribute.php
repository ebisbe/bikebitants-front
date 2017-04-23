<?php

namespace App\Business\Integration\WooCommerce\Models;

class Attribute extends ApiImporter
{
    protected $fillable = ['name', 'slug', 'type', 'order_by', 'has_archives', 'external_id' ];

    protected $wooCommerceCallback = 'products/attributes';

    public function import($paginate = true, $parent = null, $child = null)
    {
        return parent::import(false, $parent, $child);
    }

    public function afterSync($entity)
    {
        $attributeTerms = ModelFactory::make('AttributeTerms');
        $attributeTerms->import(true, $this, 'attribute_terms');
    }

    public function attribute_terms()
    {
        return $this->hasMany(AttributeTerms::class);
    }
}
