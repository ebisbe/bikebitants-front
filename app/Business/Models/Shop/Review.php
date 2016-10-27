<?php

namespace App\Business\Models\Shop;
use App\Business\Traits\ValidatedReviewTrait;


/**
 * Class PublishedProduct
 * @package App\Shop
 */
class Review extends \App\Review
{
    use ValidatedReviewTrait;
}
