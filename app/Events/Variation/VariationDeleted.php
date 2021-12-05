<?php

namespace App\Events\Variation;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VariationDeleted
{
    use Dispatchable, SerializesModels;

    public $variation;
    public $user_id;

    public function __construct($variation, $user_id = null)
    {
        $this->variation = $variation;
        $this->user_id = $user_id;
    }

}
