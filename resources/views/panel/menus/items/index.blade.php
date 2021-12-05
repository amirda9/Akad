@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>مدیریت آیتم های منو</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            @include('components.messages')

            <div class="row">
                <div class="col-12 col-lg-3">

                    <div id="add_item_accordion" class="bg-white shadow-sm mb-4">

                        <div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center btn p-3"
                                 data-toggle="collapse" data-target="#add_custom_link"
                                 aria-expanded="false" aria-controls="add_custom_link">
                                <strong>لینک دلخواه</strong>
                                <i class="collapse-icon fad fa-chevron-down"></i>
                            </div>
                            <div id="add_custom_link" class="collapse p-3" data-parent="#add_item_accordion">
                                <form method="POST" action="{{ route('panel.menuItems.store', $menu) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="link">
                                    <div class="form-group">
                                        <label for="title">عنوان آیتم</label>
                                        <input type="text" class="form-control"
                                               id="title" placeholder="عنوان آیتم را وارد کنید"
                                               name="title" value="{{ old('title') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="link">لینک آیتم</label>
                                        <input type="text" class="form-control text-left dir-ltr"
                                               id="link" placeholder="http://example.com"
                                               name="link" value="{{ old('link') }}">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="new_page" id="new_page">
                                            <label class="custom-control-label" for="new_page">نمایش در پنجره جدید</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">افزودن</button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center btn p-3"
                                 data-toggle="collapse" data-target="#add_product_category"
                                 aria-expanded="false" aria-controls="add_product_category">
                                <strong>دسته بندی محصول</strong>
                                <i class="collapse-icon fad fa-chevron-down"></i>
                            </div>
                            <div id="add_product_category" class="collapse p-3" data-parent="#add_item_accordion">
                                <form method="POST" action="{{ route('panel.menuItems.store', $menu) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="product_category">
                                    <div class="form-group">
                                        <div class="p-2 border" style="max-height: 300px; overflow-y: scroll;">
                                            <input type="text" class="form-control form-control-sm mb-2" id="search_product_categories" placeholder="جستجو ...">
                                            @include('panel.menus.items.productCategoriesCheckbox',[
                                                'categories' => $product_categories,
                                                'selected_categories' => request('product_categories') ?? [],
                                            ])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="#" id="select_all_product_categories">
                                            انتخاب همه
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-primary">افزودن</button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center btn p-3"
                                 data-toggle="collapse" data-target="#add_page"
                                 aria-expanded="false" aria-controls="add_page">
                                <strong>صفحات ثابت</strong>
                                <i class="collapse-icon fad fa-chevron-down"></i>
                            </div>
                            <div id="add_page" class="collapse p-3" data-parent="#add_item_accordion">
                                <form method="POST" action="{{ route('panel.menuItems.store', $menu) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="page">
                                    <div class="form-group">
                                        <div class="p-2 border" style="max-height: 300px; overflow-y: scroll;">
                                            <input type="text" class="form-control form-control-sm mb-2" id="search_pages" placeholder="جستجو ...">
                                            @foreach($pages as $page)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pages[]" value="{{ $page->id }}"
                                                           class="custom-control-input select_pages"
                                                           id="select_page_{{ $page->id }}">
                                                    <label class="custom-control-label"
                                                           for="select_page_{{ $page->id }}">{{ $page->title }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="#" id="select_all_pages">
                                            انتخاب همه
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-primary">افزودن</button>
                                </form>
                            </div>
                        </div>
                       

                        <div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center btn p-3"
                                 data-toggle="collapse" data-target="#add_article_category"
                                 aria-expanded="false" aria-controls="add_article_category">
                                <strong>دسته بندی مقالات</strong>
                                <i class="collapse-icon fad fa-chevron-down"></i>
                            </div>
                            <div id="add_article_category" class="collapse p-3" data-parent="#add_item_accordion">
                                <form method="POST" action="{{ route('panel.menuItems.store', $menu) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="article_category">
                                    <div class="form-group">
                                        <div class="p-2 border" style="max-height: 300px; overflow-y: scroll;">
                                            <input type="text" class="form-control form-control-sm mb-2" id="search_article_categories" placeholder="جستجو ...">
                                            @include('panel.menus.items.articleCategoriesCheckbox',[
                                                'categories' => $article_categories,
                                                'selected_categories' => request('article_categories') ?? [],
                                            ])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="#" id="select_all_article_categories">
                                            انتخاب همه
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-primary">افزودن</button>
                                </form>
                            </div>
                        </div>



                    </div>


                </div>
                <div class="col-12 col-lg-9">
                    <div class="bg-white shadow-sm p-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <h4 class="m-0 text-secondary">
                                {{ $menu->title }}
                            </h4>
                            <a class="btn btn-secondary"
                               href="{{ route('panel.menus.index') }}">
                                بازگشت
                            </a>
                        </div>
                        <hr/>
                        @if($menuItems->count())
                            @include('panel.menus.items.menuItem',[
                                'menuItems' => $menuItems,
                            ])
                        @else
                            @include('components.empty')
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</div>
    
@endsection

@push('scripts')
    <script>
        $('body').on('click','#select_all_product_categories',function(e){
            e.preventDefault();
            $('.select_product_categories').each(function(){
                if($(this).prop('checked') === true) {
                    $(this).prop('checked',false);
                } else {
                    $(this).prop('checked',true);
                }
            });
            })
            .on('click','#select_all_article_categories',function(e){
            e.preventDefault();
            $('.select_article_categories').each(function(){
                if($(this).prop('checked') === true) {
                    $(this).prop('checked',false);
                } else {
                    $(this).prop('checked',true);
                }
            });
        }).on('click','#select_all_pages',function(e){
            e.preventDefault();
            $('.select_pages').each(function(){
                if($(this).prop('checked') === true) {
                    $(this).prop('checked',false);
                } else {
                    $(this).prop('checked',true);
                }
            });
        }).on('keyup','#search_product_categories',function(e){
            e.preventDefault();
            $('.select_product_categories').each(function(){
                let parent = $(this).parent();
                let label = parent.find('label').text();
                let search  = $('#search_product_categories').val();
                if(search.length) {
                    if(label.search(search) === -1) {
                        parent.addClass('d-none');
                    } else {
                        parent.removeClass('d-none');
                    }
                } else {
                    parent.removeClass('d-none');
                }
            });
        }).on('keyup','#search_article_categories',function(e){
            e.preventDefault();
            $('.select_article_categories').each(function(){
                let parent = $(this).parent();
                let label = parent.find('label').text();
                let search  = $('#search_article_categories').val();
                if(search.length) {
                    if(label.search(search) === -1) {
                        parent.addClass('d-none');
                    } else {
                        parent.removeClass('d-none');
                    }
                } else {
                    parent.removeClass('d-none');
                }
            });
        }).on('keyup','#search_pages',function(e){
            e.preventDefault();
            $('.select_pages').each(function(){
                let parent = $(this).parent();
                let label = parent.find('label').text();
                let search  = $('#search_pages').val();
                if(search.length) {
                    if(label.search(search) === -1) {
                        parent.addClass('d-none');
                    } else {
                        parent.removeClass('d-none');
                    }
                } else {
                    parent.removeClass('d-none');
                }
            });
        })
    </script>
@endpush
