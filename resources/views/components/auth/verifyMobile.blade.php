<div class="bg-white p-lg-4 p-3 text-secondary shadow-sm">
    <h4>تایید شماره موبایل</h4>
    <hr/>
    @include('components.messages')
    <div class="text-center">
        لطفا کد فعال سازی ارسال شده به شماره موبایل خود را در این قسمت وارد کنید.
        <form id="verify_mobile" class="form-inline py-4 justify-content-center" method="post" action="{{ route('mobile.verify') }}">
            @csrf
            <input type="text" name="code" class="form-control text-center" maxlength="4" autocomplete="off" placeholder="- - - -">
        </form>
        <button class="btn btn-success" type="button"
                onclick="event.preventDefault(); document.getElementById('verify_mobile').submit();">
            فعال سازی
        </button>
        <form class="d-inline mr-4" method="POST" action="{{ route('mobile.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">ارسال مجدد کد فعال سازی</button>
        </form>
    </div>
</div>