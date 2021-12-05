<?php

namespace App\Listeners\Product;

use App\Events\Product\ProductCreated;

class ProductCreatedListener
{
    public function handle(ProductCreated $event)
    {
        $event->product->logs()->create([
            'content' => "محصول ایجاد شد",
            'user_id' => $event->user_id
        ]);
    }
}
