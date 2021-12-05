@if($log ?? false)
    @switch($log->model_type)
        @case('product')
            @include('panel.products.logs.productLog',['log' => $log])
            @break
        @case('variation')
            @include('panel.products.logs.variationLog',['log' => $log])
            @break
    @endswitch
@endif
