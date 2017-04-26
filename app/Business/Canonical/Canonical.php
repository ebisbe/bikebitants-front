<?php

namespace App\Business\Canonical;

use Illuminate\Http\Request;

class Canonical
{
    private $link;

    /**
     * @param $link
     */
    public function byLink($link)
    {
        $this->link = $link;
    }

    /**
     * @param Request $request
     */
    public function byRequest(Request $request)
    {
        if ($request->getQueryString()) {
            $this->byLink($request->url());
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        if (!is_null($this->link)) {
            return '<link rel="canonical" href="' . $this->link . '">';
        }
    }
}
