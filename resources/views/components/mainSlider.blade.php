<div id="mainSlider" class="swiper-container overflow-hidden rounded-2 shadow">
    <div class="swiper-wrapper">
        @foreach($slides as $slide)
            <div class="swiper-slide">
                @if($slide->link)
                    <a href="{{ $slide->link }}" class="">
                        <img class="w-100" src="{{ getImageSrc($slide->image) }}" />
                    </a>
                @else
                    <img class="w-100" src="{{ getImageSrc($slide->image) }}" />
                @endif
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

@push('scripts')
    <script>
        var mySwiper = new Swiper ('.swiper-container', {
            effect: 'fade',
            loop: true,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        })
    </script>
@endpush
