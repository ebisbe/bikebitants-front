<?php

namespace App\Console\Commands;

use App\Business\Services\WordpressService;
use Illuminate\Console\Command;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Psy\Exception\ErrorException;

class WordpressSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize website with wordpress data.';

    /** @var  WordpressService $wordpressService */
    protected $wordpressService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param WordpressService $wordpressService
     */
    public function handle(WordpressService $wordpressService)
    {
        $this->wordpressService = $wordpressService;

        $this->import('products/categories', 'syncCategory');
        $this->import('taxes', 'syncTax');
        $this->import('coupons', 'syncCoupon');

        $this->inspector(function($page) {
            $products = collect(Woocommerce::get('products', ['page' => $page]));
            $products->each(function ($product) {
                $this->wordpressService->importProduct($product);
                $reviews = collect(Woocommerce::get("products/{$product['id']}/reviews"));
                $reviews->each(function ($review) {
                    $this->wordpressService->importReview($review);
                    echo(',');
                });
                echo('.');
            });
            return $products->count();
        }, 'sync products:');
    }

    public function import($wooCommerceCallback, $wordpressServiceCallback) {
        $this->inspector(function($page) use ($wooCommerceCallback, $wordpressServiceCallback) {
            $categories = collect(Woocommerce::get($wooCommerceCallback, ['page' => $page]));
            $categories->each(function ($element) use ($wordpressServiceCallback) {
                if(method_exists($this->wordpressService, $wordpressServiceCallback)) {
                    $this->wordpressService->$wordpressServiceCallback($element);
                }
                echo('.');
            });
            return $categories->count();
        }, $wordpressServiceCallback);
    }

    /**
     * @param $callback
     * @param string $text
     */
    public function inspector($callback, $text = '')
    {
        $this->info($text);
        $page = 1;
        do {
            echo('+');
            $totalItems = $callback($page);
            $page ++;
        } while ($totalItems > 0);
        $this->info('');
    }
}
