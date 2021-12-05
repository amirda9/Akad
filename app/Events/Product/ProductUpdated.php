<?php

namespace App\Events\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated
{
    use Dispatchable, SerializesModels;

    public $old_product;
    public $new_product;
    public $user_id;
    public $title;

    public function __construct(Product $old_product, Product $new_product, $user_id = null, string $title = null)
    {
        $this->old_product = $old_product;
        $this->new_product = $new_product;
        $this->user_id = $user_id;
        $this->title = $title;
    }

}
