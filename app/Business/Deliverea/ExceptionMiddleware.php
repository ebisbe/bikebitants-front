<?php

namespace App\Business\Deliverea;

use Closure;
use Deliverea\Exception\CurlException;
use Deliverea\Exception\ErrorResponseException;
use Deliverea\Exception\UnexpectedResponseException;

class ExceptionMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (CurlException $e) {
            $message = $e->getMessage();
        } catch (ErrorResponseException $e) {
            $message = $e->getMessage();
        } catch (UnexpectedResponseException $e) {
            $message = $e->getMessage();
            dd($message);
        }
        abort(500, $message);
    }
}
