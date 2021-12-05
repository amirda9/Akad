@if($pending_orders ?? false)
    <div class="bg-white rounded shadow-sm p-3 mb-4">
        <h4 class="mb-4 border-bottom pb-3 text-secondary">
            <i class="fal fa-shopping-basket ml-2"></i>
            سفارشات در حال انتظار
        </h4>
        @if($pending_orders->count())
            <div class="table-responsive">
                <table class="table table-sm m-0">
                    <thead class="bg-light">
                    <tr>
                        <th>کد</th>
                        <th>کاربر</th>
                        <th>مبلغ</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="fa-num">
                    @foreach($pending_orders as $pending_order)
                        <tr>
                            <td>{{ $pending_order->code }}</td>
                            <td>{{ $pending_order->name }}</td>
                            <td>
                                <strong>{{ number_format($pending_order->getFinalPrice()) }} تومان</strong>
                            </td>
                            <td class="text-left">
                                <a href="{{ route('panel.orders.show',$pending_order) }}" class="btn btn-sm btn-light">
                                    مشاهده
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($pending_orders->count() > 9)
                <a class="btn btn-light btn-block" href="{{ route('panel.orders.index') }}">
                    مشاهده همه سفارشات
                </a>
            @endif
        @else
            @include('components.empty')
        @endif
    </div>
@endif