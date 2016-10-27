<?php

namespace App\Business\Traits;

use App\Business\Scopes\ValidatedReviewScope;

trait ValidatedReviewTrait
{

    public static function bootValidatedReviewTrait()
    {
        static::addGlobalScope(new ValidatedReviewScope());
    }
}