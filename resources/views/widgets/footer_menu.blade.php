@if($menu)
    <h5 class="mb-2">{{ $menu->title }}</h5>
    <ul class="list-unstyled m-0">
        @foreach($menu->items as $item)
            <li class="d-block py-1">
                <a class="text-gray-600 text-decoration-none" href="{{ $item->getRoute() }}">
                    <i class="fal fa-angle-left ml-2"></i>
                    {{ $item->title }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
