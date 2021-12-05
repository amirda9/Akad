@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت برچسب ها</h1>
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
                            <h4 class="pb-3 text-gray border-bottom mb-4">افزودن برچسب</h4>
                            <form method="post" action="{{ route('panel.tags.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="title">عنوان برچسب</label>
                                    <input id="title" autofocus type="text" class="form-control" name="title" required/>
                                </div>
                                <button type="submit" class="btn  btn-success">
                                    افزودن برچسب
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @if($tags->count())
                                <div class="table-responsive">
                                    <table class="table table-hover m-0 text-center text-nowrap">
                                        <thead class="bg-light">
                                        <tr>
                                            <th class="p-2">عنوان</th>
                                            <th class="p-2"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($tags as $tag)
                                            <tr>
                                                <td>
                                                    {{ $tag->title }}
                                                </td>
                                                <td class="p-2">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('panel.tags.edit',$tag) }}" title="ویرایش">
                                                        ویرایش
                                                    </a>
                                                    <form class="d-inline" method="post" action="{{ route('panel.tags.destroy', $tag) }}">
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
                                    {{ $tags->links() }}
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
