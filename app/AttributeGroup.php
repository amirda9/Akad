<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $table = 'attribute_groups';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function attributes()
    {
        return $this->hasMany(Attribute::class,'group_id');
    }

    public function attribute_items()
    {
        return $this->hasManyThrough(
            AttributeItem::class,
            Attribute::class,
            'group_id', // Foreign key on attributes table...
            'attribute_id', // Foreign key on attribute items table...
            'id', // Local key on attribute groups table...
            'id' // Local key on attributes table...
        );
    }
}
