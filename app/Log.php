<?php

namespace App;

use App\Logs\ProductLog;
use App\Logs\VariationLog;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $guarded = [];

    static $types = [
        'product' => ProductLog::class,
        'variation' => VariationLog::class,
    ];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOldModel() {
        return json_decode($this->old_model);
    }
    public function getNewModel() {
        return json_decode($this->new_model);
    }

}
