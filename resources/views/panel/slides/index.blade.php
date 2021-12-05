@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت اسلایدها</h1>
                <a class="btn btn-primary" href="{{ route('panel.slides.create') }}">
                    افزودن اسلاید جدید
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
                    @if($slides->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                <tr>
                                    <th class="p-2">#</th>
                                    <th class="p-2">تصویر</th>
                                    <th class="p-2">موقعیت</th>
                                    <th class="p-2">لینک</th>
                                    <th class="p-2">ترتیب</th>
                                    <th class="p-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($slides as $key => $slide)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td class="p-1">
                                            <a href="{{ getImageSrc($slide->image) }}" target="_blank">
                                                <img style="width:38px;" src="{{ getImageSrc($slide->image, 'small') }}">
                                            </a>
                                        </td>
                                        <td>
                                            {{ \App\Slide::$positions[$slide->position] }}
                                        </td>
                                        <td>
                                            @if($slide->link)
                                                <a href="{{ $slide->link }}" target="_blank">
                                                    {{ Str::limit($slide->link) }}
                                                </a>
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            {{ $slide->order }}
                                        </td>
                                        <td class="p-2">
                                            <a class="btn btn-sm btn-primary" href="{{ route('panel.slides.edit',$slide) }}" title="ویرایش">
                                                ویرایش
                                            </a>
                                            <form class="d-inline" method="post" action="{{ route('panel.slides.destroy', $slide) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger"
                                                        type="submit"
                                                        onclick="return confirm('آیا مطمئن هستید؟')" title="حذف">
                                                    حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('components.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</div>
    
@endsection
