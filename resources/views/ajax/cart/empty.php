<?php
$response = [
    'products' => [],
    '_token' => csrf_token(),
    'cart' => route('cart.index'),
    'checkout' => route('checkout.index'),
    'shop' => route('shop.catalogue'),
];
echo json_encode($response);