<?php

namespace App\Business\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use PulkitJalan\GeoIP\Facades\GeoIP;

class GeoIpTaxScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return mixed
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->orWhere(function ($query) {
            $query->whereCountry(GeoIP::getCountryCode())
                ->whereState(GeoIP::getRegionCode())
                ->wherePostcode(GeoIP::getPostalCode())
                ->whereCity(GeoIP::getCity());
        })
        ->orWhere(function ($query) {
            $query->whereCountry(GeoIP::getCountryCode())
                ->whereState(GeoIP::getRegionCode())
                ->wherePostcode(GeoIP::getPostalCode())
                ->whereCity('');
        })
        ->orWhere(function ($query) {
            $query->whereCountry(GeoIP::getCountryCode())
                ->whereState(GeoIP::getRegionCode())
                ->wherePostcode('')
                ->whereCity('');
        })
        ->orWhere(function ($query) {
            $query->whereCountry(GeoIP::getCountryCode())
                ->whereState('')
                ->wherePostcode('')
                ->whereCity('');
        })
        ->orWhere(function ($query) {
            $query->whereCountry('')
                ->whereState('')
                ->wherePostcode('')
                ->whereCity('');
        });
    }
}