<?php

namespace App\Business\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use \GeoIP;

class GeoIpTaxScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return mixed
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder
            ->orWhere(function ($query) {
                $query->where('country',GeoIP::getCountryCode())
                    ->where('state',GeoIP::getRegionCode())
                    ->where('postcode',GeoIP::getPostalCode())
                    ->where('city',GeoIP::getCity());
            })
            ->orWhere(function ($query) {
                $query->where('country',GeoIP::getCountryCode())
                    ->where('state',GeoIP::getRegionCode())
                    ->where('postcode',GeoIP::getPostalCode())
                    ->where('city','');
            })
            ->orWhere(function ($query) {
                $query->where('country',GeoIP::getCountryCode())
                    ->where('state',GeoIP::getRegionCode())
                    ->where('postcode','')
                    ->where('city','');
            })
            ->orWhere(function ($query) {
                $query->where('country',GeoIP::getCountryCode())
                    ->where('state','')
                    ->where('postcode','')
                    ->where('city','');
            })
            ->orWhere(function ($query) {
                $query->where('country','')
                    ->where('state','')
                    ->where('postcode','')
                    ->where('city','');
            });
    }
}