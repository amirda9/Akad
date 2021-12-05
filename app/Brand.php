<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $guarded = [];

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
        return route('products.all',[
                'brands' => [$this->id]
            ]);
    }

    public function products()
    {
        return $this->hasMany(Product::class,'brand_id');
    }
}
