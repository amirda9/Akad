<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $guarded = [];

    static private $statuses = [
        'on-hold' => 'در انتظار تایید',
        'pending' => 'در انتظار پرداخت',
        'processing' => 'در حال انجام',
        'reserve' => 'رزرو',
        'sent' => 'ارسال شده',
        'completed' => 'تکمیل شده',
        'cancelled' => 'لغو شده',
        'refunded' => 'مسترد شده',
        'failed' => 'ناموفق',
    ];
    static private $payments = [
        //        'nextpay' => [
        //            'title' => 'درگاه پرداخت نکست پی',
        //            'description' => 'پرداخت هزینه سفارش با استفاده از درگاه پرداخت نکست پی'
        //        ],
        //        'idpay' => [
        //            'title' => 'درگاه پرداخت IDPay',
        //            'description' => 'پرداخت هزینه سفارش با استفاده از درگاه پرداخت آیدی پی'
        //        ],
        // 'sadad' => [
        //     'title' => 'درگاه پرداخت بانک ملی',
        //     'description' => 'پرداخت امن به وسیله کلیه کارت های عضو شتاب از طریق درگاه بانک ملی'
        // ],
        'pasargad' => [
            'title' => 'درگاه پرداخت سپهر صادرات',
            'description' => 'پرداخت امن به وسیله کلیه کارت های عضو شتاب از طریق درگاه سپهر صادرات'
        ]
    ];

    public function scopeIsReservable($query)
    {
        return $query->where('status', 'reserve')
            ->where('created_at', '>', Carbon::now()->addHours(-72));
    }

    public function canReserve()
    {
        if ($this->created_at < Carbon::now()->addHours(-72)) {
            return false;
        }
        if ($this->is_paid == false) {
            return false;
        }
        return $this->status == 'pending' || $this->status == 'processing';
    }

    public function isReserved()
    {
        return $this->status == 'reserve';
    }

    public function isValid()
    {
        $items = $this->items()->with(['product', 'variation'])
            ->where(function ($q) {
                $q->where('is_paid', false)->orWhereNull('is_paid');
            })
            ->whereNull('status')
            ->get();
        foreach ($items as $item) {
            $product = $item->product;
            if (!$product) return false;
            if ($product->isSimple()) {
                $price = $product->sale_price ?: $product->regular_price;
                $stock = $product->stock ?: 0;
            } else {
                $variation = $item->variation;
                if (!$variation) return false;
                $price = $variation->sale_price ?: $variation->regular_price;
                $stock = $variation->stock ?: 0;
            }
            if ($price != $item->price) return false;
            if ($stock < $item->quantity) return false;
        }
        return true;
    }



    static public function payments($key = null)
    {
        if ($key) {
            if (array_key_exists($key, self::$payments)) {
                return self::$payments[$key];
            } else {
                return 'نامشخص';
            }
        }
        return self::$payments;
    }
    static public function statuses($key = null)
    {
        if ($key) {
            if (array_key_exists($key, self::$statuses)) {
                return self::$statuses[$key];
            } else {
                return 'نامشخص';
            }
        }
        return self::$statuses;
    }

    public function scopeApproved($query, $is_approved = true)
    {
        return $query->where('is_approved', $is_approved);
    }

    public function scopePaid($query, $value = true)
    {
        return $query->where('is_paid', $value);
    }

    public function scopeDone($query, $done = true)
    {
        if ($done) {
            return $query->whereIn('status', ['completed']);
        }
        return $query->whereNotIn('status', ['completed']);
    }

    public function scopeCode($query, $code = '')
    {
        return $query->where('code', $code);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProvince()
    {
        try {
            $provinces = collect(config('locality.provinces'));
            if (is_numeric($this->city)) {
                $province = $provinces->where('id', $this->province)->first();
            } else {
                $province = $provinces->where('name', $this->province)->first();
            }
            return $province ? $province : ['name' => $this->province];
        } catch (Exception $e) {
            return ['name' => $this->province];
        }
    }


    public function getCity()
    {
        try {
            $cities = collect(config('locality.cities'));
            if (is_numeric($this->city)) {
                $city = $cities->where('id', $this->city)->first();
            } else {
                $city = $cities->where('name', $this->city)->first();
            }
            return $city ? $city : ['name' => $this->city];
        } catch (Exception $e) {
            return ['name' => $this->city];
        }
    }

    public function getFinalPrice()
    {
        $price = 0;
        $price += $this->getOrderPrice();
        $price += $this->getShippingPrice();
        $price -= $this->discount;
        return $price < 0 ? 0 : $price;
    }
    public function getTotalDiscount()
    {
        return $this->discount + $this->shipping_discount;
    }
    public function getShippingPrice($formatted = false)
    {
        $price = $this->shipping_price - $this->shipping_discount;
        $price = $price < 0 ? 0 : $price;
        if ($formatted) {
            return $price == 0 ? 'رایگان' : number_format($price) . ' تومان';
        }
        return $price;
    }

    public function getPayablePrice($formatted = false)
    {
        $price = $this->getFinalPrice() - $this->received_money;
        $price = $price < 0 ? 0 : $price;
        if ($formatted) {
            return $price == 0 ? '0' : number_format($price) . ' تومان';
        }
        return $price;
    }

    public function getOrderPrice()
    {
        return $this->items()->sum('total_price');
    }

    public function getStatusTitle()
    {
        try {
            return Order::statuses($this->status ?: 'unknown');
        } catch (\Exception $e) {
            return 'نامشخص';
        }
    }
    public function getPaymentTitle()
    {
        try {
            return Order::payments($this->payment ?: 'unknown')['title'];
        } catch (\Exception $e) {
            return 'نامشخص';
        }
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }
}
