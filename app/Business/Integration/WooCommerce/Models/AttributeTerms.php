<?php

namespace App\Business\Integration\WooCommerce\Models;

class AttributeTerms extends ApiImporter
{
    protected $fillable = ['name', 'slug', 'description', 'menu_order', 'count', 'external_id', 'parent_external_id'];

    public function import($paginate = true, $parent = null, $child = null)
    {
        $this->wooCommerceCallback = "products/attributes/{$parent->external_id}/terms";
        $this->pageSeparator(',');
        $this->iterator('_');
        return parent::import($paginate, $parent, $child);
    }

    public function getSkuFromOption(string $option):string
    {
        $terms = $this->whereName($option)->get();
        if ($terms->isNotEmpty()) {
            $sku = $terms->first()->slug;
        } else {
            $sku = str_slug(strtolower($option));
        }
        return $sku;
    }
}
