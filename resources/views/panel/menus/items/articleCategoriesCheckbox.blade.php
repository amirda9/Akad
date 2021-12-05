@if($categories ?? false)
    @foreach($categories as $category)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" name="article_categories[]" value="{{ $category->id }}"
                   class="custom-control-input select_article_categories"
                   id="select_article_categories_{{ $category->id }}">
            <label class="custom-control-label"
                   for="select_article_categories_{{ $category->id }}">{{str_repeat('—',$category->level)}} {{ $category->name }}</label>
        </div>
        @include('panel.menus.items.articleCategoriesCheckbox',[
            'categories' => $category->children()->orderBy('order','asc')->get(),
            'selected_categories' => $selected_categories ?? [],
        ])
    @endforeach
@endif