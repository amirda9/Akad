<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    static $positions = [
        'website' => 'وبسایت',
        'application' => 'اپلیکیشن',
        'mag' => 'مجله',
        'mag_mobile' => 'مجله (موبایل)',
    ];

    protected $table = 'slides';
    protected $guarded = [];
}
