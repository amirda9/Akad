<div class="bg-white p-3 rounded shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="text-secondary m-0">تصاویر ثابت</h4>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#add_image_block_modal">
            افزودن
        </button>
    </div>
    @if($image_blocks->count())
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
            @foreach($image_blocks as $image_block)
                <tr>
                    <td>{{ $image_block['title'] }}</td>
                    <td>{{ $image_block['order'] }}</td>
                    <td>{{ \App\Option::$positions[$image_block['position']] }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary edit_image_block_button"
                                data-route="{{ route('panel.widgets.update',$image_block['id']) }}"
                                data-id="{{ $image_block['id'] }}"
                                data-title="{{ $image_block['title'] }}"
                                data-order="{{ $image_block['order'] }}"
                                data-position="{{ $image_block['position'] }}"
                                data-image1="{{ $image_block['image1'] }}"
                                data-image2="{{ $image_block['image2'] }}"
                                data-image3="{{ $image_block['image3'] }}"
                                data-image4="{{ $image_block['image4'] }}"
                                data-link1="{{ $image_block['link1'] }}"
                                data-link2="{{ $image_block['link2'] }}"
                                data-link3="{{ $image_block['link3'] }}"
                                data-link4="{{ $image_block['link4'] }}"
                                data-imagesclass="{{ $image_block['images_class'] ?? '' }}"
                                data-containerclass="{{ $image_block['container_class'] ?? '' }}"
                                data-toggle="modal" data-target="#edit_image_block_modal">
                            ویرایش
                        </button>
                        <form class="d-inline" method="post" action="{{ route('panel.widgets.destroy',$image_block['id']) }}">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="name" value="image_block">
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
    <div class="modal fade" id="add_image_block_modal"
         tabindex="-1" role="dialog"
         aria-labelledby="add_image_block_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_image_block_modal_label">افزودن تصویر ثابت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('panel.widgets.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="name" value="image_block">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="title">عنوان</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="عنوان ابزارک را وارد کنید">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="images_class">کلاس تصاویر</label>
                                <input type="text" class="form-control" id="images_class"
                                       name="images_class" placeholder="کلاس تصاویر">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="container_class">کلاس ویجت</label>
                                <input type="text" class="form-control" id="container_class"
                                       name="container_class" placeholder="کلاس ویجت">
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
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="image1">تصویر اول</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image1" id="image1" placeholder="آدرس تصویر اول">
                                    </div>
                                    <div class="col-6">
                                        <label for="link1">لینک اول</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link1" id="link1" placeholder="لینک اول">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="image2">تصویر دوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image2" id="image2" placeholder="آدرس تصویر دوم">
                                    </div>
                                    <div class="col-6">
                                        <label for="link2">لینک دوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link2" id="link2" placeholder="لینک دوم">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="image3">تصویر سوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image3" id="image3" placeholder="آدرس تصویر سوم">
                                    </div>
                                    <div class="col-6">
                                        <label for="link3">لینک سوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link3" id="link3" placeholder="لینک سوم">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="image4">تصویر چهارم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image4" id="image4" placeholder="آدرس تصویر چهارم">
                                    </div>
                                    <div class="col-6">
                                        <label for="link4">لینک چهارم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link4" id="link4" placeholder="لینک چهارم">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">ثبت فرم</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_image_block_modal"
         tabindex="-1" role="dialog"
         aria-labelledby="edit_image_block_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_image_block_modal_label">ویرایش تصویر ثابت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_image_block_form" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="name" value="image_block">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="edit_title">عنوان</label>
                                <input type="text" class="form-control" id="edit_title" name="title" placeholder="عنوان ابزارک را وارد کنید">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="images_class">کلاس تصاویر</label>
                                <input type="text" class="form-control" id="edit_images_class"
                                       name="images_class" placeholder="کلاس تصاویر">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="edit_container_class">کلاس ویجت</label>
                                <input type="text" class="form-control" id="edit_container_class"
                                       name="container_class" placeholder="کلاس ویجت">
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
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit_image1">تصویر اول</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image1" id="edit_image1" placeholder="آدرس تصویر اول">
                                    </div>
                                    <div class="col-6">
                                        <label for="edit_link1">لینک اول</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link1" id="edit_link1" placeholder="لینک اول">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit_image2">تصویر دوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image2" id="edit_image2" placeholder="آدرس تصویر دوم">
                                    </div>
                                    <div class="col-6">
                                        <label for="edit_link2">لینک دوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link2" id="edit_link2" placeholder="لینک دوم">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit_image3">تصویر سوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image3" id="edit_image3" placeholder="آدرس تصویر سوم">
                                    </div>
                                    <div class="col-6">
                                        <label for="edit_link3">لینک سوم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link3" id="edit_link3" placeholder="لینک سوم">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit_image4">تصویر چهارم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="image4" id="edit_image4" placeholder="آدرس تصویر چهارم">
                                    </div>
                                    <div class="col-6">
                                        <label for="edit_link4">لینک چهارم</label>
                                        <input type="text" class="form-control dir-ltr text-left"
                                               name="link4" id="edit_link4" placeholder="لینک چهارم">
                                    </div>
                                </div>
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
        $('body').on('click','.edit_image_block_button',function (e) {
            let form = $('#edit_image_block_form');
            console.log($(this).data('imagesclass'),$(this).data('containerclass'))
            form.attr('action',$(this).data('route'));
            form.find('#edit_title').val($(this).data('title'));
            form.find('#edit_order').val($(this).data('order'));
            form.find('#edit_position').val($(this).data('position'));
            form.find('#edit_image1').val($(this).data('image1'));
            form.find('#edit_image2').val($(this).data('image2'));
            form.find('#edit_image3').val($(this).data('image3'));
            form.find('#edit_image4').val($(this).data('image4'));
            form.find('#edit_link1').val($(this).data('link1'));
            form.find('#edit_link2').val($(this).data('link2'));
            form.find('#edit_link3').val($(this).data('link3'));
            form.find('#edit_link4').val($(this).data('link4'));
            form.find('#edit_images_class').val($(this).data('imagesclass'));
            form.find('#edit_container_class').val($(this).data('containerclass'));
        })
    </script>
@endpush
