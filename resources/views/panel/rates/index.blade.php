@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت امتیازها</h1>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
                    <div class="py-3">
                        <form id="filters" class="position-sticky sticky-top" style="top: 55px;" method="GET" enctype="multipart/form-data">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">

                                <div>
                                    {{-- <input type="text" class="form-control" name="title">
                                    <button type="submit" class="btn btn-success">جستجو</button> --}}

                                    <div class="input-group mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="جستجو براساس نام" aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-success" id="basic-addon1">جستجو</button>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <span class="text-gray-600">
                                        <i class="far fa-sort text-gray-500"></i>
                                        مرتب سازی بر اساس :
                                    </span>
                                    <input type="hidden" id="orderby-input" name="orderBy" value="{{ request('orderBy') }}">
                                    <a href="javascript:" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'max_rate' ? 'active' : '') : 'active'  }}" data-orderby="max_rate">بیشترین امتیاز</a>
                                    <a href="javascript:" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'min_rate' ? 'active' : '') : ''  }}" data-orderby="min_rate">کمترین امتیاز</a>
                                </div>

                            </div>

                        </form>
                        </div>
                    @if($rates->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-2 text-right">#</th>
                                        <th class="p-2 text-right">عنوان</th>
                                        <th class="p-2 text-center">ip</th>
                                        <th class="p-2 text-center">امتیاز</th>
                                        <th class="p-2 text-left"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rates as $rate)
                                        <tr>
                                            <td class="text-right">{{ $rate->id }}</td>
                                            <td class="text-right">
                                                <a href="{{ $rate->route }}" target="_blank">{{ $rate->title }}</a>
                                            </td>
                                            <td class="text-center">{{ $rate->ip }}</td>
                                            <td class="text-center">{{ $rate->rate }}</td>
                                            <td class="p-2 text-left">
                                                <form class="d-inline" method="post" action="{{ route('panel.rates.destroy',$rate->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')" type="submit">حذف</button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             {{ $rates->links() }}
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

@section('scripts')

<script>
      $('.products-order-btn').click(function(){
            $('#orderby-input').val($(this).data('orderby'));
            $('#filters').submit();
        })

</script>

@endsection
