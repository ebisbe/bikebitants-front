<?php

namespace App;

use App\Business\Repositories\ProductRepository;
use App\Business\Traits\FileHashTrait;
use App\Exceptions\OutOfStockException;
use App\Jobs\ProductVariations;

/**
 * @property mixed stock
 */
class Variation extends \App\Business\Integration\WooCommerce\Models\Variation
{
    use FileHashTrait;

    protected $appends = ['tax_price', 'file_hash'];

    protected $hidden = ['real_price', 'updated_at', 'created_at'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($variation) {
            //TODO check for stock lower than 0 and deny it
            if ($variation->is_discounted) {
                $variation->price = $variation->discounted_price;
            } else {
                $variation->price = $variation->real_price;
            }
        });

        static::saved(function ($model) {
            /** @var Product $product */
            $product = Product::find($model->_id[0]);
            dispatch(new ProductVariations($product));
        });
    }

    public function getTaxPriceAttribute()
    {
        return \TaxService::applyTax($this->price);
    }

    /**
     * @param $cartQuantity
     * @throws OutOfStockException
     */
    public function checkStock($cartQuantity)
    {
        if (
            //Allow dropshipping stock -> stock = null
            !is_null($this->stock)
            && $this->stock - $cartQuantity < 0
        ) {
            throw new OutOfStockException(trans('exceptions.out_of_stock', ['product' => $this->sku]));
        }
    }

    /**
     * @param $quantity
     * @param $status
     * @return int|null
     */
    public function updateStock($quantity, $status)
    {
        if (is_null($this->stock)) {
            return $this->stock;
        }

        if ($status == Order::NEW) {
            return $this->decrement('stock', $quantity);
        }

        if ($status == Order::CANCELLED) {
            return $this->increment('stock', $quantity);
        }
    }
}
