<?php

use Illuminate\Contracts\Console\Kernel;
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

    protected function link($url)
    {
        return $this->baseUrl . '/' . $url;
    }
}
