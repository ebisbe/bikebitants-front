<?php

namespace App\Business\Integration\WooCommerce\Models;

class Setting extends ApiImporter
{
    public function import($paginate = true, $parent = null, $child = null)
    {
        $settings = collect(\Woocommerce::get("settings/general"));

        $this->woocommerce_specific_ship_to_countries($this->id($settings, 'woocommerce_specific_ship_to_countries'));
    }

    public function woocommerce_specific_ship_to_countries($setting)
    {
        $country = ModelFactory::make('country');
        $country->update(['active' => 0]);
        $country->wherein('_id', $setting['value'])->update(['active' => 1]);
        //dd($setting['value']);
    }

    public function id($settings, $value)
    {
        return $settings->first(function ($setting) use ($value) {
            return $setting['id'] == $value;
        });
    }
}
