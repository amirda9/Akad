@if($latest_products ?? false)
    <div class="bg-white rounded shadow-sm p-3 mb-4">
        <h4 class="mb-4 border-bottom pb-3 text-secondary">
            <i class="fal fa-shopping-basket ml-2"></i>
           محصولات رو به اتمام
        </h4>
        
            <div class="table-responsive">
                <table class="table table-sm m-0">
                    <thead class="bg-light">
                    <tr>
                        <th>کد</th>
                        <th>تصویر</th>
                        <th>نام کالا</th>
                        <th class="text-center">کد کالا</th>
                        <th class="text-left">تاریخ</th>
                    </tr>
                    </thead>
                    <tbody class="fa-num">
                    @foreach($latest_products as $product)
                    @if ($product->stock <= $product->min_stock)
                        <tr>
                            <td>
                                <a href="{{ route('panel.products.show',$product) }}">
                                    {{ $product->id }}
                                </a>
                            </td>
                            <td> 
                                <a href="{{ getImageSrc($product->getImage()) }}" target="_blank">
                                    <img style="width:50px;" src="{{ getImageSrc($product->getImage(),'small') }}" alt="{{ $product->title }}">
                                </a>
                            </td>
                            <td class="text-right">
                                <a href="{{ $product->getRoute() }}" title="{{ $product->title }}" target="_blank">
                                    {{ str_limit($product->title,60) }}
                                </a>
                            </td>
                            <td class="text-right">
                               {{$product->sku}}
                            </td>
                            <td class="text-left">
                                {{ jd($product->created_at) }}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($latest_products->count() > 9)
                <a class="btn btn-light btn-block" href="{{ route('panel.products.index') }}">
                   مشاهده تمامی محصولات
                </a>
            @endif
        
    </div>
@endif
