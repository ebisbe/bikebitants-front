<?php

namespace Tests\Unit\Wordpress;

use App\Business\Integration\Wordpress\Exception\EntityNotFoundException;
use App\Business\Integration\Wordpress\Factory;

class FactoryTest extends \TestCase
{
    /** @test */
    public function wordpress_entity_not_found()
    {
        try {
            Factory::make('not_found');
        } catch (EntityNotFoundException $e) {
            $this->assertInstanceOf('App\Business\Integration\Wordpress\Exception\EntityNotFoundException', $e);
            return;
        }
        $this->fail('Should have received an EntityNotFoundException');
    }

    /** @test */
    public function wordpress_entity()
    {
        $customer = Factory::make('Customer');
        $this->assertInstanceOf('App\Business\Integration\Wordpress\Customer', $customer);
    }

}
