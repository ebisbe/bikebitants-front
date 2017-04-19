<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use MetaTag;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Abort if entity received is empty
     * @param $entity
     */
    public function abortIfEmpty($entity)
    {
        if (empty($entity)) {
            MetaTag::set('title', trans('exceptions.page_not_found'));
            MetaTag::set('description', trans('exceptions.description'));
            abort(404, trans('exceptions.page_not_found'));
        }
    }
}
