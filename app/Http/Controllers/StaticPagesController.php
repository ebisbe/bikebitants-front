<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Breadcrumbs;
use MetaTag;

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

        MetaTag::set('title', 'Quienes somos | Bikebitants');
        MetaTag::set('description', 'Somos una joven startup que quiere potenciar ciudades más sanas a través del fomento de una movilidad más sostenible.');
        MetaTag::set('image', assetCDN('/images/EquipoBikebitants.jpg'));

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
