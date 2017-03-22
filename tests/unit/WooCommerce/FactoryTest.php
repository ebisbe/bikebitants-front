<?php

namespace Tests\Unit\WooCoomerce;

use App\Business\Integration\WooCommerce\Exception\EntityNotFoundException;
use App\Business\Integration\WooCommerce\Factory;

class FactoryTest extends \TestCase
{
    /** @test */
    public function wordpress_entity_not_found()
    {
        try {
            Factory::make('not_found');
        } catch (EntityNotFoundException $e) {
            $this->assertInstanceOf('App\Business\Integration\WooCommerce\Exception\EntityNotFoundException', $e);
            return;
        }
        $this->fail('Should have received an EntityNotFoundException');
    }

    /** @test */
    public function wordpress_entity()
    {
        $customer = Factory::make('Customer');
        $this->assertInstanceOf('App\Business\Integration\WooCommerce\Customer', $customer);
    }

}
