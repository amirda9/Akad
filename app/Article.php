<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $guarded = [];

    public function scopePublished($query, $slug = null)
    {
        if ($slug != null) {
            return $query->where('slug', $slug)->where('published', true);
        }
        return $query->where('published', true);
    }

    public function categories()
    {
        return $this->belongsToMany(
            ArticleCategory::class,
            'article_category',
            'article_id',
            'category_id'
        );
    }

    public function getRateAttribute()
    {
        return round($this->rates()->avg('rate'), 2);
    }

    public function getRoute()
    {
        return route('mag.articles.show', $this->slug);
    }

    public function getImage()
    {
        return $this->image ?: 'images/image-placeholder.png';
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rates()
    {
        return $this->morphMany('App\Rate', 'rateable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function isCommentable()
    {
        if ($this->can_comment === null) {
            return config('settings.articles.can_comment', false);
        }
        return $this->can_comment;
    }

    public function isRateable()
    {
        if ($this->can_rate === null) {
            return config('settings.articles.can_rate', false);
        }
        return $this->can_rate;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
