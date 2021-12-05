@if($product ?? false)
    <div class="product-full-description">
        {!! $product->full_description !!}
    </div>
@endif
