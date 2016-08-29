<?php

namespace App\Console\Commands;

use Appzcoder\CrudGenerator\Commands\CrudCommand;

class CrudCommandCustom extends CrudCommand
{

    protected function addRoutes()
    {
        $routes = ["Route::get('" . $this->routeName . "/data-table', '" . $this->controller . "@dataTable')->name('" . $this->routeName . ".data-table');"];
        return array_merge($routes, parent::addRoutes());
    }
}
