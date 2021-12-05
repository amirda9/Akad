@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت گروه های ویژگی</h1>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="row">
                <div class="col col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="pb-3 text-gray border-bottom mb-4">افزودن گروه جدید</h4>
                            <form method="post" action="{{ route('panel.attributeGroups.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="title">عنوان گروه</label>
                                    <input id="title" type="text" class="form-control" name="title" required/>
                                </div>
                                <div class="form-group">
                                    <label for="order">ترتیب نمایش</label>
                                    <input id="order" type="number" class="form-control" name="order"/>
                                </div>
                                <button type="submit" class="btn  btn-success">
                                    افزودن گروه جدید
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @if($groups->count())
                                <div class="table-responsive">
                                    <table class="table table-hover m-0 text-center text-nowrap">
                                        <thead class="bg-light">
                                        <tr>
                                            <th class="p-2">عنوان</th>
                                            <th class="p-2"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($groups as $group)
                                            <tr>
                                                <td>
                                                    {{ $group->title }}
                                                </td>
                                                <td class="p-2">
                                                    <a class="btn btn-sm btn-light" href="{{ route('panel.attributes.index',$group) }}" title="مشاهده">
                                                        مشاهده
                                                    </a>
                                                    <a class="btn btn-sm btn-primary" href="{{ route('panel.attributeGroups.edit',$group) }}" title="ویرایش">
                                                        ویرایش
                                                    </a>
                                                    <form class="d-inline" method="post" action="{{ route('panel.attributeGroups.destroy', $group) }}">
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
    </div>

</div>

@endsection
