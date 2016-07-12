<?php

namespace App\Business\Admin;

class BreadCrumbLinks
{
    /** @var \Illuminate\Support\Collection|null */
    var $links = null;
    var $render = false;

    public function __construct()
    {
        $this->links = collect();
    }

    /**
     * Set a new link for the BreadCrumbLinks
     * @param $parameters
     */
    public function set($parameters)
    {
        $this->links->push(array_merge($this->getDefaultParameters(), $parameters));
        $this->render = true;
    }

    public function getDefaultParameters()
    {
        return [
            'href' => '',
            'li_class' => 'active',
            'class' => '',
            'value' => ''
        ];
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
     * @param string $class
     * @param string $listType
     * @return string
     */
    public function render($class = 'breadcrumb-elements', $listType = 'ul')
    {
        if (!$this->render) {
            return '';
        }
        $links = $this->links
            ->map(function ($value, $key) {
                if($value['href']) {
                    $text = "<a href='{$value['href']}' class='{$value['class']}'>{$value['value']}</a>";
                } else {
                    $text = $value['value'];
                }

                return "<li class='{$value['li_class']}'>$text</li>";
            })
            ->implode('');

        return '<' . $listType . ' class="' . $class . '">' . $links . '</' . $listType . '>';
    }
}