<?php

namespace App\Providers;

use App\Facades\StaticVars;
use App\Product;
use Collective\Html\FormBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use \Form;

class CollectionMacrosProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @param FormBuilder $factory
     * @return void
     */

    public function boot(FormBuilder $factory)
    {
        $factory->macro(
            'img',
            function ($filename, $sizes, $alt, $wrapper = '{img}', $class = 'lazyload img-responsive') {
                /** @var Collection $sizes */
                $srcset = $sizes->map(function ($size, $viewPort) use ($filename) {
                    return assetCDN("img/$size/$filename") . " $viewPort";
                })->implode(',');

                $size = $sizes->first();

                $img = '<img 
                        data-src="' . assetCDN("img/$size/$filename") . '"
                        class="' . $class . '" 
                        alt="' . $alt . '" 
                        data-sizes="100w" 
                        data-srcset="' . $srcset . '">';
                return str_ireplace('{img}', $img, $wrapper);
            }
        );

        $factory->macro('product', function (Product $product) {

            $images = [];
            foreach ($product->images as $image) {
                $images[] = Form::img(
                    $image->filename,
                    StaticVars::productRelated(),
                    $image->alt,
                    StaticVars::imgWrapper()
                );
                break; // TODO Make Owl.js to work when changin it's images src
            }

            $arr_product = [
                'name' => $product->name,
                'description' => $product->description,
                'brand' => $product->brand->name,
                'tags' => $product->tags_list,
                'images' => $images
            ];

            return json_encode($arr_product);
        });

        $factory->macro('postImage', function ($description) {
            preg_match("#src=[\"'](.+?)[\"']#i", $description, $matches);
            return $matches[1];
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
