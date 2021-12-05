@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'آدرس ها',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'آدرس ها' }}</title>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                @include('components.messages')
                <div class="bg-white p-4 shadow-sm rounded mb-4">
                    <div class="body text-secondary">
                        <h3>آدرس های شما</h3>
                        <hr/>
                        @if($user->addresses()->count())
                            @foreach($user->addresses as $address)
                                <div class="border shadow-sm mb-3 d-flex flex-row">
                                    <div class="flex-grow-1 p-3">
                                        <h6>
                                            {{ $address->title }}
                                            @if($address->is_default)
                                                <i class="fas fa-star text-gold"></i>
                                            @else
                                                <a title="تنظیم به عنوان پیشفرض" class="text-decoration-none" href="{{ route('user.addresses.setAsDefault',$address) }}">
                                                    <i class="far fa-star text-gold"></i>
                                                </a>
                                            @endif
                                        </h6>
                                        <p>{{ $address->address }}</p>
                                    </div>
                                    <div class="d-flex flex-column p-3 bg-gray-100 border-right">
                                        <a class="btn btn-block mb-2 btn-primary btn-sm rounded-pill" href="{{ route('user.addresses.edit',$address) }}">
                                            ویرایش
                                        </a>
                                        <form method="post" action="{{ route('user.addresses.destroy',$address) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                    onclick="return confirm('آیا مطمئن هستید؟')"
                                                    class="btn btn-block btn-danger btn-sm rounded-pill">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <a class="d-block p-3 border-dashed border-gray-500 shadow-sm text-center text-gray-500 text-decoration-none" href="{{ route('user.addresses.create') }}">
                                <i class="far fa-plus"></i>
                                <strong>افزودن آدرس جدید</strong>
                            </a>
                        @else
                            @component('components.empty')
                                <a class="btn btn-primary mt-4" href="{{ route('user.addresses.create') }}">
                                    افزودن آدرس جدید
                                </a>
                            @endcomponent
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
