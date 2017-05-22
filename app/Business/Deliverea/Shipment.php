<?php

namespace App\Business\Deliverea;

use App\Order;
use Carbon\Carbon;
use Deliverea\Model\Address;
use Deliverea\Model\Shipment as DelivereaShipment;
use Deliverea;

/**
 * Class Shipment
 *
 * OV es no Catalunya no contrareembolso
 * Correos Express es Catalunya i/o contrareembolso solo productos stock
 *
 * @package App\Business\Deliverea
 */
class Shipment
{
    /**
     * @var Order
     */
    private $order;

    /**
     * Shipment constructor.
     * @param Order $order
     */
    public function order(Order $order)
    {
        $this->order = $order;
    }

    /**
     *
     */
    public function new()
    {
        // each -> cart ( $product )
        try {
            /** @var Deliverea\Response\NewShipmentResponse $shipment */
            $shipment = Deliverea::newShipment($this->createShipment(), $this->fromAddress(), $this->toAddress());
        } catch (\Deliverea\Exception\ErrorResponseException $e) {
            dd($e);
        }

        //Get Label
        $label = Deliverea::getShipmentLabel($shipment->getShippingDlvrRef());
    }

    /**
     * //WIDE HIGH LONG WEIGHT
     * @return DelivereaShipment
     */
    public function createShipment(): DelivereaShipment
    {
        return new DelivereaShipment(
            1,
            substr(md5(strtotime('now')), 0, 14),
            Carbon::now()->toDateString(),
            'custom',
            'ovirtual',
            'ovirtual-servicio-19'
        );
    }

    /**
     * //pick_up_add
     * //pick_up_add_drop_shipping
     * //delivery_add
     * //Cat / no CAT
     * @return Address
     */
    public function fromAddress(): Address
    {
        return new Address(
            'Full Name',
            'Address',
            'City',
            '08105',
            'ES',
            'Phone'
        );
    }

    /**
     * //pick_up_add
     * //pick_up_add_drop_shipping
     * //delivery_add
     * //Cat / no CAT
     * @return Address
     */
    public function toAddress(): Address
    {
        return new Address(
            'Full Name',
            'Address',
            'City',
            '08105',
            'ES',
            'Phone'
        );
    }

    /**
     * @param $is_dropshipping
     * @param $is_cash_on_delivery
     * @param $is_shipping_to_cat
     * @return Carrier
     */
    public function getCarrier($is_dropshipping, $is_cash_on_delivery, $is_shipping_to_cat): Carrier
    {
        switch (true) {
            // CASE 1
            case !$is_dropshipping && !$is_cash_on_delivery && !$is_shipping_to_cat:
                //CASE 2
            case $is_dropshipping && !$is_cash_on_delivery:
                return new VirtualOperator();

            // CASE 4a
            case !$is_dropshipping && !$is_cash_on_delivery && $is_shipping_to_cat:
                // CASE 4b
            case !$is_dropshipping && $is_cash_on_delivery:
                //CASE 5
            case $is_dropshipping && $is_cash_on_delivery:
                return new CorreosExpress();
        }
    }
}
