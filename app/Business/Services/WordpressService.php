<?php

namespace App\Business\Services;

use App\Billing;
use App\Brand;
use App\Business\Repositories\CategoryRepository;
use App\Business\Repositories\ProductRepository;
use App\Customer;
use App\Category;
use App\Coupon;
use App\Image;
use App\Order;
use App\Product;
use App\Property;
use App\PropertyValue;
use App\Review;
use App\Shipping;
use App\Tax;
use App\Variation;
use Carbon\Carbon;
use StaticVars;
use Storage;
use Pixelpeter\Woocommerce\Facades\Woocommerce;

class WordpressService
{
    /** @var  Product $product */
    protected $product;

    protected $wooCommerceCallback;
    protected $wordpressServiceCallback;

    static $WP_FILE = 'wp_files';

    public function setWooCommerceCallback($wooCommerceCallback)
    {
        $this->wooCommerceCallback = $wooCommerceCallback;
        $this->wordpressServiceCallback = null;
    }

    public function getWooCommerceCallback()
    {
        return $this->wooCommerceCallback;
    }

    public function setWordpressServiceCallback($wordpressServiceCallback)
    {
        $this->wordpressServiceCallback = $wordpressServiceCallback;
    }

    public function getWordpressServiceCallback()
    {
        return !is_null($this->wordpressServiceCallback) ? $this->wordpressServiceCallback : 'sync' . ucfirst($this->getWooCommerceCallback());
    }

    public function import()
    {
        $this->inspector(function ($page) {
            $elements = collect(Woocommerce::get($this->getWooCommerceCallback(), ['page' => $page]));
            $elements->each(function ($element) {
                $wordpressServiceCallback = $this->getWordpressServiceCallback();
                if (method_exists($this, $wordpressServiceCallback)) {
                    $this->$wordpressServiceCallback($element);
                }
                echo '.';
            });
            return $elements->count();
        });
    }

    /**
     * @param $callback
     */
    public function inspector($callback)
    {
        $page = 1;
        do {
            echo '+';
            $totalItems = $callback($page);
            $page++;
        } while ($totalItems > 0);
    }

    /**
     * Import product from WooCommerce
     * @param $wpProduct
     * @return bool
     */
    public function syncProduct($wpProduct)
    {
        $status = $this->statusSyncro($wpProduct['status'], $wpProduct['catalog_visibility']);
        if ($status == Product::DRAFT) {
            return false;
        }

        $this->product = Product::orWhere(function ($query) use ($wpProduct) {
            $query->whereExternalId($wpProduct['id'])
                ->orWhere('_id', $wpProduct['sku']);
        })
            ->first();
        // $this->product->timestamps = false;
        if (empty($this->product)) {
            $this->product = new Product();
        }

        $this->product->_id = $wpProduct['sku'];
        $this->product->external_id = $wpProduct['id'];
        $this->product->name = $wpProduct['name'];
        $this->product->status = $status;
        $this->product->is_featured = $wpProduct['featured'];
        $this->product->slug = $wpProduct['slug'];
        $this->product->description = $this->stripVCRow($wpProduct['description']);
        $this->product->introduction = $wpProduct['short_description'];
        $this->product->reviews_allowed = $wpProduct['reviews_allowed'];
        $this->product->tags = collect($wpProduct['tags'])
            ->map(function ($tag) {
                return $tag['name'];
            })->toArray();
        (new ProductRepository)->update($this->product, $this->product->toArray());

        $this->syncProperties($wpProduct['attributes'], $wpProduct['default_attributes']);
        $this->syncCategories($wpProduct['categories']);
        $this->syncImages($wpProduct['images']);
        $variations = !empty($wpProduct['variations']) ? $wpProduct['variations'] : [$wpProduct];
        $this->syncVariations($variations);
        (new ProductRepository)->update($this->product, $this->product->toArray());

        return true;
    }

    /**
     * Import Variations from WooCommerce
     * @param $variations
     */
    public function syncVariations($variations)
    {
        collect($variations)
            ->each(function ($wpVariation) {
                $variation = $this->product
                    ->variations()
                    ->filter(function ($variation) use ($wpVariation) {
                        return $variation->external_id == $wpVariation['id'];
                    })->first();

                $_id = $this->variationsAttributes($wpVariation);

                $new = false;
                if (empty($variation)) {
                    $variation = new Variation();
                    $new = true;
                } elseif ($_id != $variation->_id) {
                    $variation->delete();
                    $new = true;
                }

                $variation->_id = $_id;
                $variation->sku = $wpVariation['sku'];
                $variation->external_id = $wpVariation['id'];
                $variation->real_price = (float)$wpVariation['regular_price'];
                $variation->discounted_price = (float)$wpVariation['sale_price'];
                $variation->is_discounted = $wpVariation['on_sale'];
                $variation->stock = is_null($wpVariation['stock_quantity']) ? 25 : $wpVariation['stock_quantity'];
                $variation->filename = $this->saveImage($wpVariation[isset($wpVariation['image']) ? 'image' : 'images'][0]);

                if ($new) {
                    $this->product->variations()->save($variation);
                } else {
                    $variation->save();
                }
            });
    }

