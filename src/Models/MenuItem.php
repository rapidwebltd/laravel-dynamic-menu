<?php
namespace RapidWeb\LaravelDynamicMenu\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'ldm_menus';

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'id', 'parent_id');
    }

    public function menuable()
    {
        return $this->morphTo();
    }
}