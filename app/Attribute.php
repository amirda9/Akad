<?php

namespace App;

use App\Pivots\ProductAttribute;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function group()
    {
        return $this->belongsTo(AttributeGroup::class, 'group_id');
    }

    public function items()
    {
        return $this->hasMany(AttributeItem::class, 'attribute_id');
    }
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'attribute_product',
            'attribute_id',
            'product_id'
        )->using(ProductAttribute::class)->withPivot(['value', 'visibility', 'variation']);
    }


    public function variations()
    {
        return $this->belongsToMany(Variation::class,'attribute_variation','attribute_id','variation_id','');
    }
}
