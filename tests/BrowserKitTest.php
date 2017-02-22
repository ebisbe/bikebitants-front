<?php

use App\Business\Traits\DatabaseSetup;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTest extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $app->setLocale('fake');
        //disabled FALLBACK_LOCALE through phpunit env variables. All translation return their code

        return $app;
    }

    protected function refreshApplication()
    {
        parent::refreshApplication();

        $this->artisan('migrate');
    }

    protected function link($url)
    {
        return $this->baseUrl . '/' . $url;
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler
        {
            public function __construct()
            {
            }

            public function report(Exception $e)
            {
            }

            public function render($request, Exception $e)
            {
                throw $e;
            }
        });
    }
}
