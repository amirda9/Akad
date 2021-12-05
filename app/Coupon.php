<?php

namespace App;

use App\Events\Orders\OrderPaid;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    protected $guarded = [];
    protected $table = 'coupons';

    public static $models = [
        'user' => 'کاربر',
        'category' => 'دسته بندی',
        'products' => 'محصول'
    ];

    public static $types = [
        'percent' => 'درصد',
        'number' => 'تومان'
    ];

    public static $statuses = [
        'enable' => 'فعال',
        'disable' => 'غیرفعال'
    ];

    public function isValid(Order $order)
    {
        if (!Auth::check())
            return [
                'isValid' => false,
                'message' => "لطفا وارد حساب کاربری خود شود"
            ];

        if ($order->discount > 0)
            return [
                'isValid' => false,
                'message' => "برای این سفارش تخفیف ثبت شده است"
            ];

        if($this->is_disposable) {
            $coupon_users_ids = $this->orders()->pluck('user_id')->toArray();
            if (\in_array(Auth::id(), $coupon_users_ids))
                return [
                    'isValid' => false,
                    'message' => 'شما قبلا از این کوپن تخفیف استفاده کرده اید'
                ];
        }

        if ($this->status != 'enable')
            return [
                'isValid' => false,
                'message' => "کد معتبر نمی باشد"
            ];

        if ($this->number != null)
            if (!($this->number > 0))
                return [
                    'isValid' => false,
                    'message' => "شما قادر به استفاده از کد تخفیف نمی باشید"
                ];

        if($this->start_date != null)
          if ($this->start_date > Carbon::now())
              return [
                  'isValid' => false,
                  'message' => "زمان استفاده از کوپن هنوز شروع نشده است"
              ];


        if($this->end_date != null)
          if ($this->end_date < Carbon::now())
              return [
                  'isValid' => false,
                  'message' => "کوپن مورد نظر منقضی شده است"
              ];


        if (!$this->general) {
            $coupon_limits = CouponLimit::where('coupon_id', $this->id)
                ->where('model_type', 'user')
                ->pluck('model_id')->toArray();

            if (!\in_array(Auth::id(), $coupon_limits))
                return [
                    'isValid' => false,
                    'message' => "شما مجاز به استفاده از این کد تخفیف نمی باشید"
                ];

        }

        if ($this->min_order_amount > $order->getOrderPrice())
            return [
                'isValid' => false,
                'message' => "حداقل خرید شما برای استفاده از کوپن کافی نمی باشد"
            ];

        $coupon_product_limits = $this->limits()->where('model_type', 'products')->pluck('id')->toArray();
        if (count($coupon_product_limits) > 0)
            foreach ($order->items as $order_item) {
                if (!\in_array($order_item->product_id, $coupon_product_limits))
                    return [
                        'isValid' => false,
                        'message' => "از این کد تخفیف برای این سفارش نمی توان استفاده کرد"
                    ];

            }


        $coupon_categories_limits = $this->limits()->where('model_type', 'category')->pluck('id')->toArray();
        if (count($coupon_categories_limits) > 0) {
            foreach ($order->items as $order_item) {
                $product = $order_item->product;
                $product_categories = \getCategoryChildren($product->category_id);
                $is_valid = false;
                foreach ($product_categories as $product_category) {
                    if (\in_array($product_category, $product_categories)) {
                        $is_valid = true;
                        break;
                    }
                }
                if (!$is_valid)
                    return [
                        'isValid' => false,
                        'message' => "از این کد تخفیف برای این دسته بندی نمی توان استفاده کرد"
                    ];

            }
        }

        return [
            'isValid' => true,
            'message' => ""
        ];
    }

    public function getDiscount(Order $order)
    {
        $discount = 0;
        $validation = $this->isValid($order);
        if($validation['isValid']) {
            if ($this->type == "percent")
                $discount = $order->getOrderPrice() * $this->amount / 100;

            if ($this->type == "number")
                $discount = $this->amount;

            if($this->max_discount_amount)
                if ($discount > $this->max_discount_amount)
                    $discount = $this->max_discount_amount;
        }
        $discount = $discount > $order->getPayablePrice() ? $order->getPayablePrice() : $discount;
        return $discount;
    }


    public function use(Order $order)
    {
        $discount = $this->getDiscount($order);
        $shipping_discount = $this->shipping_discount;
        if($order->shipping_price < $this->shipping_discount) {
            $shipping_discount = $order->shipping_price;
        }
        $order->update([
            'discount' => $discount,
            'shipping_discount' => $shipping_discount
        ]);
        $this->usages()->create([
            'order_id' => $order->id
        ]);
        $this->decrement('number');
        if($order->getPayablePrice() == 0) {
            event(new OrderPaid($order));
        }
    }


    public function limits()
    {
        return $this->hasMany(CouponLimit::class, 'coupon_id');
    }


    public function getStatusTitle()
    {
        try {
            return Self::$statuses[$this->status];
        } catch (Exception $erorr) {
            return 'نامشخص';
        }
    }

    public function getTypeTitle()
    {
        try {
            return Self::$types[$this->type];
        } catch (Exception $erorr) {
            return 'نامشخص';
        }
    }

    public function usages()
    {
        return $this->hasMany(CouponUseage::class);
    }

    public function orders()
    {
        return Order::whereIn('id', $this->usages()->pluck('order_id')->toArray());
    }
}
