<?php
namespace RapidWeb\LaravelDynamicMenu\Models;

use DOMDocument;
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

    public function topLevelMenuItems()
    {
        return $this->menuItems()->where('parent_id', 0);
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
        $domDoc = new DOMDocument('1.0');

        $ul = new DOMElement('ul');
        $domDoc->appendChild($ul);

        $this->renderMenuItems($ul, $this->topLevelMenuItems);

        return $domDoc->saveHTML($ul);
    }

    private function renderMenuItems(DOMElement $ul, $menuItems)
    {
        foreach($menuItems as $item) {
            
            $li = new DOMElement('li');
            $ul->appendChild($li);
            
            $a = new DOMElement('a', htmlspecialchars($item->name));
            $li->appendChild($a);

            if ($item->menuable) {
                $a->setAttribute('href', $item->menuable->getMenuUrl());
            }          

            if (count($item->menuItems)>0) {
                $newUl = new DOMElement('ul');
                $li->appendChild($newUl);
                $this->renderMenuItems($newUl, $item->menuItems);
            }
        }
    }
}