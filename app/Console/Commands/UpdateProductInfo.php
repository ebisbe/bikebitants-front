<?php

namespace App\Console\Commands;

use App\Brand;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Woocommerce;

class UpdateProductInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:sync 
                                {file : The CSV file to process.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $file;
    private $batch;

    public function __construct()
    {
        app()->register(ExcelServiceProvider::class);
        app()->bind('Excel', Excel::class);

        parent::__construct();
        $this->batch = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->file = $this->argument('file');
        if (Storage::size($this->file) === 0) {
            $this->error("File size of {$this->file} should not be 0.");
            return false;
        }

        $file = Excel::load('storage/app/' . $this->file);
        $bar = $this->output->createProgressBar(count($file->all()));
        $file->each(function (Collection $csvLine) use ($bar) {
            $this->processBrand($csvLine);
            $bar->advance();
        });


        $bar->finish();
    }

    /**
     * @param Collection $csvLine
     */
    protected function processBrand(Collection $csvLine)
    {
        /** @var Brand $brand */
        try {
            $brand = Brand::whereSlug(str_slug($csvLine->marca))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->error("Model for brand {$csvLine->marca} not found.");
            die;
        }

        $brand->products()->each(function ($product) use ($csvLine) {
            $data = $this->productData($product, $csvLine);
            $this->batch->push($data);
        });

        $this->sendData();
    }

    /**
     * @param $product
     * @param $csvLine
     * @return array
     */
    protected function productData($product, $csvLine): array
    {
        $apiProduct = Woocommerce::get('products/' . $product->external_id);
        return [
            'id' => $product->external_id,
            'weight' => $csvLine->peso,
            'dimensions' => [
                'length' => $csvLine->largo,
                'width' => $csvLine->ancho,
                'height' => $csvLine->alto,
            ],
            'attributes' =>
                array_merge(
                    $apiProduct['attributes'],
                    [
                        [
                            'id' => 10,
                            'variation' => false,
                            'visible' => false,
                            'options' => [$csvLine->email_proveedor]
                        ],
                        [
                            'id' => 11,
                            'variation' => false,
                            'visible' => false,
                            'options' => [$csvLine->direccion_de_recogida]
                        ],
                        [
                            'id' => 12,
                            'variation' => false,
                            'visible' => false,
                            'options' => [$csvLine->direccion_recogida_contrareembolso]
                        ],
                        [
                            'id' => 13,
                            'variation' => false,
                            'visible' => false,
                            'options' => [$csvLine->direccion_de_entrega]
                        ],
                        [
                            'id' => 14,
                            'variation' => false,
                            'visible' => false,
                            'options' => [$csvLine->tiempo_de_entrega]
                        ]
                    ]
                )
        ];
    }

    /**
     * Post product info from a brand to woocommcer
     */
    protected function sendData()
    {
        Woocommerce::post('products/batch', [
            'update' => $this->batch->toArray()
        ]);

        $this->batch = collect();
    }
}
