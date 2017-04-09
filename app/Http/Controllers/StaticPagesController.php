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

        return response()
            ->view('staticPages.who_we_are', compact('title', 'subtitle'))
            ->header('Cache-control', 'public')
            ->setTtl(60*60*24);
    }

    public function termsAndConditions()
    {
        $title = 'Bikebitants';
        $subtitle = 'Terminos y Condiciones';

        Breadcrumbs::addCrumb('Terminos y Condiciones');

        return response()
            ->view('staticPages.terms_conditions', compact('title', 'subtitle'))
            ->header('Cache-control', 'public')
            ->setTtl(60*60*24);
    }

    public function socialCommitment()
    {
        $title = 'Bikebitants';
        $subtitle = 'Compromiso Social';

        Breadcrumbs::addCrumb('Compromiso Social');

        return response()
            ->view('staticPages.social_commitment', compact('title', 'subtitle'))
            ->header('Cache-control', 'public')
            ->setTtl(60*60*24);
    }

    public function incentives()
    {
        $title = 'Bikebitants';
        $subtitle = 'Incentivos para empresas';

        Breadcrumbs::addCrumb('Incentivos para empresas');

        return response()
            ->view('staticPages.incentives', compact('title', 'subtitle'))
            ->header('Cache-control', 'public')
            ->setTtl(60*60*24);
    }

    public function press()
    {
        $title = 'Bikebitants';
        $subtitle = 'Prensa';

        Breadcrumbs::addCrumb('Prensa');

        return response()
            ->view('staticPages.press', compact('title', 'subtitle'))
            ->header('Cache-control', 'public')
            ->setTtl(60*60*24);
    }

    public function faq()
    {
        $title = 'Bikebitants';
        $subtitle = trans('static.faq');

        Breadcrumbs::addCrumb(trans('static.faq'));

        return response()
            ->view('staticPages.faq', compact('title', 'subtitle'))
            ->header('Cache-control', 'public')
            ->setTtl(60*60*24);
    }
}
