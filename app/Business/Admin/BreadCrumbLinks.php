<?php

namespace App\Business\Admin;

class BreadCrumbLinks
{
    /** @var \Illuminate\Support\Collection|null  */
    var $links = null;
    var $render = false;

    public function __construct()
    {
        $this->links = collect();
    }

    /**
     * Set a new link for the BreadCrumbLinks
     * @param $link
     */
    public function set($link)
    {
        $this->links->push(['link' => $link]);
        $this->render = true;
    }

    /**
     * Clear links in case we don't want them
     */
    public function clear()
    {
        $this->links = collect();
    }

    /**
     * Render all the links from the collection
     * @return string
     */
    public function render()
    {
        if (!$this->render) {
            return '';
        }
        return '<ul class="breadcrumb-elements"><li>' . $this->links->implode('link', '</li></li>') . '</li></ul>';
    }
}