@foreach($items ?? [] as $item)
    <li class="level-{{ $item->level }}">
        <a class="{{ request()->url() == $item->getRoute() ? 'active' : '' }}" href="{{ $item->getRoute() }}">
            <span>{{ $item->title }}</span>
            @if($item->children()->count())
                <button class="open-submenu">
                    <i class="icon fal fa-plus-circle"></i>
                    <i class="icon fal fa-minus-circle"></i>
                </button>
            @endif
        </a>
        @if($item->children()->count())
            <ul class="sub_menu">
                @include('other.drawer_menu_items',[
                    'items' => $item->children()->orderBy('order','asc')->get()
                ])
            </ul>
        @endif
    </li>

@endforeach