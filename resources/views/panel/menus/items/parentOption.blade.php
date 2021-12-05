@if($parents ?? false)
    @foreach($parents as $parent)
        <option {{ in_array($parent->id, $selected_parents ?? []) ? 'selected' : '' }}
                value="{{ $parent->id }}">{{str_repeat('—',$parent->level)}} {{ $parent->title }}</option>
        @include('panel.menus.items.parentOption',[
            'parents' => $parent->children,
            'selected_parents' => $selected_parents ?? [],
        ])
    @endforeach
@endif