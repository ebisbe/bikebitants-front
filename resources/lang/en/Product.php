<?php

use App\Product;

return [
    'name' => 'Name',
    'slug' => 'Slug',
    'status' => 'Status',
    'introduction' => 'Introduction',
    'description' => 'Description',
    'meta_title' => 'Meta Title',
    'meta_description' => 'Meta Description',
    'meta_slug' => 'Meta Slug',
    Product::DRAFT => 'Draft',
    Product::PUBLISHED => 'Published',
    Product::HIDDEN => 'Hidden',
];
