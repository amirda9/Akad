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
                  
                 
                        <div class="table-responsive">
                            <table class="table  table-sm">
                                <tr>
                                    <td><strong>نام</strong></td>
                                    <td>{{ $comment->name }} </td>
                                    <td><strong>ایمیل</strong></td>
                                    <td>{{ $comment->email }}</td>
                                </tr>
                                    <td><strong>وضعیت پیام</strong></td>
                                    <td>{{ $comment->published ? 'فعال' : 'غیرفعال' }}</td>
                                    <td><strong> شماره تماس</strong></td>
                                    <td>{{ $comment->mobile }}</td>
                                </tr>
                                <tr>
                                    <td><strong>متن پیام</strong></td>
                                    <td  colspan="3">{{ $comment->content }}</td>
                                </tr>
                                    
                                  
                                </tr>
                       
                              
                            </table>
                            
                             <form action="{{route('user.comments.destroy', $comment->id)}}">
                                <a href="{{ route('user.comments.edit',$comment->id) }}"
                                    class="btn btn-sm btn-info">
                                     <span>ویرایش</span>
                                 </a>
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                   
                            </form>
                           
                        </div>
                  

                </div>
            </div>
        </div>
    </div>
@endsection


