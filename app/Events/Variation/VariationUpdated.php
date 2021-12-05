<?php

namespace App\Events\Variation;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VariationUpdated
{
    use Dispatchable, SerializesModels;

    public $old_variation;
    public $new_variation;
    public $user_id;
    public $title;

    public function __construct($old_variation, $new_variation, $user_id = null, string $title = null)
    {
        $this->old_variation = $old_variation;
        $this->new_variation = $new_variation;
        $this->user_id = $user_id;
        $this->title = $title;
    }

}
