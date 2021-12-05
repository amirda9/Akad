<?php

namespace App;

use App\Events\Variation\VariationUpdated;
use App\Pivots\VariationAttributeItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Wschool\Shoppingcart\Facades\Cart;

class Variation extends Model
{
    protected $table = 'variations';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'conditions' => 'array',
        'manage_stock' => 'boolean',
    ];

    public static function boot() {
        parent::boot();
        static::deleting(function($variation) {
            $variation->attributes()->detach();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function scopeInStock($query)
    {
        $query->where('stock', '>',0);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'attribute_variation','variation_id','attribute_id')
            ->withPivot('attribute_item_id')->using(VariationAttributeItem::class);
    }
    public function attribute_items()
    {
        return $this->belongsToMany(AttributeItem::class,'attribute_variation','variation_id','attribute_item_id');
    }

    public function canOrder($qty = null)
    {
        if(!$this->regular_price) {
            return false;
        }
        if($this->stock !== null) {
            if($qty == null) {
                $item = null;
                $product_items = Cart::content()->where('id', $this->product_id);
                foreach ($product_items as $product_item) {
                    if ($product_item->options['vid'] ?? false) {
                        if ($product_item->options['vid'] == $this->id) {
                            $item = $product_item;
                            break;
                        }
                    }
                }
                $qty = 1;
                if ($item) {
                    $qty += $item->qty;
                }
            }

            return $this->stock >= $qty;
        } else {
            return $this->stock_status == 'instock';
        }
    }
    public function getOrderPrice($qty = 1)
    {
        return $this->sale_price ?: $this->regular_price;
    }

    public function submitLog($old_variation)
    {
        $flag = false;
        if(!array_equal($this->conditions, $old_variation->conditions)) $flag = true;
        if($this->regular_price != $old_variation->regular_price) $flag = true;
        if($this->sale_price != $old_variation->sale_price) $flag = true;
        if($this->stock != $old_variation->stock) $flag = true;
        if($this->stock_status != $old_variation->stock_status) $flag = true;
        if($flag) {
            event(new VariationUpdated($old_variation, $this, Auth::id()));
        }
    }
}
