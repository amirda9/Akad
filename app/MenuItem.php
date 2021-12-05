<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    protected $guarded = [];

    public function menu_itemable()
    {
        return $this->morphTo();
    }

    public function getRoute()
    {
        if($this->menu_itemable) {
            return $this->menu_itemable->getRoute() ?: '';
        } else {
            return $this->link ?: '';
        }
    }

    public function getLevelAttribute()
    {
        $level = 0;
        $parent = $this->parent;
        while($parent) {
            $level++;
            $parent = $parent->parent;
        }
        return $level;
    }

    public function getTypeTitle()
    {
        switch ($this->menu_itemable_type) {
            case 'App\ProductCategory': {
                return 'دسته بندی محصول';
                break;
            }
            case 'App\Page': {
                return 'صفحه';
                break;
            }
            case 'App\ArticleCategory': {
                return 'دسته بندی مقاله';
                break;
            }
            default: {
                return 'لینک';
            }
        }
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
}
