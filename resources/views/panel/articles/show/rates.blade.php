@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>مشاهده امتیازات مقاله</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                @include('panel.articles.show.tab')
                <div class="card card-body">
                    <h5>
                        مشاهده امتیازات:
                        <a href="{{ $article->getRoute() }}" target="_blank">{{ $article->title }}</a>
                    </h5>
                    <hr/>
                    @if($rates->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>آدرس ip</th>
                                <th class="text-center">امتیاز</th>
                                <th class="text-left">تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($rates as $rate)
                                    <tr>
                                        <td>{{ $rate->ip }}</td>
                                        <td class="text-center">{{ $rate->rate }}</td>
                                        <td class="text-left">{{ jd($rate->created_at) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="overflow-auto">
                            {{ $rates->links() }}
                        </div>
                    @else
                        @include('components.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
