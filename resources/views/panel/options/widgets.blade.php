@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت ابزارک ها</h1>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="row">
                @foreach($widgets as $widget)
                    <div class="col-12 col-lg-6">
                        <div class="mb-4">
                            {!! $widget::form() !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
