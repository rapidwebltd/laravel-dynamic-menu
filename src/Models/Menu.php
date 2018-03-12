<?php
namespace RapidWeb\LaravelDynamicMenu\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'ldm_menus';

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}