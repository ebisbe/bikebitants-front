<?php

namespace App\Business\Integration\Wordpress;

use Carbon\Carbon;
use Woocommerce;
use StaticVars;

abstract class Importer implements SynchronizeEntity
{
    protected $wooCommerceCallback;

    /** @var  String */
    private $iterator = '.';

    /** @var  String */
    private $page_separator = '+';

    /**
     * @param bool $paginate
     */
    public function import($paginate = true)
    {
        $this->inspector(function ($page) {
            $elements = collect(Woocommerce::get($this->wooCommerceCallback, ['page' => $page]));
            $elements->each(function ($element) {
                $this->sync($element);
                echo $this->iterator;
            });
            return $elements->count();
        }, $paginate);
    }

    /**
     * @param $callback
     */
    public function wooCommerceCallback($callback)
    {
        $this->wooCommerceCallback = $callback;
    }

    /**
     * Set a new iterator value
     * @param $iterator
     */
    public function iterator($iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @param $page_separator
     */
    public function pageSeparator($page_separator)
    {
        $this->page_separator = $page_separator;
    }

    /**
     * @param $callback
     * @param bool $paginate
     */
    public function inspector($callback, $paginate = true)
    {
        $page = 1;
        do {
            echo $this->page_separator;
            $totalItems = $callback($page);
            if (!$paginate) {
                break;
            }
            $page++;
        } while ($totalItems > 0);
    }

    /**
     * Convert WP date format to a Carbon
     * @param $date
     * @return Carbon
     */
    protected function convertDate($date)
    {
        if (is_null($date)) {
            return Carbon::now();
        }
        return Carbon::createFromFormat(StaticVars::wordpressDateTime(), $date);
    }
}