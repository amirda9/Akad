@if($log ?? false)
    <div class="row no-gutters">
        <div class="col-12 col-lg-6 p-3">
            @if($log->getOldModel())
                <h4 class="text-center">متغیر قبلی</h4>
                <div class="d-flex flex-row border rounded shadow-sm p-1">
                    <div class="fa-num">
                        <div>
                            <strong>{{ $log->getOldModel()->title }}</strong>
                        </div>
                        <div>
                            <span>قیمت:</span> <strong>{{ number_format($log->getOldModel()->regular_price) }} تومان</strong>
                        </div>
                        <div>
                            <span>موجودی :</span> <strong>{{ $log->getOldModel()->stock ?: '---' }}</strong>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-12 col-lg-6 p-3">
            @if($log->getNewModel())
                <h4 class="text-center">متغیر جدید</h4>
                <div class="d-flex flex-row border rounded shadow-sm p-1">
                    <div class="fa-num">
                        <div>
                            <strong>{{ $log->getNewModel()->title }}</strong>
                        </div>
                        <div>
                            <span>قیمت:</span> <strong>{{ number_format($log->getNewModel()->regular_price) }} تومان</strong>
                        </div>
                        <div>
                            <span>موجودی :</span> <strong>{{ $log->getNewModel()->stock ?: '---' }}</strong>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
