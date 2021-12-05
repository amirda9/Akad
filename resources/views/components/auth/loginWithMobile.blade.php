<div class="p-lg-4 p-3 bg-white shadow-sm text-secondary">
    <h4>ورود به حساب کاربری</h4>
    <hr/>
    @include('components.messages')
    <form method="POST" action="{{ route('login.sendCode') }}">
        @csrf
        <div class="form-group row">
            <label for="mobile" class="col-md-4 col-form-label text-md-left">شماره موبایل</label>
            <div class="col-md-6">
                <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    ارسال کد تایید
                </button>
            </div>
        </div>
    </form>
</div>