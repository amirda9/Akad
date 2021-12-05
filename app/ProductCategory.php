<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
    protected $guarded = [];

    public function menu_item()
    {
        return $this->morphOne(MenuItem::class, 'menu_itemable');
    }

    public function getLevelAttribute()
    {
        $category = $this;
        $level = 0;
        while($category->parent){
            $level++;
            $category = $category->parent;
        }
        return $level;
    }

    public function getRoute()
    {
        return route('category.show',$this->slug);
    }

    public function parent()
    {
        return $this->belongsTo('App\ProductCategory','parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\ProductCategory','parent_id');
    }

    public function hasParent($parent_id)
    {
        if($parent_id == null) {
            return false;
        }
        if($this->parent_id == null) {
            return false;
        }
        if($this->parent_id == $parent_id) {
            return true;
        }
        return $this->parent->hasParent($parent_id);
    }


    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'category_product',
            'category_id',
            'product_id'
        );
    }

}
