<?php

namespace App\Console\Commands;

use App\Business\Integration\Wordpress\Customer;
use App\Business\Integration\Wordpress\Exception\EntityNotFoundException;
use App\Business\Integration\Wordpress\Factory;
use App\Business\Services\WordpressService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class WordpressSync extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'wp:sync {--entity=*}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Syncronize website with wordpress data.';

    /** @var  WordpressService $wordpressService */
    protected $wordpressService;

    public function handle()
    {

        $entities = $this->getEntitiesToSync();
        $entities->each(function ($entityName) {

            try {
                $class = Factory::make($entityName);
                $this->info("Sync $entityName:");
                $class->import();
                $this->info('');
            } catch (EntityNotFoundException $e) {
                $this->error($e->getMessage());
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
}
