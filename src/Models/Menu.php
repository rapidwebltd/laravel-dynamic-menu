<?php

namespace RapidWeb\LaravelDynamicMenu\Models;

use Illuminate\Database\Eloquent\Model;
use RapidWeb\LaravelDynamicMenu\Interfaces\Menuable;

class Menu extends Model
{
    protected $table = 'ldm_menus';
    protected $with = ['menuItems'];

    private $renderOptions = [];

    public function allMenuItems()
    {
        return $this->hasMany(MenuItem::class)->orderBy('display_order');
    }

    public function menuItems()
    {
        return $this->allMenuItems()->where('parent_id', 0)->with('menuItems');
    }

    public function add($name, Menuable $menuable = null, $parent_id = 0)
    {
        $menuItem = new MenuItem();
        $menuItem->menu_id = $this->id;
        $menuItem->parent_id = $parent_id;
        $menuItem->name = $name;

        if ($menuable) {
            $menuItem->menuable_id = $menuable->id;
            $menuItem->menuable_type = get_class($menuable);
        }

        $menuItem->save();

        return $menuItem;
    }

    public function clear()
    {
        foreach ($this->allMenuItems as $menuItem) {
            $menuItem->delete();
        }
    }
}
