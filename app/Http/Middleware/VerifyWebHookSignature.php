<?php

namespace App\Http\Middleware;

use App\Business\Integration\WooCommerce\WebHook;
use Closure;

class VerifyWebHookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $signature = $request->header('x-wc-webhook-signature');

        if (!is_null($signature)) {
            $hook = new WebHook();
            $payload = $request->getContent();

            $hook->verifyPayload($payload, $signature);
        } else {
            // Has no signature but may be the test on a webhook creation of update parameters
            $webhook_id = (int)$request->get('webhook_id');
            if (!is_integer($webhook_id)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
