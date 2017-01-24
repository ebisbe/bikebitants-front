<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CheckoutControllerTest extends TestCase
{
    use ProductTrait, DatabaseMigrations;

    /** @test */
    public function dont_add_product_and_redirect_to_shop()
    {
        $this->visit(route('checkout.index'))
            ->seePageIs(route('shop.catalogue'));
    }

    /** @test */
    public function add_product_and_see_checkout()
    {
        $this->postAndCheckin();

        $this->see('Simple Product')
            ->see('30.00€')
            ->see('x 3');
    }

    /** @test */
    public function try_to_checkout_without_billing_data()
    {
        $this->postAndCheckin();

        $this->press('checkout.confirm_order')
            ->see('validation.required');
    }

    /** @test */
    public function fill_billing_data_and_submit()
    {
        $this->postAndCheckin();
        $this->fillBillingForm();
        $this->checkPaymentAndAcceptTerms();

        $this->press('checkout.confirm_order')
            ->dontSee('validation.required')
            ->see('Simple Product')
            ->see('10.00€')
            ->see('30.00€')
            ->see('IVA<span>0')
            ->see('billing.first_name')
            ->see('billing.last_name')
            ->see('billing.email')
            ->see('billing.phone')
            ->see('billing.address_1')
            ->see('billing.city')
            ->see('billing.postcode')
            ->dontSee('shipping.first_name')
            ->dontSee('shipping.last_name')
            ->dontSee('shipping.email')
            ->dontSee('shipping.phone')
            ->dontSee('shipping.address_1')
            ->dontSee('shipping.city')
            ->dontSee('shipping.postcode')
        ;
    }

    /** @test */
    public function try_to_checkout_without_shipping_data()
    {
        $this->postAndCheckin();
        $this->fillBillingForm();
        $this->checkPaymentAndAcceptTerms();

        $this->uncheck('check_shipping');

        $this->press('checkout.confirm_order')
            ->see('validation.required');
    }

    /** @test */
    public function try_to_checkout_with_shipping_data()
    {
        $this->postAndCheckin();
        $this->fillBillingForm();
        $this->fillShippingForm();
        $this->checkPaymentAndAcceptTerms();

        $this->press('checkout.confirm_order')
            ->dontSee('validation.required')
            ->see('Simple Product')
            ->see('10.00€')
            ->see('30.00€')
            ->see('IVA<span>0')
            ->see('billing.first_name')
            ->see('billing.last_name')
            ->dontSee('billing.email')
            ->dontSee('billing.phone')
            ->see('billing.address_1')
            ->see('billing.city')
            ->see('billing.postcode')
            ->see('shipping.first_name')
            ->see('shipping.last_name')
            ->see('shipping.email')
            ->see('shipping.phone')
            ->see('shipping.address_1')
            ->see('shipping.city')
            ->see('shipping.postcode');
    }

    /** @test */
    public function try_to_checkout_with_invalid_coupon_code()
    {
        $this->postAndCheckin();
        $this->createDiscounts();

        $this->fillBillingForm();
        $this->checkPaymentAndAcceptTerms();
        $this->type('INVALIDCOUPON', 'coupon');

        $this->press('checkout.confirm_order')
            ->see('validation.exists')
        ;
    } /** @test */
    public function try_to_checkout_with_valid_coupon_code()
    {
        $this->postAndCheckin();
        $this->createDiscounts();

        $this->fillBillingForm();
        $this->checkPaymentAndAcceptTerms();
        $this->type('DISCOUNT10', 'coupon');


        $this->press('checkout.confirm_order')
            ->dontSee('validation.required')
            ->see('Simple Product')
            ->see('DISCOUNT10')
            ->see('9.00€')
            ->see('27.00€')
            ->see('IVA<span>0')
            ->see('billing.first_name')
            ->see('billing.last_name')
            ->see('billing.email')
            ->see('billing.phone')
            ->see('billing.address_1')
            ->see('billing.city')
            ->see('billing.postcode')
            ->dontSee('shipping.first_name')
            ->dontSee('shipping.last_name')
            ->dontSee('shipping.email')
            ->dontSee('shipping.phone')
            ->dontSee('shipping.address_1')
            ->dontSee('shipping.city')
            ->dontSee('shipping.postcode')
        ;
    }

    public function postAndCheckin()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->addSimpleProduct(3);

        $this->visit(route('checkout.index'));
    }

    public function fillBillingForm()
    {
        $this->type('billing.first_name', 'billing[first_name]')
            ->type('billing.last_name', 'billing[last_name]')
            ->type('billing.email', 'billing[email]')
            ->type('billing.phone', 'billing[phone]')
            ->type('billing.address_1', 'billing[address_1]')
            ->type('billing.city', 'billing[city]')
            ->type('billing.postcode', 'billing[postcode]');
    }

    public function fillShippingForm()
    {
        $this->uncheck('check_shipping')
            ->type('shipping.first_name', 'shipping[first_name]')
            ->type('shipping.last_name', 'shipping[last_name]')
            ->type('shipping.email', 'shipping[email]')
            ->type('shipping.phone', 'shipping[phone]')
            ->type('shipping.address_1', 'shipping[address_1]')
            ->type('shipping.city', 'shipping[city]')
            ->type('shipping.postcode', 'shipping[postcode]');
    }

    public function checkPaymentAndAcceptTerms()
    {
        $this->select('bank-transfer', 'payment')
            ->check('checkout-terms-conditions');
    }
}
