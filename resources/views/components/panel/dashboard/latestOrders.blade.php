@if($latest_orders ?? false)
    <div class="bg-white rounded shadow-sm p-3 mb-4">
        <h4 class="mb-4 border-bottom pb-3 text-secondary">
            <i class="fal fa-shopping-basket ml-2"></i>
            آخرین سفارشات
        </h4>
        @if($latest_orders->count())
            <div class="table-responsive">
                <table class="table table-sm m-0">
                    <thead class="bg-light">
                    <tr>
                        <th>کد</th>
                        <th>کاربر</th>
                        <th class="text-center">مبلغ</th>
                        <th class="text-left">تاریخ</th>
                    </tr>
                    </thead>
                    <tbody class="fa-num">
                    @foreach($latest_orders as $latest_order)
                        <tr>
                            <td>
                                <a href="{{ route('panel.orders.show',$latest_order) }}">
                                    {{ $latest_order->code }}
                                </a>
                            </td>
                            <td>{{ $latest_order->name }}</td>
                            <td class="text-center">
                                <strong>{{ number_format($latest_order->getFinalPrice()) }} تومان</strong>
                            </td>
                            <td class="text-left">
                                {{ jd($latest_order->created_at) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($latest_orders->count() > 9)
                <a class="btn btn-light btn-block" href="{{ route('panel.orders.index') }}">
                    مشاهده همه سفارشات
                </a>
            @endif
        @else
            @include('components.empty')
        @endif
    </div>
@endif
