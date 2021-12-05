<div class="p-lg-4 p-3 bg-white shadow-sm text-secondary">
    <h4>ورود به حساب کاربری</h4>
    <hr/>
    @include('components.messages')
    <form method="POST" class="mb-3" action="{{ route('login.verify') }}">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="mobile" class="col-md-4 col-form-label text-md-left">شماره موبایل</label>
            <div class="col-md-6">
                <input id="mobile" type="text" readonly class="form-control" name="mobile" value="{{ $mobile }}" required autocomplete="mobile" autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="code" class="col-md-4 col-form-label text-md-left">کد تایید</label>
            <div class="col-md-6">
                <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" autocomplete="off" required>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">
                        ورود به آکاد
                    </button>
                    <a href="{{ route('login') }}">
                        تغییر شماره
                    </a>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-6 offset-md-4">
            <form method="post" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="mobile" value="{{ $mobile ?? '' }}" />
                <span>کد را دریافت نکردید؟</span>
                <button type="submit" class="btn btn-link">ارسال مجدد</button>
            </form>
        </div>
    </div>
</div>