    /**
     * @param $wpVariation
     * @return array
     */
    private function variationsAttributes($wpVariation): array
    {
        $variationsAtt = collect($wpVariation['attributes'])
            ->filter(function ($att) {
                return isset($att['option']);
            })
            ->map(function ($att) {
                return str_slug(strtolower($att['option']));
            })
            ->toArray();
        return array_merge([$this->product->_id], $variationsAtt);
    }

    /**
     * Import Properties from products if they have. Properties can be from variations or product properties
     * @param $properties
     */
    public function syncProperties($properties, $defaultAttributes)
    {
        $order = 1;
        $ids = [];
        collect($properties)
            ->sortBy('position')
            ->each(function ($attribute) use (&$order, &$ids, $defaultAttributes) {
                if ($attribute['variation']) {
                    $ids[] = $this->syncVariationProperties($attribute, $order, $defaultAttributes);
                    $order++;
                } else {
                    $this->syncAttribute($attribute);
                }
            });

        //Find deleted attributes
        $propertiesToDelete = $this->product
            ->properties()
            ->filter(function ($attribute) use ($ids) {
                return !in_array($attribute['external_id'], $ids);
            });
        //Delete attributes
        $propertiesToDelete->each(function ($attribute) {
            $this->product->properties()->destroy($attribute);
        });
    }

    /**
     * Import Attribute for a product
     * @param $attribute
     */
    public function syncAttribute($attribute)
    {
        if ($attribute['name'] == 'brand') {
            $brand = Brand::whereName($attribute['options'][0])->first();
            if (empty($brand)) {
                $brand = new Brand();
            }
            $brand->name = $attribute['options'][0];
            $brand->save();
            $brand->products()->save($this->product);
        } else {
            $this->product->{$attribute['name']} = $attribute['options'][0];
        }
    }

    /**
     * Import variations from product. They are used to handle modifications of the same product
     * @param $variation
     * @param $order
     * @param $defaultAttributes
     * @return String
     */
    public function syncVariationProperties($variation, $order, $defaultAttributes)
    {
        $attribute = $this->product
            ->properties()
            ->filter(function ($attribute) use ($variation) {
                return $attribute->external_id == $variation['id'];
            })
            ->first();
        $new = false;
        if (empty($attribute)) {
            $attribute = new Property();
            $new = true;
        }

        $attribute->name = $variation['name'];
        $attribute->order = $order;
        $attribute->external_id = $variation['id'];

        if ($new) {
            $this->product->properties()->save($attribute);
        } else {
            $attribute->save();
        }

        collect($variation['options'])->each(function ($option) use ($attribute, $defaultAttributes, $variation) {
            $value = new PropertyValue();
            $sku = str_slug(strtolower($option));
            $value->_id = $sku;
            $value->sku = $sku;
            $value->name = $option;
            $value->selected = collect($defaultAttributes)
                ->where('id', '=', $variation['id'])
                ->where('option', '=', $sku)->count() == 1;
            $value->complementary_text = '';
            $attribute->properties_values()->save($value);
        });

        $attribute->save();
        return $variation['id'];
    }

    private function defaultVariation()
    {

    }

    /**
     * Import Images
     * @param $images
     */
    public function syncImages($images)
    {
        $ids = collect($images)
            ->map(function ($wpImage) {
                return $this->syncImage($wpImage);
            })
            ->pluck('external_id')
            ->toArray();

        //Find deleted images
        $imagesToDelete = $this->product
            ->images()
            ->filter(function ($image) use ($ids) {
                return !in_array($image['external_id'], $ids);
            });
        //Delete attributes
        $imagesToDelete->each(function ($attribute) {
            $this->product->images()->destroy($attribute);
        });
    }

