<?php
namespace RapidWeb\LaravelDynamicMenu\Models;

use Illuminate\Database\Eloquent\Model;
use RapidWeb\LaravelDynamicMenu\Interfaces\Menuable;

class Menu extends Model
{
    protected $table = 'ldm_menus';

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function add($name, Menuable $menuable = null, $parent_id = 0)
    {
        $menuItem = new MenuItem;
        $menuItem->menu_id = $this->id;
        $menuable->parent_id = $parent_id;
        $menuItem->name = $name;
        
        if ($menuable) {
            $this->menuable_id = $menuable->id;
            $this->menuable_type = get_class($menuable);
        }

        $menuItem->save();
        
        return $menuItem;
    }
}