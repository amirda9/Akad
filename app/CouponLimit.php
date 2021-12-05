<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class CouponLimit extends Model
{
    protected $table = "coupon_limits";
    protected $guarded = [];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function products()
    {
        $this->belongsTo(Product::class);
    }

    public function getTypeTitle()
    {
        try {
            return Coupon::$models[$this->model_type];
        } catch (Exception $error) {
            return 'نامشخص';
        }
    }
}
