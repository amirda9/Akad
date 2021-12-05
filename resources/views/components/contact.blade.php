<form method="post" action="{{ route('contact.send') }}">
    @csrf
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label for="name">نام و نام خانوادگی*</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       placeholder="نام خود را وارد کنید" required
                       oninvalid="this.setCustomValidity('نام خود را وارد کنید')"
                       oninput="setCustomValidity('')"
                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}"
                       placeholder="آدرس ایمیل را وارد کنید"
                       class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label for="mobile">شماره موبایل</label>
                <input type="text" name="mobile" value="{{ old('mobile') }}"
                       placeholder="شماره موبایل را وارد کنید"
                       id="mobile" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}">
                @if ($errors->has('mobile'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="message">متن پیام*</label>
                <textarea name="message" id="message" rows="5"
                          placeholder="متن پیام را وارد کنید" required
                          oninvalid="this.setCustomValidity('متن پیام را وارد کنید')"
                          oninput="setCustomValidity('')"
                          class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}">{{ old('message') }}</textarea>
                @if ($errors->has('message'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('message') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <div class="input-group rounded overflow-hidden">
                    <input placeholder="کد امنیتی را وارد کنید"
                           type="text" name="captcha" required
                           oninvalid="this.setCustomValidity('کد امنیتی را وارد کنید')"
                           oninput="setCustomValidity('')"
                           class="form-control {{ $errors->has('captcha') ? 'is-invalid' : '' }}">
                    <div class="input-group-append">
                        <div class="captcha-container" style="cursor:pointer;">
                            {!! captcha_img('simple') !!}
                        </div>
                    </div>
                    @if ($errors->has('captcha'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr/>
            <div class="text-secondary mb-3">
                <small>پر کردن فیلد های ستاره دار الزامی می باشد.</small>
            </div>
            <button type="submit" class="btn btn-success">ارسال پیام</button>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $('body').on('click','.captcha-container',() => {
            refreshCaptcha();
        })
        function refreshCaptcha(){
            $.ajax({
                url: "{{ route('captcha.refresh') }}",
                type: 'get',
                dataType: 'html',
                success: function(json) {
                    $('.captcha-container').html(json);
                },
                error: function(data) {
                    alert('Try Again.');
                }
            });
        }
    </script>
@endpush
