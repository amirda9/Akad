@foreach($items ?? [] as $item)
    <li class="level-{{ $item->level }}">
        <a class="{{ request()->url() == $item->getRoute() ? 'active' : '' }}" href="{{ $item->getRoute() }}">
            <span>
                @if($item->icon_class)
                    <i class="{{$item->icon_class}}"></i>
                @endif
            {{ $item->title }}
            </span>
            @if($item->children()->count())
                <i class="icon far fa-angle-left"></i>
            @endif
        </a>
        @if($item->children()->count())
            <ul class="sub_menu">
                @include('other.main_menu_items',[
                    'items' => $item->children()->orderBy('order','asc')->get()
                ])
            </ul>
        @endif
    </li>

@endforeach
