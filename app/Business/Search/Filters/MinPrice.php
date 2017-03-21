<?php
namespace App\Business\Search\Filters;

class MinPrice implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param mixed $value
     * @return array
     */
    public static function apply($value): array
    {
        return ['prices' => ['$gte' => (int)$value]];
    }
}
