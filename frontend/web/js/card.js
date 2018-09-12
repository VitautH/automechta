$(document).ready(function () {
    $('.card-carousel').slick({
        dots: false,
        arrows: false
    });
    $('#call-to-client').click(function () {
        $('.modal-overlay').addClass('open-modal');
        $('html, body').css('overflow', 'hidden');
    });
    $('#close').click(function () {
        $('.modal-overlay').removeClass('open-modal');
        $('html, body').css('overflow', 'auto');
    });
    $('#complay').click(function () {
        $('.complay-form').slideToggle();
    });
    $('#complay-mob').click(function () {
        $('.complay-form-mobile').slideToggle();
    });
});
