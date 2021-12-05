@if($menuItems ?? false)
    @foreach($menuItems as $menuItem)
        <div class="border mb-2 menu-item-row" data-itemid="{{ $menuItem->id }}">
            <div class="d-flex bg-gray-100 flex-wrap justify-content-between align-items-center p-2">
                <div class="level-{{ $menuItem->level }}">
                    <a href="{{ $menuItem->getRoute() }}">
                        {{ $menuItem->title }}
                    </a>
                    <small class="text-gray-500">({{ $menuItem->getTypeTitle() }})</small>
                </div>
                <div>
                    <form class="d-inline" method="post" action="{{ route('panel.menuItems.destroy', [$menu, $menuItem]) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger"
                                type="submit"
                                onclick="return confirm('آیا مطمئن هستید؟')" title="حذف">
                            حذف
                        </button>
                    </form>
                    <button class="btn btn-sm btn-primary" type="button"
                            data-toggle="collapse" data-target="#edit_menu_item_{{ $menuItem->id }}">
                        ویرایش
                    </button>
                </div>
            </div>
            <div class="collapse bg-white" id="edit_menu_item_{{ $menuItem->id }}">
                <div class="p-3">

                    <form id="edit-menuitem-{{ $menuItem->id }}" method="post" action="{{ route('panel.menuItems.update',[$menu, $menuItem]) }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-12 col-lg-6 form-group">
                                <label for="title-{{ $menuItem->id }}">عنوان</label>
                                <input type="text" class="form-control" value="{{ $menuItem->title }}"
                                       name="title" id="title-{{ $menuItem->id }}">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="parent-{{ $menuItem->id }}">آیتم والد</label>
                                <select class="form-control selectpicker" title="آیتم والد را انتخاب کنید" data-live-search="true"
                                        name="parent" id="parent-{{ $menuItem->id }}">
                                    <option value="">بدون والد</option>
                                    @include('panel.menus.items.parentOption',[
                                        'parents' => $parents,
                                        'selected_parents' => [$menuItem->parent_id]
                                    ])
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="icon-class-{{ $menuItem->id }}">کلاس آیکن</label>
                                <input type="text" class="form-control dir-ltr" id="icon-class-{{ $menuItem->id }}" name="icon_class" value="{{ $menuItem->icon_class }}">
                            </div>
                            <div class="col-12 col-lg-6 form-group">
                                <label for="order-{{ $menuItem->id }}">ترتیب</label>
                                <input type="number" class="form-control" id="order-{{ $menuItem->id }}" name="order" value="{{ $menuItem->order }}">
                            </div>
                            @if($menuItem->link)
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="link-{{ $menuItem->id }}">لینک</label>
                                    <input type="text" class="form-control text-left dir-ltr"
                                           id="link-{{ $menuItem->id }}" name="link" value="{{ $menuItem->link }}">
                                </div>
                            @endif
                            <div class="col-12 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" {{ $menuItem->new_page ? 'checked' : '' }}
                                           name="new_page" id="new_page_{{ $menuItem->id }}">
                                    <label class="custom-control-label" for="new_page_{{ $menuItem->id }}">نمایش در پنجره جدید</label>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form class="d-inline" method="post" action="{{ route('panel.menuItems.destroy', [$menu, $menuItem]) }}">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-sm btn-success"
                                onclick="event.preventDefault(); document.getElementById('edit-menuitem-{{ $menuItem->id }}').submit();">
                            ذخیره
                        </button>
                        <button class="btn btn-sm btn-danger"
                                type="submit"
                                onclick="return confirm('آیا مطمئن هستید؟')" title="حذف">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @include('panel.menus.items.menuItem',[
            'menuItems' => $menuItem->children()->orderBy('order','asc')->get(),
        ])
    @endforeach
@endif
