<?php

namespace Tests\Unit;

use App\Business\Canonical\Canonical;
use Tests\TestCase;

class CanonicalTest extends TestCase
{
    /** @test */
    public function it_renders_empty_link()
    {
        $canonical = new Canonical();

        $this->assertEquals('', $canonical->render());
    }

    /** @test */
    public function it_renders_a_defined_link()
    {
        $canonical = new Canonical();

        $canonical->set('http://www.google.com');

        $this->assertEquals(
            '<link rel="canonical" href="http://www.google.com">',
            $canonical->render()
        );
    }
}
