@extends('panel.layouts.master')

@section('head')
    <style>
        .attribute-card .edit-attribute {
            display: none;
        }
        .attribute-card.edit .edit-attribute {
            display: block;
        }
        .attribute-card.edit .attribute-items {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('panel.products.edit.tab')
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <h1 class="m-0">ویژگی های محصول</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAttributeModal">
                        افزودن ویژگی
                    </button>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <div class="row">
                    @foreach($attributes as $attribute)
                        <div class="col-12 col-lg-6">
                            <div class="card card-body attribute-card">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">{{ $attribute->title }}@if($attribute->pivot->variation)<small class="mr-2">(متغیر)</small>@endif</h5>
                                    <div>
                                        <button class="btn btn-sm btn-light text-primary edit-attribute-btn"
                                           title="ویرایش"
                                            ><i class="far fa-edit"></i></button>
                                        <form class="d-inline" method="post"
                                              action="{{ route('panel.products.attributes.destroy',$product) }}">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                                            <button onclick="return confirm('آیا مطمئن هستید؟')" type="submit" class="btn btn-sm btn-light text-danger"
                                               title="حذف"
                                            ><i class="far fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <hr/>
                                <div class="d-flex flex-row flex-wrap attribute-items" style="max-height: 200px; overflow: auto">
                                    @foreach($attribute->pivot->items as $item)
                                        <span class="bg-light d-inline-block px-3 py-1 m-1 rounded-5">{{ $item->title }}</span>
                                    @endforeach
                                </div>
                                <div class="edit-attribute">
                                    <form method="post" action="{{ route('panel.products.attributes.update',$product) }}">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                                        <div class="d-flex flex-row flex-wrap mb-2" style="max-height: 200px; overflow: auto">
                                            @foreach($attribute->items as $item)
                                                <label for="attributeItem{{$item->id}}" class="bg-light d-flex align-items-center justify-content-center px-3 py-1 m-1 rounded-5">
                                                    <input name="items[]" type="checkbox" value="{{ $item->id }}" {{ in_array($item->id,$attribute->pivot->value) ? 'checked' : '' }} id="attributeItem{{$item->id}}">
                                                    <span class="mr-2">{{ $item->title }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="visibility" {{ $attribute->pivot->visibility ? 'checked' : '' }}
                                                       class="custom-control-input" id="visibility-{{$attribute->id}}">
                                                <label class="custom-control-label" for="visibility-{{$attribute->id}}">نمایش در برگه محصول</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="variation" {{ $attribute->pivot->variation ? 'checked' : '' }}
                                                       class="custom-control-input" id="variation-{{$attribute->id}}">
                                                <label class="custom-control-label" for="variation-{{$attribute->id}}">استفاده برای متغیرها</label>
                                                <div>
                                                    <small class="text-muted">در صورت غیرفعال شدن متغیرهای مربوطه حذف خواهد شد</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-success" type="submit">ذخیره</button>
                                        <button class="btn btn-sm btn-light mr-3 cancel-edit-attribute-btn" type="button">لغو تغییرات</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom')
    <!-- Modal -->
    <div class="modal fade" id="addAttributeModal" tabindex="-1" aria-labelledby="addAttributeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAttributeModalLabel">افزودن ویژگی</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('panel.products.attributes.store',$product) }}">
                        @csrf
                        <div class="form-group">
                            <label for="attributes">ویژگی</label>
                            <select required class="form-control selectpicker" id="attributes" name="attribute_id">
                                @foreach($attribute_groups as $attribute_group)
                                    <option value="">انتخاب کنید</option>
                                    <optgroup label="{{ $attribute_group->title }}">
                                        @foreach($attribute_group->attributes as $attribute)
                                            <option value="{{ $attribute->id}}" data-items="{{ json_encode($attribute->items) }}">{{ $attribute->title }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="items">مقادیر</label>
                            <select required multiple data-actions-box="true" data-live-search="true" class="form-control selectpicker" id="items" name="items[]">
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="visibility"
                                       class="custom-control-input" id="create_visibility">
                                <label class="custom-control-label" for="create_visibility">نمایش در برگه محصول</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="variation"
                                       class="custom-control-input" id="create_variation">
                                <label class="custom-control-label" for="create_variation">استفاده برای متغیرها</label>
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">افزودن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('body').on('change','#attributes',function() {
            let items = $('#attributes :selected').data('items');
            let el = $('#items');
            el.html('');
            if(!!items) {
                items.map(function(item) {
                    el.append(`<option value="${item.id}">${item.title}</option>`);
                })
            }
            $('.selectpicker').selectpicker('refresh');
        }).on('click','.edit-attribute-btn',function() {
            $(this).closest('.attribute-card').toggleClass('edit');
        }).on('click','.cancel-edit-attribute-btn',function() {
            $(this).closest('.attribute-card').removeClass('edit');
        });

    </script>
@endsection
