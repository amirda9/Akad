<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $table = 'article_categories';
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
        return route('mag.categories.show',$this->slug);
    }

    public function parent()
    {
        return $this->belongsTo('App\ArticleCategory','parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\ArticleCategory','parent_id');
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


    public function articles()
    {
        return $this->belongsToMany(
            Article::class,
            'article_category',
            'category_id',
            'article_id'
        );
    }

}
