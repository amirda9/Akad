@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'لیست نظرات',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'لیست نظرات' }}</title>
@endsection

@section('head')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="bg-white p-4 rounded shadow-sm text-secondary">
                    <h3 class="text-secondary m-0">لیست نظرات </h3>
                    <hr/>
                    <form action="{{route('user.comments.update', $comment->id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">نام</label>
                            <input type="text" name="name" class="form-control" value="{{ $comment->name }} " id="">
                        </div>
                        <div class="form-group">
                            <label for="name">ایمیل</label>
                            <input type="text" name="email" class="form-control" value="{{ $comment->email }} " id="">
                        </div>
                    
                        <div class="form-group">
                            <label for="name">شماره تماس</label>
                            <input type="text" name="mobile" class="form-control" value="{{ $comment->mobile }} " id="">
                        </div>
                        <div class="form-group">
                            <label for="name">متن پیام </label>
                            <textarea  name="content" class="form-control">{{ $comment->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-success">ثبت تغییرات</button>

                        </div>
                    </form>
                           
                </div>
                  

                </div>
            </div>
        </div>
    </div>
@endsection


