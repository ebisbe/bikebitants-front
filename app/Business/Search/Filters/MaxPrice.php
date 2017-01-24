<?php
namespace App\Business\Search\Filters;

class MaxPrice implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param mixed $value
     * @return array $builder
     */
    public static function apply($value)
    {
        return ['prices' => ['$lte' => (int)$value]];
    }
}
