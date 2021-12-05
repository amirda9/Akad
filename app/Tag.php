<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $guarded = [];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function getRoute()
    {
        return route('tags', $this->id);
    }
}
