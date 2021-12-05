<div class=" p-3 text-nowrap overflow-auto bg-white rounded mb-4 shadow-sm text-secondary">
    <div class="d-flex align-items-center">
        <div class="flex-grow-1"></div>
        <div class="text-center px-3 {{ ($step ?? 0) >= 1 ? 'text-primary' : '' }}">
            <i class="fal fa-shopping-cart fa-fw fa-3x mb-2"></i>
            <span class="d-block">بررسی سبد خرید</span>
        </div>
        <div class="flex-grow-1 border-top border-2 mb-3"></div>
        <div class="text-center px-3 {{ ($step ?? 0) >= 2 ? 'text-primary' : '' }}">
            <i class="fal fa-truck fa-fw fa-3x mb-2"></i>
            <span class="d-block">اطلاعات ارسال</span>
        </div>
        <div class="flex-grow-1 border-top border-2 mb-3"></div>
        <div class="text-center px-3 {{ ($step ?? 0) >= 3 ? 'text-primary' : '' }}">
            <i class="fal fa-credit-card fa-fw fa-3x mb-2"></i>
            <span class="d-block">پرداخت</span>
        </div>
        <div class="flex-grow-1 border-top border-2 mb-3"></div>
        <div class="text-center px-3 {{ ($step ?? 0) >= 4 ? 'text-primary' : '' }}">
            <i class="fal fa-check-circle fa-fw fa-3x mb-2"></i>
            <span class="d-block">تمام !</span>
        </div>
        <div class="flex-grow-1"></div>
    </div>
</div>
