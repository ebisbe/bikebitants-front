<?php

namespace App\Business\Integration\WooCommerce\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;
use Woocommerce;
use Storage;

abstract class ApiImporter extends Model implements SynchronizeEntity
{
    protected $wooCommerceCallback;

    const WP_FILE = 'wp_files';
    const WP_DATETIME = 'Y-m-d\TH:i:s\Z';
    const WP_NEW_DATETIME = 'Y-m-d\TH:i:s';

    /** @var  String */
    private $iterator = '.';

    /** @var  String */
    private $page_separator = '+';

    /**
     * @param bool $paginate
     * @param null $parent
     * @param null $child
     * @internal param null $parent_id
     */
    public function import($paginate = true, $parent = null, $child = null)
    {
        $this->inspector(function ($page) use ($parent, $child, $paginate) {
            $elements = collect(Woocommerce::get($this->wooCommerceCallback, ['page' => $page]));
            $hasNextPage = $paginate && Woocommerce::hasNextPage();

            $elements->each(function ($wpEntity) use ($parent, $child) {

                $entity = self::firstOrNew(['external_id' => $wpEntity['id']]);
                $wpEntity['external_id'] = $wpEntity['id'];
                unset($wpEntity['id']);

                $entity->parent_id = $parent->_id ?? '';
                $save = $entity->sync($wpEntity);

                if ($save !== false) {
                    if (!is_null($parent)) {
                        $parent->{$child}()->save($entity);
                        $save = true;
                    } else {
                        $save = $entity->save();
                        $entity->afterSync($wpEntity);
                    }

                    echo $this->iterator;
                }
            });

            return $hasNextPage;
        });
    }

    public function sync($entity)
    {
        $this->fill($entity);
    }

    public function afterSync($entity)
    {
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
     */
    public function inspector($callback)
    {
        $page = 1;
        do {
            echo $this->page_separator;
            $hasNextPage = $callback($page);
            $page++;
        } while ($hasNextPage);
    }

    /**
     * Convert WP date format to a Carbon
     * @param $date
     * @param bool $return_now Whether to return now() or null
     * @return Carbon
     */
    protected function convertDate($date)
    {
        if (is_null($date)) {
            return null;
        }
        try {
            return Carbon::createFromFormat(self::WP_NEW_DATETIME, $date);
        } catch (\InvalidArgumentException $e) {
            return Carbon::createFromFormat(self::WP_DATETIME, $date);
        }
    }

    /**
     * @param $image
     * @return string
     */
    public function saveImage($image)
    {
        try {
            if (!empty($image['src'])) {
                list($url, $name) = $this->encodeSrc($image['src']);
                if (!Storage::exists(self::WP_FILE . '/' . $name)) {
                    Storage::put(self::WP_FILE . '/' . $name, file_get_contents($url . $name));
                }
                return $name;
            }
        } catch (\ErrorException $e) {
            return '';
        }
    }

    /**
     * @param $source
     * @return array
     */
    public function encodeSrc($source)
    {
        $name = basename($source);

        return [str_replace($name, '', $source), urlencode($name)];
    }

}