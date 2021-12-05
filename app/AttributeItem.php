<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeItem extends Model
{
    protected $table = 'attribute_items';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,'attribute_id');
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'attribute_item_product',
            'attribute_item_id',
            'product_id'
        );
    }
    public function variations()
    {
        return $this->belongsToMany(Variation::class,'attribute_variation','attribute_item_id','variation_id','');
    }
}
