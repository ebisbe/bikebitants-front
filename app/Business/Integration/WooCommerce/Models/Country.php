<?php
namespace App\Business\Integration\WooCommerce\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Country
 * @package App\Business\Integration\WooCommerce\Models
 *
 * @property State states
 */
class Country extends Model
{
    protected $casts = ['active' => 'boolean'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function states()
    {
        return $this->embedsMany(State::class);
    }

}
