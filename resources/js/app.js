require('./bootstrap');
require('../../node_modules/bootstrap-select/dist/js/bootstrap-select.min');
require('../../node_modules/bootstrap-select/dist/js/i18n/defaults-fa_IR.min');
require('../../node_modules/jquery-toast-plugin/dist/jquery.toast.min');

$('body').on('click','#drawer-toggler',function (e) {
    e.preventDefault();
    $('#drawer').toggleClass('open');
}).on('click','.close-btn',function (e) {
    $('#drawer').removeClass('open');
}).on('click','.open-submenu',function (e) {
    e.preventDefault();
    $(this).closest('li').toggleClass('open');
});


var mySwiper = new Swiper('.category-product-slider', {
    slidesPerView: 2,
    spaceBetween: 10,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        400: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 15,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    }
})
$('.collapse-with-rotate').on('click', function () {
    var rotate = $(this).find('.rotate');
    rotate.toggleClass(rotate.data('rotate'));
});
$(document).ready(function(){
    $('.toast').toast('show');
});
