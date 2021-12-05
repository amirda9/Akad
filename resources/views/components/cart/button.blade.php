<div id="cardDropdownContainer" class="{{ session('show_cart_dropdown') ? 'show' : '' }}">
    <button type="button" class="border-0 px-3 py-2 bg-transparent"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ session('show_cart_dropdown') ? 'true' : 'false' }}">
        <i class="far fa-shopping-bag fa-fw" style="font-size: 25px;"></i>
        <small>{{ Cart::count() }}</small>
    </button>
    <div id="cardDropdown" class="dropdown-menu border-0 mt-1 shadow {{ session('show_cart_dropdown') ? 'show' : '' }}">
        @include('components.cart.dropdown')
    </div>
</div>
