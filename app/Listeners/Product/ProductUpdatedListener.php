<?php

namespace App\Listeners\Product;


use App\Events\Product\ProductUpdated;
use App\Logs\ProductLog;

class ProductUpdatedListener
{
    public function handle(ProductUpdated $event)
    {
        $new_product = $event->new_product;
        $old_product = $event->old_product;
        $new_model = null;
        $old_model = null;
        if($new_product) {
            $new_model = new ProductLog(
                $new_product->title,
                $new_product->image,
                $new_product->regular_price,
                $new_product->sale_price,
                $new_product->stock,
                $new_product->stock_status
            );
        }
        if($old_product) {
            $old_model = new ProductLog(
                $old_product->title,
                $old_product->image,
                $old_product->regular_price,
                $old_product->sale_price,
                $old_product->stock,
                $old_product->stock_status
            );
        }
        $event->new_product->logs()->create([
            'content' => $event->title ?: 'محصول ویرایش شد',
            'model_type' => 'product',
            'old_model' => json_encode($old_model),
            'new_model' => json_encode($new_model),
            'user_id' => $event->user_id
        ]);
    }
}