    /**
     * @param $wpImage
     * @return Image
     */
    public function syncImage($wpImage)
    {
        $image = $this->product
            ->images()
            ->filter(function ($image) use ($wpImage) {
                return $image->external_id == $wpImage['id'];
            })
            ->first();

        $new = false;
        if (empty($image)) {
            $image = new Image();
            $new = true;
        }
        $image->name = $wpImage['name'];
        $image->alt = $wpImage['alt'];
        $image->external_id = $wpImage['id'];
        $image->order = $wpImage['position'];
        $image->filename = $this->saveImage($wpImage);

        if ($new) {
            $this->product->images()->save($image);
        } else {
            $image->save();
        }
        return $image;
    }

    /**
     * Import all categories and relate them to the products
     * @param $categories
     */
    public function syncCategories($categories)
    {
        collect($categories)
            ->sortBy('parent')
            ->each(function ($category) {
                $category = $this->syncCategory($category);
                $category->products()->save($this->product);
            });
    }

    /**
     * Create a category or update it if it already exists
     * @param $wpCategory
     * @return Category
     */
    public function syncCategory($wpCategory)
    {
        $category = Category::whereExternalId($wpCategory['id'])->first();
        if (empty($category)) {
            $category = new Category();
        }

        $category->name = $wpCategory['name'];
        $category->slug = $wpCategory['slug'];
        if (!empty($wpCategory['menu_order'])) {
            $category->order = $wpCategory['menu_order'];
        }
        if (!empty($wpCategory['count'])) {
            $category->products_count = $wpCategory['count'];
        }
        if (!empty($wpCategory['description'])) {
            $category->description = $wpCategory['description'];
        }
        $category->external_id = $wpCategory['id'];
        if (!empty($wpCategory['image'])) {
            $category->filename = $this->saveImage($wpCategory['image']);
        }

        (new CategoryRepository())->update($category, $category->toArray());

        if (!empty($wpCategory['parent'])) {
            /** @var Category $father */
            $father = Category::whereExternalId($wpCategory['parent'])->first();
            if (!is_null($father)) {
                $father->children()->save($category);
            }
        }
        return $category;
    }

    /**
     * Import tax
     * @param $wpTax
     */
    public function syncTaxes($wpTax)
    {
        $tax = Tax::whereExternalId($wpTax['id'])->first();
        if (empty($tax)) {
            $tax = new Tax();
            $tax->external_id = $wpTax['id'];
        }

        $tax->fill($wpTax);
        //$tax->priority = $wpTax['priority'];
        //$tax->compound = $wpTax['compound'];
        //$tax->shipping = $wpTax['shipping'];
        //$tax->class = $wpTax['class'];

        $tax->save();
    }

    /**
     * Import tax
     * @param $wpCustomer
     */
    public function syncCustomers($wpCustomer)
    {
        $customer = Customer::whereExternalId($wpCustomer['id'])->first();
        if (empty($customer)) {
            $customer = new Customer();
            $customer->external_id = $wpCustomer['id'];
        }
        $customer->fill($wpCustomer);

        $billing = new Billing();
        $billing->fill($wpCustomer['billing']);
        $customer->billing()->associate($billing);

        $shipping = new Shipping();
        $shipping->fill($wpCustomer['shipping']);
        $customer->shipping()->associate($shipping);

        $customer->save();
    }

    /**
     * @param $image
     * @return string
     */
    public function saveImage($image)
    {
        try {
            if (!empty($image['src'])) {
                list($url, $name) = $this->encodeSrc($image['src']);
                if (!Storage::exists(static::$WP_FILE . '/' . $name)) {
                    Storage::put(static::$WP_FILE . '/' . $name, file_get_contents($url . $name));
                }
                return $name;
            }
        } catch (\ErrorException $e) {
            return '';
        }
    }

    public function encodeSrc($source)
    {
        $name = basename($source);

        return [str_replace($name, '', $source), urlencode($name)];
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
            'draft' => Product::DRAFT,
            'publish' => Product::PUBLISHED,
            'hidden' => Product::HIDDEN
        ];

        if (!isset($statusValues[$status])) {
            return -1;
        }

        return $statusValues[$status] == Product::PUBLISHED
        && in_array($catalog_visibility, ['hidden', 'search'])
            ? Product::HIDDEN
            : $statusValues[$status];
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
     * Import the review and relate it to the product
     * @param $wpReview
     */
    public function syncReview($wpReview)
    {

        $review = $this->product
            ->reviews()
            ->filter(function ($review) use ($wpReview) {
                return $review->external_id == $wpReview['id'];
            })
            ->first();
        $new = false;
        if (empty($review)) {
            $review = new Review();
            $new = true;
        }

        $review->external_id = $wpReview['id'];
        $review->product_id = $this->product->_id;
        $review->name = $wpReview['name'];
        $review->email = $wpReview['email'];
        $review->comment = $wpReview['review'];
        $review->verified = $wpReview['verified'];
        $review->rating = $wpReview['rating'];
        $review->created_at = $this->convertDate($wpReview['date_created']);

        if ($new) {
            $this->product->reviews()->save($review);
            (new ProductRepository)->update($this->product, $this->product->toArray());
        } else {
            $review->save();
        }
    }

