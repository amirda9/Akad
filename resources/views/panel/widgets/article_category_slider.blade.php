<div class="bg-white p-3 rounded shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="text-secondary m-0">آخرین مقالات دسته بندی</h4>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#add_article_category_slider_modal">
            افزودن
        </button>
    </div>
    @if($article_category_sliders->count())
        <table class="table">
            <thead>
            <tr class="bg-gray-100">
                <th>عنوان</th>
                <th>ترتیب</th>
                <th>موقعیت</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($article_category_sliders as $article_category_slider)
                <tr>
                    <td>{{ $article_category_slider['title'] }}</td>
                    <td>{{ $article_category_slider['order'] }}</td>
                    <td>{{ \App\Option::$positions[$article_category_slider['position']] }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary edit_article_category_slider_button"
                                data-route="{{ route('panel.widgets.update',$article_category_slider['id']) }}"
                                data-id="{{ $article_category_slider['id'] }}"
                                data-order="{{ $article_category_slider['order'] }}"
                                data-position="{{ $article_category_slider['position'] }}"
                                data-category="{{ $article_category_slider['category_id'] }}"
                                data-toggle="modal" data-target="#edit_article_category_slider_modal">
                            ویرایش
                        </button>
                        <form class="d-inline" method="post" action="{{ route('panel.widgets.destroy',$article_category_slider['id']) }}">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="name" value="article_category_slider">
                            <button class="btn btn-sm btn-danger" type="submit"
                                    onclick="return confirm('آیا مطمئن هستید؟')">
                                حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        @include('components.empty')
    @endif
</div>

@push('bottom')
    <div class="modal fade" id="add_article_category_slider_modal"
         tabindex="-1" role="dialog"
         aria-labelledby="add_article_category_slider_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_article_category_slider_modal_label">افزودن اسلایدر دسته بندی مقالات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('panel.widgets.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="name" value="article_category_slider">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="category_id">انتخاب دسته بندی</label>
                                <select class="form-control selectpicker" data-live-search="true"
                                        name="category_id" id="category_id">
                                    @foreach($article_categories as $article_category)
                                        <option value="{{$article_category['id']}}">{{$article_category['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="order">ترتیب نمایش</label>
                                <input type="text" class="form-control" id="order" value="0"
                                       name="order" placeholder="ترتیب نمایش را وارد کنید">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="position">موقعیت</label>
                                <select class="form-control" name="position" id="position">
                                    @foreach($positions as $key => $position)
                                        <option value="{{$key}}">{{$position}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">ثبت فرم</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_article_category_slider_modal"
         tabindex="-1" role="dialog"
         aria-labelledby="edit_article_category_slider_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_article_category_slider_modal_label">ویرایش اسلایدر دسته بندی مقالات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_article_category_slider_form" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="name" value="article_category_slider">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="edit_category_id">انتخاب دسته بندی</label>
                                <select class="form-control selectpicker" data-live-search="true"
                                        name="category_id" id="edit_category_id">
                                    @foreach($article_categories as $article_category)
                                        <option value="{{$article_category['id']}}">{{$article_category['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="edit_order">ترتیب نمایش</label>
                                <input type="text" class="form-control" id="edit_order" name="order"
                                       placeholder="ترتیب نمایش">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="edit_position">موقعیت</label>
                                <select class="form-control" name="position" id="edit_position">
                                    @foreach($positions as $key => $position)
                                        <option value="{{$key}}">{{$position}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">ثبت فرم</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $('body').on('click','.edit_article_category_slider_button',function (e) {
            let form = $('#edit_article_category_slider_form');
            form.attr('action',$(this).data('route'));
            form.find('#edit_order').val($(this).data('order'));
            form.find('#edit_category_id').selectpicker('val', $(this).data('category'));
            form.find('#edit_position').val($(this).data('position'));
        })
    </script>
@endpush
