<?php
namespace RapidWeb\LaravelDynamicMenu\Models;

use DOMElement;
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
        foreach($this->menuItems as $menuItem) {
            $menuItem->delete();
        }
    }

    public function render()
    {
        $ul = new DOMElement('ul');

        $this->renderMenuItems($ul, $this->menuItems);

        return (new DOMDocument('1.0'))->saveHTML($ul);
    }

    private function renderMenuItems(DOMElement $ul, $menuItems)
    {
        foreach($menuItems as $item) {
            
            if ($this->menuable) {
                $li = new DOMElement('li');
                $a = new DOMElement('a', $item->name);
                $a->setAttribute('href', $item->menuable->getMenuUrl());
                $a->appendChild($li);
            } else {
                $li = new DOMElement('li', $item->name);
            }

            if ($item->menuItems) {
                $newUl = new DOMElement('ul');
                $li->appendChild($newUl);
                $this->renderMenuItems($newUl, $item->menuItems);
            }

            $ul->appendChild($ul);
        }
    }
}