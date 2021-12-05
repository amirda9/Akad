@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'افزودن آدرس جدید',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'افزودن آدرس جدید' }}</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                @include('components.messages')
                <div class="bg-white p-4 rounded shadow-sm text-secondary">
                    <h3>افزودن آدرس جدید</h3>
                    <hr/>
                    <form class="form-horizontal" method="POST" action="{{ route('user.addresses.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="title">عنوان آدرس</label>
                                <input id="title" type="text" class="form-control" autocomplete="false"
                                       name="title" value="{{ old('title')  }}" required autofocus
                                       placeholder="عنوان آدرس را وادر کنید"
                                       oninvalid="this.setCustomValidity('عنوان آدرس را وارد کنید')"
                                       oninput="setCustomValidity('')"/>
                            </div>
                            <div class="col-12 form-group">
                                <label for="address">آدرس</label>
                                <textarea id="address" type="text" class="form-control"
                                          placeholder="متن آدرس را وارد کنید"
                                          required
                                          oninvalid="this.setCustomValidity('متن آدرس را وارد کنید')"
                                          oninput="setCustomValidity('')"
                                          name="address">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-12 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_default" class="custom-control-input" id="is_default">
                                    <label class="custom-control-label" for="is_default">تنظیم به عنوان آدرس پیشفرض</label>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btnFormSubmit" type="submit" class="btn btn-success">ذخیره</button>
                                <a id="btnBackToDashboard" class="btn btn-primary" href="{{ route('user.profile.index') }}">بازگشت</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection