<?php

use App\Product;

$products = collect();
foreach($cartCollect as $item) {
    /** @var Product $product */
    $product = $item->attributes['product'];

    $productArr = [
        'filename' => $item->attributes->filename,
        'alt' => $item->name,
        'name' => $item->name,
        'route' => route('shop.product', ['slug' => $product->slug]),
        'quantity' => $item->quantity,
        'price' =>  $item->getPriceWithConditions(),
        'currency' => $product->currency,
        '_id' => $item->id
    ];
    $products->push($productArr);
}
echo json_encode($products->toArray());