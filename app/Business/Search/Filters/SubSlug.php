<?php
namespace App\Business\Search\Filters;

use Jenssegers\Mongodb\Eloquent\Builder;

class SubSlug implements Filter
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
