<?php

namespace RapidWeb\LaravelDynamicMenu\Models;

use RapidWeb\LaravelDynamicMenu\Interfaces\Menuable;

class MenuItemLink implements Menuable
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getMenuUrl()
    {
        return $this->url;
    }
}