    /**
     * Convert WP date format to a Carbon
     * @param $date
     * @return Carbon
     */
    protected function convertDate($date)
    {
        if (is_null($date)) {
            return Carbon::now();
        }
        return Carbon::createFromFormat(StaticVars::wordpressDateTime(), $date);
    }

    /**
     * Import coupons from wp
     * TODO still some options have to be implemented
     * @param $wpCoupon
     */
    public function syncCoupons($wpCoupon)
    {
        $coupon = Coupon::whereExternalId($wpCoupon['id'])->first();
        if (empty($coupon)) {
            $coupon = new Coupon();
        }

        $coupon->external_id = $wpCoupon['id'];
        $coupon->name = $wpCoupon['code'];
        $coupon->magnitude = -(float)$wpCoupon['amount'];
        $coupon->type = $this->couponStatus($wpCoupon['discount_type']);
        $coupon->description = $wpCoupon['description'];
        $coupon->expired_at = $this->convertDate($wpCoupon['expiry_date']);
        $coupon->minimum_cart = (float)$wpCoupon['minimum_amount'];
        $coupon->maximum_cart = (float)$wpCoupon['maximum_amount'];

        //$coupon->limit_usage_by_coupon = 3;
        //$coupon->limit_usage_by_user = 1;
        //$coupon->single_use = 1;
        //$coupon->emails = $faker->email.','.$faker->email.','.$faker->emai;
        $coupon->save();
    }

    /**
     * Status mirrorring from wp to laravel
     * @param $status
     * @return mixed
     */
    protected function couponStatus($status)
    {
        $statusTypes = [
            'fixed_cart' => Coupon::DIRECT,
            'fixed_product' => Coupon::DIRECT,
            'percent' => Coupon::PERCENTAGE,
            'percent_product' => Coupon::PERCENTAGE,
        ];

        return $statusTypes[$status];
    }

    /**
     * Create order in WooCommerce
     * @param $order
     */
    public function createOrder(Order $order)
    {

        $coupon = [];
        $couponCondition = $order->conditionsFilter(Coupon::CART_CONDITION_TYPE);
        if (!empty($couponCondition)) {
            $couponRaw = Coupon::whereName($couponCondition['name'])->first();

            $coupon = [
                [
                    'code' => $couponRaw->name,
                    'id' => $couponRaw->external_id,
                    'discount' => 0
                ]
            ];
        }

        $items = $order->cart->map(function ($cart) {
            $item = [];
            $item['product_id'] = $cart->product_id;
            $item['total'] = $cart->total_without_iva;
            $item['quantity'] = $cart->quantity;
            if (!empty($cart->product->properties)) {
                $item['variation_id'] = $cart->variation_id;
            }
            return $item;
        });

        $shipping = $order->conditionsFilter(Shipping::CART_CONDITION_TYPE);

        $data = [
            'payment_method' => $order->payment_method->code,
            'payment_method_title' => $order->payment_method->name,
            'set_paid' => $order->payment_method->set_paid,
            'billing' => [
                'first_name' => $order->billing->first_name,
                'last_name' => $order->billing->last_name,
                'address_1' => $order->billing->address_1,
                'address_2' => $order->billing->address_2,
                'city' => $order->billing->city,
                'state' => $order->billing->state,
                'postcode' => $order->billing->postcode,
                'country' => $order->billing->country,
                'email' => $order->billing->email,
                'phone' => $order->billing->phone,
            ],
            'shipping' => [
                'first_name' => $order->shipping->first_name,
                'last_name' => $order->shipping->last_name,
                'address_1' => $order->shipping->address_1,
                'address_2' => $order->shipping->address_2,
                'city' => $order->shipping->city,
                'state' => $order->shipping->state,
                'postcode' => $order->shipping->postcode,
                'country' => $order->shipping->country,
            ],
            'line_items' => $items->toArray(),
            'shipping_lines' => [
                [
                    'method_id' => 'flat_rate',
                    'method_title' => $shipping['name'],
                    'total' => $shipping['value'] / 1.21,
                ]
            ],
            "coupon_lines" => $coupon
        ];

        $response = \Woocommerce::post('orders', $data);

        $order->external_id = $response['id'];
        $order->response = $response;
        $order->save();
    }
}
