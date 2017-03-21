<?php
namespace App\Business\Search\Filters;

class Slug implements Filter
{

    /**
     * @param mixed $value
     * @return array
     */
    public static function apply($value): array
    {
        return ['categories' => ['$in' => [$value]]];
    }
}
