<?php

namespace App\Business\Admin;

class Title
{

    var $title = '';
    var $use_left_arrow = false;

    /**
     * @param $title
     */
    public function set($title)
    {
        $this->title = $title;
    }

    /**
     * @param $title
     */
    public function setSemiBold($title)
    {
        $this->title = '<span class="text-semibold" >' . $title . '</span >';
    }

    /**
     * @param $bool
     * @throws \Exception
     */
    public function useLeftArrow($bool)
    {
        if (!is_bool($bool)) {
            throw new \Exception('This value should be a boolean');
        }
        $this->use_left_arrow = $bool;
    }

    /**
     * @return string
     */
    public function getLeftArrow()
    {
        if ($this->use_left_arrow) {
            return '<i class="icon-arrow-left52 position-left"></i>';
        }
        return '';
    }

    /**
     * Renders the title with all the settings
     * @return string
     */
    public function render()
    {
        return $this->getLeftArrow().$this->title;
    }
}
