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

    public function termsAndConditions()
    {
        $title = 'Bikebitants';
        $subtitle = 'Terminos y Condiciones';

        Breadcrumbs::addCrumb('Terminos y Condiciones');

        return view('staticPages.terms_conditions', compact('title', 'subtitle'));
    }

    public function socialCommitment()
    {
        $title = 'Bikebitants';
        $subtitle = 'Compromiso Social';

        Breadcrumbs::addCrumb('Compromiso Social');

        return view('staticPages.social_commitment', compact('title', 'subtitle'));
    }

    public function incentives()
    {
        $title = 'Bikebitants';
        $subtitle = 'Incentivos para empresas';

        Breadcrumbs::addCrumb('Incentivos para empresas');

        return view('staticPages.incentives', compact('title', 'subtitle'));
    }

    public function press()
    {
        $title = 'Bikebitants';
        $subtitle = 'Prensa';

        Breadcrumbs::addCrumb('Prensa');

        return view('staticPages.press', compact('title', 'subtitle'));
    }
}
