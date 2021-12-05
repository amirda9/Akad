@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h1 class="m-0 text-secondary">{{ $comment->user->name }}</h1>
                <a class="btn btn-secondary" href="{{ route('panel.comments.index') }}">
                    بازگشت
                </a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>نام کاربر</td>
                                <th>{{ $comment->user->name }}</th>
                                <td>نام</td>
                                <th>{{ $comment->name }}</th>
                            </tr>
                          
                            <tr>
                                <td>ایمیل</td>
                                <th>{{ $comment->email }}</th>
                                <td>شماره تماس</td>
                                <th>{{ $comment->mobile }}</th>
                            </tr>
                          
                        </table>
                    </div>
                  
                        <h3>توضیحات</h3>
                        <p>
                            {{ $comment->content }}
                        </p>
                    
                    <a class="btn btn-primary" href="{{ route('panel.comments.edit', [$comment->id] ) }}">
                        پاسخ به پیام
                    </a>
                  
                    <form class="d-inline" method="post" action="{{ route('panel.comments.destroy', [$comment->id]) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger"
                            type="submit"
                            onclick="return confirm('آیا مطمئن هستید؟')" title="حذف">
                            حذف
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
