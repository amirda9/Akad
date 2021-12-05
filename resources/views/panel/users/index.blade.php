@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h1 class="m-0 text-secondary">مدیریت کاربران</h1>
                <a class="btn btn-primary" href="{{ route('panel.users.create') }}">
                    افزودن کاربر جدید
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
                    <form method="get" action="{{route('panel.users.index')}}">
                        <div class="row">
                            <div class="col-12 col-lg-3 form-group">
                                <input class="form-control" type="text" id="search" name="search" placeholder="نام، ایمیل و یا موبایل کاربر"
                                       value="{{ request('search') }}" />
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <select name="role" id="role" title="نقش کاربر" class="form-control selectpicker">
                                    <option value="">نمایش همه</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" {{request('role') == $role->id ? 'selected' : '' }}>
                                            {{$role->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <select name="active" id="active" title="وضعیت کاربر" class="form-control selectpicker">
                                    <option>نمایش همه</option>
                                    <option value="1" {{request('active') === '1' ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{request('active') === '0' ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <button type="submit" class="btn btn-success">جستجو</button>
                                <a href="{{ route('panel.users.index') }}" class="btn btn-secondary">
                                    نمایش همه
                                </a>
                            </div>
                        </div>
                    </form>
                    @if($users->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-2">#</th>
                                        <th class="p-2">تصویر</th>
                                        <th class="p-2 text-right">نام</th>
                                        <th class="p-2 text-right">ایمیل</th>
                                        <th class="p-2">موبایل</th>
                                        <th class="p-2">وضعیت</th>
                                        <th class="p-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="p-1">
                                            <a href="{{ getImageSrc($user->image ?: 'images/user.jpg') }}" target="_blank">
                                                <img style="width:38px;" class="rounded-circle" src="{{ getImageSrc($user->image ?: 'images/user.jpg') }}" alt="{{ $user->name }}">
                                            </a>
                                        </td>
                                        <td class="text-right">{{ $user->name ?: '---' }}</td>
                                        <td class="text-right">{{ $user->email ?: '---' }}</td>
                                        <td class="fa-num">{{ $user->mobile ?: '---' }}</td>
                                        <td>
                                            <a class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}"
                                               href="{{ route('panel.users.changeActive',$user) }}">
                                                {{ $user->is_active ? 'فعال' : 'غیرفعال' }}
                                            </a>
                                        </td>
                                        <td class="p-2">
                                            <a class="btn btn-sm btn-light" href="{{ route('panel.users.show',$user) }}" title="مشاهده">
                                                مشاهده
                                            </a>
                                            <a class="btn btn-sm btn-primary" href="{{ route('panel.users.edit',$user) }}" title="ویرایش">
                                                ویرایش
                                            </a>
                                            <form class="d-inline" method="post" action="{{ route('panel.users.destroy', $user) }}">
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
                            {{ $users->links() }}
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
