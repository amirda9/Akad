<?php

namespace App\Listeners\Variation;

use App\Events\Variation\VariationCreated;
use App\Logs\VariationLog;

class VariationCreatedListener
{
    public function handle(VariationCreated $event)
    {
        $variation = $event->variation;
        $title = $variation->attribute_items()->pluck('title')->toArray();
        $title = implode(',',$title);
        $new_variation = new VariationLog(
            $title,
            $variation->conditions,
            $variation->regular_price,
            $variation->sale_price,
            $variation->stock,
            $variation->stock_status
        );
        $event->variation->product->logs()->create([
            'content' => "متغیر ایجاد شد",
            'user_id' => $event->user_id,
            'model_type' => 'variation',
            'new_model' => json_encode($new_variation)
        ]);
    }
}
