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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(WordpressService $wordpressService)
    {
        $this->wordpressService = $wordpressService;

        $this->inspector(function($page) {
            $categories = collect(Woocommerce::get('products/categories', ['page' => $page]));
            $categories->each(function ($category) {
                $this->wordpressService->syncCategory($category);
                echo('.');
            });
            return $categories->count();
        }, 'sync categories:');

        $this->inspector(function($page) {
            $products = collect(Woocommerce::get('products', ['page' => $page]));
            $products->each(function ($product) {
                $this->wordpressService->importFromWordpress($product);
                echo('.');
            });
            return $products->count();
        }, 'sync products:');
    }

    public function inspector($callback, $text = '')
    {
        $this->info($text);
        $page = 1;
        do {
            echo('-');
            $totalItems = $callback($page);
            $page ++;
        } while ($totalItems > 0);
        $this->info('');
    }
}
