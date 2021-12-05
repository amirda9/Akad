<?php

namespace App\Listeners\Variation;

use App\Events\Variation\VariationDeleted;
use App\Logs\VariationLog;

class VariationDeletedListener
{
    public function handle(VariationDeleted $event)
    {
        $variation = $event->variation;
        $title = $variation->attribute_items()->pluck('title')->toArray();
        $title = implode(',',$title);
        $old_model = new VariationLog(
            $title,
            $variation->conditions,
            $variation->regular_price,
            $variation->sale_price,
            $variation->stock,
            $variation->stock_status
        );
        $event->variation->product->logs()->create([
            'content' => "متغیر حذف شد",
            'user_id' => $event->user_id,
            'model_type' => 'variation',
            'old_model' => json_encode($old_model)
        ]);
    }
}
