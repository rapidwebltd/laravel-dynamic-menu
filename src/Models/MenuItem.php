<?php
namespace RapidWeb\LaravelDynamicMenu\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'ldm_menuitems';

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'id', 'parent_id');
    }

    public function menuable()
    {
        return $this->morphTo();
    }

    public function add($name, Menuable $menuable = null)
    {
        return $this->menu->add($name, $menuable, $this->id);
    }
}