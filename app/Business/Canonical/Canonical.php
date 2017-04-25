<?php

namespace App\Business\Canonical;

class Canonical
{
    private $link;

    public function set($link)
    {
        $this->link = $link;
    }

    public function render()
    {
        if (!is_null($this->link)) {
            return '<link rel="canonical" href="' . $this->link . '">';
        }
    }
}
