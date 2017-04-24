<?php

namespace Tests\Unit;

use App\Zone;
use Tests\TestCase;

class ZoneTest extends TestCase
{

    /** @test */
    public function get_zone_from_state()
    {
        //arrange
        //Data is in migrations

        //act
        $zone = Zone::inState('B')->first();

        $this->assertEquals('España (Península)', $zone->name);
    }
}
