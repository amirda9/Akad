<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $table = 'transactions';
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
