<?php

namespace App\Business\Checkout\Status;

interface Status
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index();
}
