<div class="card card-body p-2">
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item">
            <a class="nav-link {{ checkActive(['panel.products.edit']) ? 'active' : '' }}" href="{{ route('panel.products.edit',[$product]) }}">ویرایش محصول</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ checkActive(['panel.products.attributes']) ? 'active' : '' }}" href="{{ route('panel.products.attributes',[$product]) }}">ویرایش ویژگی ها</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ checkActive(['panel.products.variations']) ? 'active' : '' }}" href="{{ route('panel.products.variations',[$product]) }}">ویرایش متغیر ها</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ checkActive(['panel.products.logs']) ? 'active' : '' }}" href="{{ route('panel.products.logs',[$product]) }}">تاریخچه تغییرات</a>
        </li>
    </ul>
</div>
