<?php

namespace App\Business\Status;

interface Status
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index();
}
