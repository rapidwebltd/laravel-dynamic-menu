<?php

namespace RapidWeb\LaravelDynamicMenu\Models;

use Illuminate\Database\Eloquent\Model;
use RapidWeb\LaravelDynamicMenu\Interfaces\Menuable;

class MenuItem extends Model
{
    protected $table = 'ldm_menu_items';
    protected $with = ['menuItems', 'menuable'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menuItems()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('display_order')->orderBy('id')->with('menuItems')->with('menuable');
    }

    public function menuable()
    {
        return $this->morphTo();
    }

    public function add(string $name, Menuable $menuable = null)
    {
        return $this->menu->add($name, $menuable, $this->id);
    }

    public function url()
    {
        return $this->menuable ? $this->menuable->getMenuUrl() : '';
    }
}
