<?php

namespace App\Pivots;

use App\AttributeItem;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Log;

class ProductAttribute extends Pivot
{
    protected $casts = [
        'value' => 'array',
        'visibility' => 'boolean',
        'variation' => 'boolean',
    ];

    protected $appends = [
        'items',
    ];

    public function getItemsAttribute()
    {
        return AttributeItem::whereIn('id',$this->value ? $this->value: [])->get();
    }
}
