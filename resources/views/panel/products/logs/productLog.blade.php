@if($log ?? false)
    <div class="row no-gutters">
        <div class="col-12 col-lg-6 p-3">
            <h4 class="text-center">محصول قبلی</h4>
            <div class="d-flex flex-row border rounded shadow-sm p-1">
                @if($log->getOldModel()->image)
                    <img class="rounded ml-2" style="width: 100px; object-fit: cover" src="{{ getImageSrc($log->getOldModel()->image, 'small') }}" />
                @endif
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
        </div>
        <div class="col-12 col-lg-6 p-3">
            @if($log->getNewModel())
                <h4 class="text-center">محصول جدید</h4>
                <div class="d-flex flex-row border rounded shadow-sm p-1">
                    @if($log->getNewModel()->image)
                        <img class="rounded ml-2" style="width: 100px; object-fit: cover" src="{{ getImageSrc($log->getNewModel()->image, 'small') }}" />
                    @endif
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
