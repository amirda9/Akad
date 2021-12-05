<ul class="nav nav-tabs">
    <li class="nav-item">
    <a class="nav-link {{ checkActive(['panel/coupons*']) ? 'active' : '' }}"  href="{{route('panel.coupons.show',$coupon)}}">جزئیات کوپن</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ checkActive([
        'panel/couponLimit*']) ? 'active' : '' }}" href="{{route('panel.coupons.limit',$coupon)}}">افزودن محدودیت</a>
    </li>
    
  </ul>