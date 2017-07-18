<?php

namespace Tests\Feature;

use App\Business\Traits\Tests\ProductTrait;
use App\PaymentMethod;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_doesnt_add_products_to_cart_and_redirects_to_shop()
    {
        $response = $this->get(route('checkout.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('shop.catalogue'));
    }

    /** @test */
    public function it_adds_products_and_see_checkout_page()
    {
        $response = $this->postAndCheckin();

        $response
            ->assertStatus(200)
            ->assertSee('Simple Product')
            ->assertSee('30.00&euro;')
            ->assertSee('x 3');
    }

    /** @test */
    public function it_tries_to_checkout_without_billing_data()
    {
        $this->postAndCheckin();

        $response = $this->post(route('checkout.store'), []);
        $response
            ->assertStatus(302)
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHasErrors(
                [
                    'billing.first_name',
                    'billing.last_name',
                    'billing.email',
                    'billing.phone',
                    'billing.address_1',
                    'billing.city',
                    'billing.postcode',
                    'billing.country',
                    'billing.state'
                ]
            );
    }

    /** @test */
    public function it_fills_with_billing_data_and_submit()
    {
        //assert
        $this->postAndCheckin();
        $data = array_merge(
            $this->fillShippingForm(),
            $this->checkPaymentAndAcceptTerms()
        );

        $storeResponse = $this->post(route('checkout.store'), $data);
        $storeResponse
            ->assertSessionMissing('billing.first_name');

        $this->disableExceptionHandling();

        $response = $this->get(route('checkout.index'));
        $response
            //->assertStatus(200)
            ->assertDontSee('validation.required')
            ->assertSee('Simple Product')
            ->assertSee('10.00&euro;')
            ->assertSee('30.00&euro;')
            ->assertSee('shipping.first_name')
            ->assertSee('shipping.last_name')
            ->assertSee('shipping@email.com')
            ->assertSee('0099123456789')
            ->assertSee('shipping.address_1')
            ->assertSee('shipping.city')
            ->assertSee('shipping.postcode')
            ->assertDontSee('billing.first_name')
            ->assertDontSee('billing.last_name')
            ->assertDontSee('billing@email.com')
            ->assertDontSee('987654321')
            ->assertDontSee('billing.address_1')
            ->assertDontSee('billing.city')
            ->assertDontSee('billing.postcode');
    }

    /** @test */
    public function it_tries_to_checkout_without_shipping_data()
    {
        $this->postAndCheckin();
        $data = array_merge(
            $this->fillBillingForm(),
            $this->checkPaymentAndAcceptTerms(),
            ['check_shipping' => null]
        );

        $response = $this->post(route('checkout.store'), $data);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHasErrors(
                [
                    'shipping.first_name',
                    'shipping.last_name',
                    'shipping.email',
                    'shipping.phone',
                    'shipping.address_1',
                    'shipping.city',
                    'shipping.postcode',
                    'shipping.country',
                    'shipping.state'
                ]
            );
    }

    /** @test */
    public function it_checkouts_with_shipping_data()
    {
        $this->postAndCheckin();

        $data = array_merge(
            $this->fillShippingForm(),
            $this->fillBillingForm(),
            $this->checkPaymentAndAcceptTerms()
        );

        $response = $this->post(route('checkout.index'), $data);

        $response
            ->assertStatus(302);

        $response = $this->get(route('checkout.index'));
        $response
            ->assertDontSee('validation.required')
            ->assertSee('Simple Product')
            ->assertSee('10.00&euro;')
            ->assertSee('30.00&euro;')
            ->assertSee('billing.first_name')
            ->assertSee('billing.last_name')
            ->assertDontSee('billing.email')
            ->assertDontSee('billing.phone')
            ->assertSee('billing.address_1')
            ->assertSee('billing.city')
            ->assertSee('billing.postcode')
            ->assertSee('shipping.first_name')
            ->assertSee('shipping.last_name')
            ->assertSee('shipping@email.com')
            ->assertSee('0099123456789')
            ->assertSee('shipping.address_1')
            ->assertSee('shipping.city')
            ->assertSee('shipping.postcode');
    }

    /** @test */
    public function it_tries_to_checkout_with_invalid_coupon_code()
    {
        $this->postAndCheckin();

        $data = array_merge(
            $this->fillBillingForm(),
            $this->checkPaymentAndAcceptTerms(),
            ['coupon' => 'INVALID']
        );

        $response = $this->post(route('checkout.store'), $data);
        $response
            ->assertStatus(302)
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHasErrors(['coupon']);
    }

    /** @test */
    public function it_checkouts_with_valid_coupon_code()
    {
        $this->postAndCheckin();
        $this->createDiscounts();

        $data = array_merge(
            $this->fillShippingForm(),
            $this->checkPaymentAndAcceptTerms(),
            ['coupon' => 'DISCOUNT10']
        );

        $this->post(route('checkout.store'), $data);

        $response = $this->get(route('checkout.index'));

        $response
            ->assertStatus(200)
            ->assertDontSee('validation.required')
            ->assertSee('Simple Product')
            ->assertSee('discount10')
            ->assertSee('9.00&euro;')
            ->assertSee('27.00&euro;')
            ->assertSee('shipping.first_name')
            ->assertSee('shipping.last_name')
            ->assertSee('shipping@email.com')
            ->assertSee('123456789')
            ->assertSee('shipping.address_1')
            ->assertSee('shipping.city')
            ->assertSee('shipping.postcode')
            ->assertDontSee('billing.first_name')
            ->assertDontSee('billing.last_name')
            ->assertDontSee('billing.email')
            ->assertDontSee('billing.phone')
            ->assertDontSee('billing.address_1')
            ->assertDontSee('billing.city')
            ->assertDontSee('billing.postcode');
    }

    /** @test */
    public function it_assertSees_google_conversion_id()
    {
        $this->postAndCheckin();

        $data = array_merge(
            $this->fillShippingForm(),
            $this->checkPaymentAndAcceptTerms()
        );

        $this->post(route('checkout.store'), $data);

        $response = $this->get(route('checkout.index'));

        $response
            ->assertStatus(200)
            ->assertDontSee('validation.required')
            ->assertSee('var google_conversion_id = 946537783');
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function postAndCheckin()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->addSimpleProduct(3);
        $this->createZone();
        $this->createCountry();
        $this->createPaymentMethod();

        return $this->get(route('checkout.index'));
    }

    /**
     * @return array
     */
    private function fillBillingForm()
    {
        return [
            'check_billing' => 0,
            'billing' => [
                'first_name' => 'billing.first_name',
                'last_name' => 'billing.last_name',
                'email' => 'billing@email.com',
                'phone' => '987654321',
                'address_1' => 'billing.address_1',
                'city' => 'billing.city',
                'postcode' => 'billing.postcode',
                'country' => 'ES',
                'state' => 'B'
            ]
        ];
    }

    /**
     * @return array
     */
    private function fillShippingForm()
    {
        return [
            'shipping' => [
                'first_name' => 'shipping.first_name',
                'last_name' => 'shipping.last_name',
                'email' => 'shipping@email.com',
                'phone' => '0099123456789',
                'address_1' => 'shipping.address_1',
                'city' => 'shipping.city',
                'postcode' => 'shipping.postcode',
                'country' => 'ES',
                'state' => 'B'
            ],
            'check_billing' => 'true',
            'billing' => [],
        ];
    }

    /**
     * @return array
     */
    private function checkPaymentAndAcceptTerms()
    {
        return [
            'payment' => 'bank-transfer',
            'checkout-terms-conditions' => 1
        ];
    }
}
