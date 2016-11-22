<?php

namespace App\Console\Commands;

use App\Business\Services\WordpressService;
use Illuminate\Console\Command;
use Pixelpeter\Woocommerce\Facades\Woocommerce;

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

        $this->info('sync Category:');
        $this->wordpressService->import('products/categories', 'syncCategory');
        $this->info('');

        $this->info('sync Tax:');
        $this->wordpressService->import('taxes', 'syncTax');
        $this->info('');

        $this->info('sync Coupon:');
        $this->wordpressService->import('coupons', 'syncCoupon');
        $this->info('');

        $this->info('sync products:');
        $this->wordpressService->inspector(function($page) {
            $products = collect(Woocommerce::get('products', ['page' => $page]));
            $products->each(function ($product) {
                $this->wordpressService->syncProduct($product);
                $reviews = collect(Woocommerce::get("products/{$product['id']}/reviews"));
                $reviews->each(function ($review) {
                    $this->wordpressService->syncReview($review);
                    echo(',');
                });
                echo('.');
            });
            return $products->count();
        });
    }


}
