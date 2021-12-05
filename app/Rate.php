<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'rates';
    protected $guarded = [];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function getTitleAttribute()
    {
        $model = $this->rateable;
        if ($model) {
            switch ($this->rateable_type) {
                case 'App\Product':
                case 'App\Article' : {
                    return str_limit($model->title,60);
                }
                default: {
                    return '';
                }
            }
        } else {
            return '---';
        }
    }

    public function getRouteAttribute()
    {
        $model = $this->rateable;
        if($model) {
            switch ($this->rateable_type) {
                case 'App\Product' :
                case 'App\Article' : {
                    return $model->getRoute();
                }
                default: {
                    return '';
                }
            }
        } else {
            return '';
        }
    }
}
