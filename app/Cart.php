<?php

namespace App;

use App\Business\Models\Shop\Product as ProductShop;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Cart
 * @package App
 *
 * @property int $price
 * @property int $quantity
 * @property float $total
 * @property float $total_without_iva
 * @property string $variation_id
 * @property string $product_id
 * @property string $sku
 * @property Product $product
 * @property Order order
 * @property array properties
 */
class Cart extends Model
{
    const CART_CONDITION_TARGET_ITEM = 'item';
    const CART_CONDITION_TARGET_SUBTOTAL = 'subtotal';

    protected $fillable = [
        'price',
        'quantity',
        'total',
        'total_without_iva',
        'variation_id',
        'product_id',
        'sku',
    ];

    /**
     * Each cart has one product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        //TODO not sure we have to use here ProductShop
        return $this->belongsTo(ProductShop::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Find a product by it's properties if has some
     * @param $query
     * @param $properties
     * @return mixed
     */
    public function scopeWithProperties($query, $properties)
    {
        return $query->when($properties, function ($query) use ($properties) {
            foreach ($properties as $property => $value) {
                $query->where($property, '=', $value);
            }
            return $query;
        });
    }

    /**
     * Empty cart
     */
    public static function empty()
    {
        self::all()->map(function ($item) {
            $item->delete();
        });
    }

    /**
     * @return Collection
     */
    public function mapCartToParcel(): Collection
    {
        /** @var Cart $cart */
        $collectionAddress = $this->product->collectionAddress($this->order->isCashOnDelivery());
        $deliveryAddress = $this->product->deliveryAddress();
        $is_drop_shipping = $this->product->isDropShipping();
        $email_provider = $this->getEmail($this->product->email_provider);
        return collect([
            //TODO Hash should be in a function
            'hash' => ($collectionAddress ?? '_') . ($deliveryAddress ?? '_') . (int)$is_drop_shipping . $email_provider,
            'collection_address' => $collectionAddress,
            'delivery_address' => $deliveryAddress,
            'is_drop_shipping' => $is_drop_shipping,
            'weight' => $this->product->weight,
            'length' => $this->product->length,
            'width' => $this->product->width,
            'height' => $this->product->height,
            'volume' => $this->product->height * $this->product->width * $this->product->length,
            'email_provider' => $email_provider,
            'name' => $this->product->name,
            'attributes' => collect($this->properties)->slice(1)->implode(', '),
            'quantity' => $this->quantity
        ]);
    }

    /**
     * @param string $email
     * @return array|Collection
     */
    public function getEmail($email = null): Collection
    {
        return collect(explode(',', $email))
            ->map(function ($mail) {
                return trim($mail);
            });
    }
}
