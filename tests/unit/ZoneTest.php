<?php

use App\Zone;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ZoneTest extends TestCase
{

    use DatabaseMigrations;

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
