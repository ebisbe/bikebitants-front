<?php

namespace Tests\Unit\Models;

use App\Cart;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CartTest extends TestCase
{
    /** @test */
    public function it_gets_emails()
    {
        /** @var Cart $cart */
        $cart = factory(Cart::class)->create();

        $emails = $cart->getEmail('hola1@email.com , hola2@email.com');

        $this->assertInstanceOf(Collection::class, $emails);
        $this->assertEquals('hola1@email.com', $emails->shift());
        $this->assertEquals('hola2@email.com', $emails->shift());
    }

    /** @test */
    public function it_gets_no_email()
    {
        /** @var Cart $cart */
        $cart = factory(Cart::class)->create();

        $emails = $cart->getEmail();

        $this->assertInstanceOf(Collection::class, $emails);
        $this->assertCount(0, $emails);
    }
}
