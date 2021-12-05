<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(MenuItem::class,'menu_id');
    }
}
