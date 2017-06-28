<?php

namespace App\Business\Deliverea;

use App\Business\Deliverea\Exceptions\AddressNotFoundException;
use App\Mail\NotifyProvider;
use App\Notifications\InformProviderToSendSale;
use App\Order;
use Carbon\Carbon;
use App\Cart;
use Deliverea\Model\Address;
use Deliverea\Model\Shipment as DelivereaShipment;
use Deliverea;
use Illuminate\Support\Collection;
use Mail;

/**
 * Class Shipment
 *
 * @package App\Business\Deliverea
 */
class Shipment
{
    /**
     * @var Order
     */
    private $order;

    const ALMOGAVERS = 'BIKEBITANTS ALMOGAVERS';
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
    public function process()
    {
        $this->order
            ->cart()
            ->map(function ($cart) {
                /** @var Cart $cart */
                return $cart->mapCartToParcel();
            })
            ->sortByDesc('volume')
            ->groupBy('hash')
            ->each(function ($group) {
                /** @var Collection $group */
                $parcel = $group->first();

                $shipment = new \App\Shipment();
                if (!empty($parcel->get('collection_address'))) {
                    $shipment = $this->create($shipment, $parcel, $group->count());
                }

                $shipment->order_id = $this->order->_id;
                $shipment->group = $group->toArray();
                $shipment->notify_to = $parcel->get('email_provider')->isNotEmpty() ? $parcel->get('email_provider')->toArray() : null;
                $shipment->save();
                $shipment->notify(new InformProviderToSendSale($this->order->isCashOnDelivery()));
            });
    }

    /**
     * @param $shipment
     * @param $parcel
     * @param $groupCount
     * @return mixed
     */
    public function create($shipment, $parcel, $groupCount)
    {
        $carrier = $this->getCarrier(
            $this->order->isShippingToBarcelona(),
            $parcel->get('collection_address')
        );
        $shipment->carrier_code = $carrier->name();
        $shipment->carrier_service = $carrier->service();

        $from = $this->fromAddress($parcel->get('collection_address'));
        $shipment->from = $from->toArray();

        $to = $this->toAddress($parcel->get('delivery_address'));
        $shipment->to = $to->toArray();

        /** @var Deliverea\Response\NewShipmentResponse $newShipment */
        $newShipment = Deliverea::newShipment(
            $this->createShipment($carrier, $groupCount),
            $from,
            $to
        );
        $shipment->new_shipment = $newShipment->toArray();

        $label = Deliverea::getShipmentLabel($newShipment->getShippingDlvrRef());
        $shipment->label = $label->toArray();

        $collection = Deliverea::newCollection(
            $this->createCollection($carrier, $newShipment, $from),
            $from,
            $to
        );
        $shipment->colleciton = $collection->toArray();

        return $shipment;
    }

    /**
     * @param Carrier $carrier
     * @param $parcel_number
     * @return DelivereaShipment
     * @internal param $is_drop_shipping
     */
    public function createShipment(
        Carrier $carrier,
        $parcel_number
    ): DelivereaShipment {
        $shipment = new DelivereaShipment(
            $parcel_number,
            $this->order->external_id,
            Carbon::now()->toDateString(),
            'custom',
            $carrier->name(),
            $carrier->service()
        );

        if ($this->order->isCashOnDelivery()) {
            $shipment->setCashOnDelivery($this->order->total);
        }
        return $shipment;
    }

    /**
     * @param Carrier $carrier
     * @param Deliverea\Response\NewShipmentResponse $shipment
     * @param Address $from
     * @return Deliverea\Model\Collection
     */
    public function createCollection(
        Carrier $carrier,
        Deliverea\Response\NewShipmentResponse $shipment,
        Address $from
    ): Deliverea\Model\Collection {

        $day = $this->cutOffHour($carrier, $from);

        $collection = new Deliverea\Model\Collection(
            $this->order->external_id,
            $day->toDateString(),
            $carrier->name(),
            $carrier->service(),
            $day->format('H:i'),
            $day->addHours(2)->format('H:i'),
            $shipment->getShippingDlvrRef()
        );
        return $collection;
    }

    /**
     * @param $collection_address
     * @return Address
     */
    public function fromAddress(
        $collection_address
    ): Address {
        return $this->addressData($collection_address);
    }

    /**
     * @param $delivery_address
     * @return Address
     */
    public function toAddress(
        $delivery_address
    ): Address {
        if (!is_null($delivery_address)) {
            return $this->addressData($delivery_address);
        }

        return new Address(
            $this->order->shipping->full_name,
            $this->order->shipping->address,
            $this->order->shipping->city,
            $this->order->shipping->postcode,
            $this->order->shipping->country,
            $this->order->shipping->phone
        );
    }

    /**
     * @param $is_shipping_to_bcn_province
     * @param $collect_address
     * @return Carrier|CorreosExpress|VirtualOperator
     */
    public function getCarrier(
        $is_shipping_to_bcn_province,
        $collect_address
    ): Carrier {
        if ($is_shipping_to_bcn_province && $collect_address == self::ALMOGAVERS) {
            return new CorreosExpress();
        } else {
            return new VirtualOperator();
        }
    }

    /**
     * @param $address_name
     * @return Address
     * @throws AddressNotFoundException
     */
    public function addressData(
        $address_name
    ): Address {
        $addresses = Deliverea::getAddresses()
            ->map(function ($add) {
                $add['name'] = strtolower($add['name']);
                return $add;
            })
            ->where('name', strtolower($address_name));

        if ($addresses->isEmpty()) {
            throw new AddressNotFoundException("Address '{$address_name}' not found in the api.");
        }

        $address = $addresses->first();
        return new Address(
            $address['name'],
            $address['address'],
            $address['city'],
            $address['zip_code'],
            $address['country_code'],
            $address['phone']
        );
    }

    /**
     * @param Carrier $carrier
     * @param Address $from
     * @return Carbon
     * @internal param $cutOffHour
     */
    protected function cutOffHour(
        Carrier $carrier,
        Address $from
    ): Carbon {
        $cutOffHour = Deliverea::getCollectionCutoffHour([
            'zip_code' => $from->getZipCode(),
            'country_code' => $from->getCountryCode(),
            'service_code' => $carrier->service(),
            'carrier_code' => $carrier->name()
        ]);

        list($hour, $minute) = explode(':', $cutOffHour->get('cutoff'));

        $day = Carbon::now();
        $compareDay = Carbon::now()->hour(15)->minute(0);
        if ($day->greaterThan($compareDay)) {
            $day->addDay();
        }
        if ($day->isWeekend()) {
            $day->nextWeekday();
        }

        $day->hour($hour)->subHours(2)->minute($minute);
        return $day;
    }
}
