<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $guarded = [];


    public function scopeSeen($query, $value = true)
    {
        $query->where('seen',$value);
    }

}
