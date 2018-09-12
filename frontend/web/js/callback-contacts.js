$(document).ready(function (){
    if ($('.callback-phone-field').length) {
        $('.callback-phone-field').mask("+375 (99) 999-99-99");
    }
$('.callback-button').click(function (){
    $(this).next().toggle( "fast", function() {
    });
});
});