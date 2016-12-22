<?php

use App\Zone;

class ZoneTest extends TestCase {

    /** @test */
    public function get_zone_from_state()
    {
        //arrange

        //act
        $zone = Zone::inState('B')->first();

        $this->assertEquals('España (Península)', $zone->name);
    }
}