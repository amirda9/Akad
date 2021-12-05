<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = [];


    public function scopePublished($query)
    {
        $query->where('published', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function getTitleAttribute()
    {
        $model = $this->commentable;
        if ($model) {
            switch ($this->commentable_type) {
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
        $model = $this->commentable;
        if($model) {
            switch ($this->commentable_type) {
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
