@if($categories ?? false)
    @foreach($categories as $category)
        <option {{ in_array($category->id,$selected_categories ?? []) ? 'selected' : '' }} value={{ $category->id }}> {{str_repeat('—',$category->level)}} {{ $category->name }}</option>
        @include('panel.articleCategories.childrenOptions',[
            'categories' => $category->children,
            'selected_categories' => $selected_categories ?? [],
        ])
    @endforeach
@endif