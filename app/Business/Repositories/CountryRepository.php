<?php
namespace App\Business\Repositories;

use App\Country;
use Rinvex\Repository\Repositories\EloquentRepository;

class CountryRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.country';

    protected $model = Country::class;
}
