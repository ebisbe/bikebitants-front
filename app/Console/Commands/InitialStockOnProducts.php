<?php

namespace App\Console\Commands;

use App\Exceptions\VariationNotFoundException;
use App\Product;
use App\Property;
use Illuminate\Console\Command;

class InitialStockOnProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the the selected variation and their stock';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Product $products */
        $products = Product::hasStock()->isVariable()->get();
        $bar = $this->output->createProgressBar(count($products));

        $batch = collect();
        foreach ($products as $product) {
            /** @var Product $product */
            $default_attributes = $this->defaultAttributes($product);
            if ($default_attributes) {
                $batch->push([
                    "id" => $product->external_id,
                    "default_attributes" => $default_attributes
                ]);
            }
            $bar->advance();
        }

        \Woocommerce::post('products/batch', [
            'update' => $batch
        ]);

        $bar->finish();
    }


    /**
     * //Todo too many things
     * @param Product $product
     */
    protected function defaultAttributes(Product $product)
    {
        $selected_properties = $product
            ->properties
            ->map(function ($property) {
                $selected = $property->properties_values->first(function ($property_value) {
                    return $property_value->selected;
                });
                if (is_null($selected)) {
                    return $property->properties_values->first();
                }
                return $selected;
            })
            ->pluck('sku');

        $defaultVariation = $product->productVariation(array_merge(
            [$product->_id],
            $selected_properties->toArray()
        ));

        if (!is_null($defaultVariation) && $defaultVariation->stock > 0) {
            //If selected variation has stock we do nothing otherwise
            //we have to find a variation with stock.
            return false;
        }

        //We search for a variation with stock
        $variation = $product->variations->where('stock', '>', 0)->first();
        if (is_null($variation)) {
            throw new VariationNotFoundException('Variation with stock not found for product ' . $product->_id);
        }

        $this->line("{$variation->sku} -> Stock: {$variation->stock}");
        $properties = collect($variation->_id)->slice(1);

        return $properties->map(function ($prop, $key) use ($product) {
            /** @var Property $property */
            $property = $product
                ->properties
                ->where('order', '=', $key)->first();

            $property->properties_values->each(function ($property_value) {
                $property_value->selected = false;
                $property_value->save();
            });
            $option = $property->properties_values->first(function ($property_value) use ($prop) {
                return $property_value->sku == $prop;
            });

            //We save the value because the batch webhook doesn't trigger the updated webhook.
            $option->selected = true;
            $option->save();

            return [
                "id" => $property->external_id,
                "name" => $property->name,
                "option" => $option->name
            ];
        });
    }
}
