<?php

namespace App\Http\Controllers;

use App\Business\Integration\WooCommerce\Exception\EntityNotFoundException;
use App\Business\Integration\WooCommerce\Exception\InvalidResourceException;
use App\Business\Integration\WooCommerce\Factory;
use App\Business\Integration\WooCommerce\Models\ModelFactory;
use App\Http\Middleware\VerifyWebHookSignature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;

class WooCommerceController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyWebHookSignature::class);
    }

    public function show($command, Request $request)
    {
        if (config('app.env') == 'production') {
            abort(404, 'Not found');
        }

        if ($command == '-') {
            $command = '';
        }

        $response = \Woocommerce::get(
            str_replace('-', '/', $command),
            ['page' => $request->get('page', 1), 'search' => $request->get('search', '')]
        );

        $item = $request->get('item', null);
        if (!is_null($item)) {
            dd($response[$item]);
        } else {
            dd($response);
        }
    }

    public function webhook(Request $request)
    {

        //Log::info($request->header());
        //Log::info($request->getContent());

        $resource = $request->header('x-wc-webhook-resource');
        $event = $request->header('x-wc-webhook-event');

        try {
            $factoryResource = ModelFactory::make($resource)->whereExternalId($request->get('id'));

            switch ($event) {
                case 'created':
                case 'updated':
                    $response = $factoryResource->sync($request->getContent());
                    break;
                case 'deleted':
                    $response = $factoryResource->delete();
                    break;
                default:
                    throw new InvalidResourceException("Invalid resource given '{$resource}'");
            }

            return [$event => $response];
        } catch (EntityNotFoundException $e) {
        } catch (InvalidResourceException $e) {
        }
        return ['error' => $e];
    }
}
