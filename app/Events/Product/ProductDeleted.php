<?php

namespace App\Events\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductDeleted
{
    use Dispatchable, SerializesModels;

    public $product;
    public $user_id;

    public function __construct(Product $product, $user_id = null)
    {
        $this->product = $product;
        $this->user_id = $user_id;
    }

}
