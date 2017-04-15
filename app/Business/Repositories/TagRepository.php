<?php
namespace App\Business\Repositories;

use App\Business\Models\Shop\Tag;
use Rinvex\Repository\Repositories\EloquentRepository;

class TagRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.tag';

    protected $model = Tag::class;
}
