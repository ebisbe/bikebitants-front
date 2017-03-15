<?php

namespace App\Console\Commands;

use App\Business\Services\WordpressService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Pixelpeter\Woocommerce\Facades\Woocommerce;

class WordpressSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:sync {--entity=*}';

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

        $entities = $this->getEntitiesToSync();
        $entities->each(function ($name) {
            $method_name = "sync" . ucfirst($name);

            if (method_exists($this, $method_name)) {
                $this->info("Sync $name:");
                $this->$method_name();
                $this->info('');
            } else {
                $this->error("Entity $name not found.");
            }
        });
    }

    /**
     * By default returns all entities to sync
     * @return Collection
     */
    protected function getEntitiesToSync(): Collection
    {
        $entities = $this->option('entity');

        if (!empty($entities)) {
            return collect($entities);
        }

        return collect(['Customer', 'Product', 'Category', 'Tax', 'Coupon']);
    }

    protected function syncCustomer()
    {
        $this->wordpressService->setWooCommerceCallback('customers');
        $this->wordpressService->import();
    }

    protected function syncCategory()
    {
        $this->wordpressService->setWooCommerceCallback('products/categories');
        $this->wordpressService->setWordpressServiceCallback('syncCategory');
        $this->wordpressService->import();
    }

    protected function syncTax()
    {
        $this->wordpressService->setWooCommerceCallback('taxes');
        $this->wordpressService->import();
    }

    protected function syncCoupon()
    {
        $this->wordpressService->setWooCommerceCallback('coupons');
        $this->wordpressService->import();
    }

    protected function syncProduct()
    {
        $this->wordpressService->inspector(function ($page) {
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
