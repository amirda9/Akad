<?php

namespace App\Pivots;

use App\AttributeItem;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Log;

class VariationAttributeItem extends Pivot
{

    protected $appends = [
        'item',
    ];

    public function getItemAttribute()
    {
        return AttributeItem::find($this->attribute_item_id);
    }
}
