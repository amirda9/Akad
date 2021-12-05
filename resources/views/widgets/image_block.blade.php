<div class="{{$config['container_class'] ?? ''}}">
    <div class="row">
        @php
        $class = 'col-12 mb-3';
        if($config['image2']) $class = 'col-12 col-lg-6 mb-3';
        if($config['image3']) $class = 'col-12 col-lg-4 mb-3';
        if($config['image4']) $class = 'col-12 col-md-6 col-lg-3 mb-3';
        @endphp

        @if($config['image1'])
            @if($config['link1'])
                <a class="{{ $class }}" href="{{ $config['link1'] }}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image1']) }}" />
                </a>
            @else
                <div class="{{$class}}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image1']) }}" />
                </div>
            @endif
        @endif
        @if($config['image2'])
            @if($config['link2'])
                <a class="{{ $class }}" href="{{ $config['link2'] }}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image2']) }}" />
                </a>
            @else
                <div class="{{ $class }}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image2']) }}" />
                </div>
            @endif
        @endif
        @if($config['image3'])
            @if($config['link3'])
                <a class="{{ $class }}" href="{{ $config['link3'] }}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image3']) }}" />
                </a>
            @else
                <div class="{{ $class }}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image3']) }}" />
                </div>
            @endif
        @endif
        @if($config['image4'])
            @if($config['link4'])
                <a class="{{ $class }}" href="{{ $config['link4'] }}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image4']) }}" />
                </a>
            @else
                <div class="{{ $class }}">
                    <img class="w-100 {{$config['images_class'] ?? ''}}" alt="{{ $config['title'] }}" src="{{ getImageSrc($config['image4']) }}" />
                </div>
            @endif
        @endif
    </div>
</div>
