<?php

namespace Tests\Unit;

use App\Zone;
use Tests\TestCase;

class ZoneTest extends TestCase
{

    public function tearDown()
    {
        Zone::truncate();
    }

    /** @test */
    public function get_zone_from_state()
    {
        //arrange
        factory(Zone::class)->create([
            'name' => 'Zone'
        ]);

        //act
        $zone = Zone::inState('B')->first();

        $this->assertEquals('Zone', $zone->name);
    }
}
