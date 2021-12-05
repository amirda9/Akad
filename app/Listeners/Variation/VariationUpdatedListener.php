<?php

namespace App\Listeners\Variation;


use App\Events\Variation\VariationUpdated;
use App\Logs\VariationLog;

class VariationUpdatedListener
{
    public function handle(VariationUpdated $event)
    {
        $new_variation = $event->new_variation;
        $old_variation = $event->old_variation;
        $new_model = null;
        $old_model = null;
        if($new_variation) {
            $title = $new_variation->attribute_items->pluck('title')->toArray();
            $title = implode(',',$title);
            $new_model = new VariationLog(
                $title,
                $new_variation->conditions,
                $new_variation->regular_price,
                $new_variation->sale_price,
                $new_variation->stock,
                $new_variation->stock_status
            );
        }
        if($old_variation) {
            $title = $old_variation->attribute_items->pluck('title')->toArray();
            $title = implode(',',$title);
            $old_model = new VariationLog(
                $title,
                $old_variation->conditions,
                $old_variation->regular_price,
                $old_variation->sale_price,
                $old_variation->stock,
                $old_variation->stock_status
            );
        }
        $event->new_variation->product->logs()->create([
            'content' => $event->title ?: 'متغیر محصول ویرایش شد',
            'model_type' => 'variation',
            'old_model' => json_encode($old_model),
            'new_model' => json_encode($new_model),
            'user_id' => $event->user_id
        ]);
    }
}
