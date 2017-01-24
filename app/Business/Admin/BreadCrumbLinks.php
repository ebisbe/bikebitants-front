<?php

namespace App\Business\Admin;

class BreadCrumbLinks
{
    /** @var \Illuminate\Support\Collection|null */
    var $links = null;
    var $render = false;

    /** @param string $class */
    var $cssClass = 'breadcrumb-elements';
    /** @param string $listType */
    var $listType = 'ul';
    /** @param boolean $lastElementWithoutLink */
    var $lastElementWithoutLink = false;

    /**
     * BreadCrumbLinks constructor.
     */
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

    /**
     * Define the main css clas for the breadcrumb list
     * @param $cssClass
     */
    public function setCssClasses($cssClass)
    {
        $this->cssClass = $cssClass;
    }

    /**
     * Define the list type for the breadcrumb list
     * @param $listType
     */
    public function setListType($listType)
    {
        $this->listType = $listType;
    }

    /**
     * Define whether the last element should or not should have a link independently that has href property
     * @param $lastElementWithoutLink
     */
    public function setLastElementWithoutLink($lastElementWithoutLink)
    {
        $this->lastElementWithoutLink = $lastElementWithoutLink;
    }

    public function getDefaultParameters()
    {
        return [
            'href' => '',
            'li_class' => '',
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
     * Render all the links from the collection. Last element can be set to not have a link
     * @return string
     */
    public function render()
    {
        if (!$this->render) {
            return '';
        }
        if ($this->lastElementWithoutLink) {
            $last = $this->links->count() - 1;
        } else {
            $last = -1;
        }

        $links = $this->links
            ->map(function ($value, $key) use ($last) {
                if ($value['href'] && $key != $last) {
                    $text = "<a href='{$value['href']}' class='{$value['class']}'>{$value['value']}</a>";
                } else {
                    $text = $value['value'];
                    $value['li_class'] = 'active';
                }

                return "<li class='{$value['li_class']}'>$text</li>";
            })
            ->implode('');

        return '<' . $this->listType . ' class="' . $this->cssClass . '">' . $links . '</' . $this->listType . '>';
    }
}
