<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Breadcrumbs;

class StaticPagesController extends Controller
{

    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        Breadcrumbs::setCssClasses('breadcrumb');
        Breadcrumbs::setListElement('ol');
        Breadcrumbs::setDivider('');
        Breadcrumbs::addCrumb('Home', route('shop.home'));
    }

    public function whoWeAre()
    {
        $title = 'Bikebitants';
        $subtitle = 'Quienes somos';

        Breadcrumbs::addCrumb('Quienes somos');

        return view('staticPages.who_we_are', compact('title', 'subtitle'));
    }
}
