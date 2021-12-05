<?php

namespace App\Listeners\Product;

use App\Events\Product\ProductDeleted;

class ProductDeletedListener
{
    public function handle(ProductDeleted $event)
    {
        $event->product->logs()->create([
            'content' => "محصول حذف شد",
            'user_id' => $event->user_id
        ]);
    }
}
