<?php

namespace Tests\Feature;

use App\Mail\NotifyProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailTest extends TestCase
{
    /** @test */
    public function send_email()
    {
        $email = new NotifyProvider(
            [
                ['name' => 'Product 1', 'attributes' => 'blab,bla', 'quantity' => 1],
                ['name' => 'Product 2', 'attributes' => 'blab,bla', 'quantity' => 2],
                ['name' => 'Product 3', 'attributes' => 'blab,bla', 'quantity' => 3],
                ['name' => 'Product 4', 'attributes' => 'blab,bla', 'quantity' => 41]
            ],
            1,
            [
                'full_name' => 'randomtext',
                'phone' => 'randomtext',
                'address' => 'randomtext',
                'city' => 'randomtext',
                'postcode' => 'randomtext',
            ]
        );
        \Mail::to(['enricu@gmail.com', 'adria.bisbe@gmail.com'])->send($email);
    }
}
