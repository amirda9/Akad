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
                    <form method="get" class="mb-4">
                        <div class="row">
                           
                            <div class="col-12 col-lg-4 mb-3">
                                <label for="statuses">وضعیت پیام </label>
                                <select id="status" name="status" class="form-control selectpicker" title="انتخاب وضعیت پیام">
                                    <option value="">نمایش همه</option>
                                    @foreach(\App\Order::statuses() as $key => $status)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">جستجو</button>
                        <a class="btn btn-gray-200" href="{{ route('user.comments.index') }}">
                            مشاهده همه
                        </a>
                    </form>
                    @if($comments->count())
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm">
                                <thead>
                                <tr>
                                    <th width="1%" class="text-center">ردیف</th>
                                    <th class="text-center">نام </th>
                                    <th class="text-center">ایمیل</th>
                                    <th class="text-center">تاریخ ارسال</th>
                                    <th class="text-center">متن پیام</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-left"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td class="fa-num text-center">{{ $comment->id }}</td>
                                        <td class="fa-num text-center">{{ $comment->name }}</td>
                                        <td class="fa-num text-center">{{ $comment->email }}</td>
                                        <td class="text-center">
                                            {{ jd($comment->created_at,'Y/m/d') }}
                                        </td>
                                        <td class="fa-num text-center">{{ $comment->content }}</td>
                                        <td class="fa-num text-center">{{ $comment->published ? 'فعال' : 'غیرفعال' }}</td>
                                        
                                        <td class="text-left">
                                            
                                            <form action="{{route('user.comments.destroy', $comment->id)}}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>

                                                <a href="{{ route('user.comments.edit',$comment->id) }}"
                                                    class="btn btn-sm btn-info">
                                                     <span>ویرایش</span>
                                                 </a>
                                             
                                                <a href="{{ route('user.comments.show',$comment->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                     <span>مشاهده</span>
                                                 </a>
                                            </form>
                                           
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $comments->links() }}
                        </div>
                    @else
                        @include('components.empty')
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection


