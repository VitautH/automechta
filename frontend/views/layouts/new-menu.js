$(document).ready(function () {
    $('#hamburger').click(function () {
        $(this).toggleClass('open');
        $('.mobile-menu').toggleClass('open-menu');
        $('html').toggleClass('fixed-body');
    });

    $('.dropdown-custom-toggle').click(function () {
        $(this).toggleClass('open-dropdown');
    });

    $('#show-callback-form').click(function(){
        $( ".menu-callback" ).toggle(1, function() {
        } );
    })

    $('#show-credit-calculator').click(function(){
        $( ".menu-credit-clculator" ).toggle(1, function() {
        } );
    });
});
