<?php

namespace App\Business\Services;

use App\Attribute;
use App\AttributeValue;
use App\Brand;
use App\Business\Repositories\ProductRepository;
use App\Category;
use App\Image;
use App\Product;
use App\Tax;
use App\Variation;
use Carbon\Carbon;
use StaticVars;
use Storage;

class WordpressService
{
    /** @var  Product $product */
    protected $product;

    public function importFromWordpress($wpProduct)
    {
        if ($this->statusSyncro($wpProduct['status']) == Product::DRAFT) {
            return false;
        }

        $this->product = Product::whereExternalId($wpProduct['id'])->first();
        if (empty($this->product)) {
            $this->product = new Product();
        }

        $this->product->_id = $wpProduct['sku'];
        $this->product->external_id = $wpProduct['id'];
        $this->product->name = $wpProduct['name'];
        $this->product->status = $this->statusSyncro($wpProduct['status']);
        $this->product->slug = $wpProduct['slug'];
        $this->product->description = $this->stripVCRow($wpProduct['description']);
        $this->product->introduction = $wpProduct['short_description'];
        $this->product->tags = collect($wpProduct['tags'])
            ->map(function ($tag) {
                return $tag['name'];
            })->toArray();
        if (is_null($wpProduct['date_created'])) {
            $this->product->created_at = Carbon::now();
        } else {
            $this->product->created_at = Carbon::createFromFormat(StaticVars::wordpressDateTime(), $wpProduct['date_created']);
        }
        $this->product->updated_at = Carbon::createFromFormat(StaticVars::wordpressDateTime(), $wpProduct['date_modified']);
        $this->product->save();

        $this->syncAttributes($wpProduct['attributes']);
        $this->syncCategories($wpProduct['categories']);
        $this->syncImages($wpProduct['images']);
        $variations = !empty($wpProduct['variations']) ? $wpProduct['variations'] : [$wpProduct];
        $this->syncVariations($variations);

        (new ProductRepository)->update($this->product->_id, $this->product->toArray());

        return true;
    }

    /**
     * @param $variations
     */
    public function syncVariations($variations)
    {
        collect($variations)->each(function ($wpVariation) {
            $variation = $this->product
                ->variations()
                ->filter(function ($variation) use ($wpVariation) {
                    return $variation->external_id == $wpVariation['id'];
                })->first();

            $new = false;
            if (empty($variation)) {
                $variation = new Variation();
                $new = true;
            }

            $variationsAtt = collect($wpVariation['attributes'])
                ->filter(function ($att) {
                    return isset($att['option']);
                })
                ->map(function ($att) {
                    return str_slug(strtolower($att['option']));
                })
                ->toArray();

            $variation->_id = array_merge([$this->product->_id], $variationsAtt);
            $variation->sku = $wpVariation['sku'];
            $variation->external_id = $wpVariation['id'];
            $variation->real_price = (float)$wpVariation['regular_price'];
            $variation->discounted_price = (float)$wpVariation['sale_price'];
            $variation->is_discounted = $wpVariation['on_sale'];
            $variation->stock = 10/*$wpVariation['stock']*/
            ;
            $variation->filename = $this->saveImage($wpVariation[isset($wpVariation['image']) ? 'image' : 'images'][0]);

            if ($new) {
                $this->product->variations()->save($variation);
            } else {
                $variation->save();
            }
        });
    }

    /**
     * @param $attributes
     */
    public function syncAttributes($attributes)
    {
        $order = 1;
        collect($attributes)
            ->sortBy('position')
            ->each(function ($attribute) use (&$order) {
                if ($attribute['variation']) {
                    $this->syncVariationAttributes($attribute, $order);
                    $order ++;
                } else {
                    $this->syncAttribute($attribute);
                }
            });
    }

    /**
     * @param $attribute
     */
    public function syncAttribute($attribute)
    {
        switch ($attribute['name']) {
            case 'brand':
                $brand = Brand::whereName($attribute['options'][0])->first();
                if (empty($brand)) {
                    $brand = new Brand();
                }
                $brand->name = $attribute['options'][0];
                $brand->save();
                $brand->products()->save($this->product);
                break;
            default:
                $this->{$attribute['name']} = $attribute['options'][0];
                break;
        }
    }

    /**
     * @param $variation
     */
    public function syncVariationAttributes($variation, $order)
    {
        $attribute = $this->product
            ->attributes()
            ->filter(function ($attribute) use ($variation) {
                return $attribute->external_id == $variation['id'];
            })
            ->first();
        $new = false;
        if (empty($attribute)) {
            $attribute = new Attribute();
            $new = true;
        }

        $attribute->name = $variation['name'];
        $attribute->order = $order;
        $attribute->external_id = $variation['id'];

        if ($new) {
            $this->product->attributes()->save($attribute);
        } else {
            $attribute->save();
        }

        collect($variation['options'])->each(function ($option) use ($attribute) {
            $value = new AttributeValue();
            $value->_id = str_slug(strtolower($option));
            $value->sku = str_slug(strtolower($option));
            $value->name = $option;
            $value->complementary_text = '';
            $attribute->attribute_values()->save($value);
        });

        $attribute->save();
    }

    /**
     * @param $images
     */
    public function syncImages($images)
    {
        $this->product->images()->filter();
        collect($images)->each(function ($wpImage) {
            $this->syncImage($wpImage);
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

    public function syncCategories($categories)
    {
        collect($categories)->each(function ($category) {
            $category = $this->syncCategory($category);
            $category->products()->save($this->product);
        });
    }

    /**
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
            $category->products = $wpCategory['count'];
        }
        if (!empty($wpCategory['description'])) {
            $category->description = $wpCategory['description'];
        }
        $category->external_id = $wpCategory['id'];
        if (isset($wpCategory['image'])) {
            $category->filename = $this->saveImage($wpCategory);
        }

        $category->save();

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
     * @param $tax
     */
    public function syncTax($wpTax)
    {
        $tax = Tax::whereExternalId($wpTax['id'])->first();
        if (empty($tax)) {
            $tax = new Tax();
        }

        $tax->external_id = $wpTax['id'];
        $tax->country = $wpTax['country'];
        $tax->state = $wpTax['state'];
        $tax->postcode = $wpTax['postcode'];
        $tax->city = $wpTax['city'];
        $tax->rate = (float)$wpTax['rate'];
        $tax->name = $wpTax['name'];
        //$tax->priority = $wpTax['priority'];
        //$tax->compound = $wpTax['compound'];
        //$tax->shipping = $wpTax['shipping'];
        $tax->order = $wpTax['order'];
        //$tax->class = $wpTax['class'];

        $tax->save();
    }

    /**
     * TODO avoid redownloading non modified images
     * @param $image
     * @return string
     */
    public function saveImage($image)
    {
        if (!empty($image['src'])) {
            $name = basename($image['src']);
            if (!Storage::exists($name)) {
                Storage::put($name, file_get_contents($image['src']));
            }
            return $name;
        }
        return '';
    }

    /**
     * Return status from Product or -1 in case of unkown.
     * @param $status
     * @return int
     */
    public function statusSyncro($status)
    {
        $statusValues = [
            'draft' => Product::DRAFT,
            'publish' => Product::PUBLISHED
        ];
        return isset($statusValues[$status]) ? $statusValues[$status] : -1;
    }

    public function stripVCRow($text)
    {
        return preg_replace('#\[(/)?vc_.+\]?#', '', $text);
    }
}