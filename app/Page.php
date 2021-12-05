<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $guarded = [];

    public function scopePublished($query)
    {
        $query->where('published',true);
    }
    public function scopeSlug($query, $slug)
    {
        $query->where('slug',$slug);
    }

    public function menu_item()
    {
        return $this->morphOne(MenuItem::class, 'menu_itemable');
    }

    public function getRoute()
    {
        return route('pages.show',$this->slug);
    }
    public function getApplicationRoute()
    {
        return route('application.pages.show',$this->slug);
    }
}
