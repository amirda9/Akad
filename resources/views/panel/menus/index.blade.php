@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت منوها</h1>
                <a class="btn btn-primary" href="{{ route('panel.menus.create') }}">
                    افزودن منو جدید
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
                    @if($menus->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                <tr>
                                    <th class="p-2">نام</th>
                                    <th class="p-2">عنوان</th>
                                    <th class="p-2">آیتم ها</th>
                                    <th class="p-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td>
                                            {{ $menu->name }}
                                        </td>
                                        <td>
                                            {{ $menu->title }}
                                        </td>
                                        <td class="fa-num">
                                            {{ $menu->items()->count() }}
                                        </td>
                                        <td class="p-2">
                                            <a class="btn btn-sm btn-light" href="{{ route('panel.menus.show',$menu) }}" title="مشاهده">
                                                مشاهده
                                            </a>
                                            <a class="btn btn-sm btn-primary" href="{{ route('panel.menus.edit',$menu) }}" title="ویرایش">
                                                ویرایش
                                            </a>
                                            <form class="d-inline" method="post" action="{{ route('panel.menus.destroy', $menu) }}">
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
