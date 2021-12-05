<?php

namespace App;

use App\Casts\CanCommentCast;
use App\Casts\CanRateCast;
use App\Events\Product\ProductUpdated;
use App\Pivots\ProductAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Wschool\Shoppingcart\Facades\Cart;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $guarded = [];

    static $types = [
        'simple-product' => 'محصول ساده',
        'variable-product' => 'محصول متغیر',
    ];

    protected $appends = [
        'min_price',
        'max_price',
        'is_in_stock',
    ];

    protected $casts = [
        'can_rate' => CanRateCast::class,
        'can_comment' => CanCommentCast::class,
        'can_order' => 'boolean',
        'manage_stock' => 'boolean',
        'sold_individually' => 'boolean',
    ];

    public function getIsInStockAttribute()
    {
        if($this->isSimple()) {
            return $this->stock > 0 ? 1 : 0;
        }
        if($this->isVariable()) {
            return $this->variations()->where('stock','>=',0)->sum('stock') > 0 ? 1 : 0;
        }
        return 0;
    }
    public function getMinPriceAttribute()
    {
        if ($this->isSimple()) {
            return $this->sale_price ?: $this->regular_price;
        }
        if ($this->isVariable()) {
            $min_variation = $this->variations()
                ->selectRaw('case when sale_price is null then regular_price else sale_price end as final_price')
                ->orderBy('final_price', 'asc')
                ->first();
            if($min_variation) {
                return $min_variation->final_price;
            }
        }
    }
    public function getMaxPriceAttribute()
    {
        if ($this->isSimple()) {
            return $this->regular_price;
        }
        if ($this->isVariable()) {
            $max_variation = $this->variations()
                ->selectRaw('case when sale_price is null then regular_price else sale_price end as final_price')
                ->orderBy('final_price', 'desc')
                ->first();
            if($max_variation) {
                return $max_variation->final_price;
            }
        }
        return null;
    }

    public function canDelete()
    {
        if($this->orderItems()->count()) {
            return 'برای این محصول سفارش ثبت شده است';
        }
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function scopeSimple($query)
    {
        $query->select([
            'id','sku','type','title','en_title','slug','image',
            'order','brand_id','stock','stock_status','published',
            'is_featured','regular_price','sale_price','created_at','updated_at'
        ]);
    }

    public function scopePublished($query)
    {
        $query->where('published', true);
    }

    public function scopeFeatured($query)
    {
        $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        $query->where('stock', '>',0);
    }

    public function getRoute()
    {
        return route('products.show', $this->slug);
    }

    public function canOrder($qty = null, $vid = null)
    {
        if ($this->isSimple()) {
            if (!$this->regular_price) {
                return false;
            }
            if($this->stock !== null) {
                if($qty == null) {
                    $item = Cart::content()->where('id', $this->product_id)->first();
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
        if ($this->isVariable()) {
            if ($vid == null) {
                $variations = $this->variations;
                $can_order = false;
                foreach ($variations as $variation) {
                    $can_order = $variation->canOrder($qty);
                    if ($can_order) break;
                }
                return $can_order;
            } else {
                $variation = $this->variations()->find($vid);
                if (!$variation) {
                    return false;
                }
                return $variation->canOrder($qty);
            }
        }
        return false;
    }

    public function getOrderPrice($qty = 1)
    {
        return $this->sale_price ?: $this->regular_price;
    }

    public function isSimple()
    {
        return $this->type == 'simple-product';
    }

    public function isVariable()
    {
        return $this->type == 'variable-product';
    }

    public function submitViewLog()
    {
        $flag = false;
        if (session()->has('views.products.' . $this->id)) {
            $lifetime = config('settings.view_lifetime');
            $view_time = session()->get('views.products.' . $this->id);
            if ((time() - $view_time) > $lifetime) {
                session()->forget('views.products.' . $this->id);
                $flag = true;
            }
        } else {
            $flag = true;
        }
        if ($flag) {
            session()->put('views.products.' . $this->id, time());
            $this->increment('views');
        }
    }

    public function categories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'category_product',
            'product_id',
            'category_id'
        );
    }
    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'attribute_product',
            'product_id',
            'attribute_id'
        )->using(ProductAttribute::class)->withPivot(['value', 'visibility', 'variation']);
    }

    public function attribute_items()
    {
        return $this->belongsToMany(
            AttributeItem::class,
            'attribute_item_product',
            'product_id',
            'attribute_item_id'
        );
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function variations()
    {
        return $this->hasMany(Variation::class, 'product_id');
    }
    public function variation_attributes()
    {
        return $this->attributes()->wherePivot('variation', true)->with(['variations' => function($q) {
            $q->where('product_id',$this->id);
        }]);
    }
    public function variation_attribute_items()
    {
        return $this->attribute_items()->whereHas('variations', function ($q) {
            $q->where('product_id',$this->id);
        });
    }

    public function getImage()
    {
        return $this->image ?: 'images/image-placeholder.png';
    }


    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getSimilarProducts()
    {
        $products = Product::published()
            ->where('id', '<>', $this->id)
            ->where('category_id', $this->category_id)
            ->take(10)->inRandomOrder()->get();
        return $products;
    }

    public function getDiscountText()
    {
        if ($this->isSimple()) {
            if ($this->sale_price) {
                $discount = $this->regular_price - $this->sale_price;
                $discount = round(($discount / $this->regular_price) * 100);
                if ($discount >= 5) {
                    return '%' . convertNumbers($discount);
                }
            }
            return '';
        }
        return '';
    }

    public function hasDiscount()
    {
        if ($this->isSimple()) {
            if ($this->sale_price) {
                $discount = $this->regular_price - $this->sale_price;
                $discount = round(($discount / $this->regular_price) * 100);
                if ($discount >= 5) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    public function limits()
    {
        return $this->belongsTo(CouponLimit::class, 'model_id');
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function getRateAttribute()
    {
        return round($this->rates()->avg('rate'), 2);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function submitLog(Product $old_product)
    {
        $flag = false;
        if($this->title != $old_product->title) $flag = true;
        if($this->regular_price != $old_product->regular_price) $flag = true;
        if($this->sale_price != $old_product->sale_price) $flag = true;
        if($this->stock != $old_product->stock) $flag = true;
        if($this->stock_status != $old_product->stock_status) $flag = true;
        if($this->image != $old_product->image) $flag = true;
        if($flag) {
            event(new ProductUpdated($old_product, $this, Auth::id()));
        }
    }
}
