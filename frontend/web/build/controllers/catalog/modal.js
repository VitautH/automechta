$('.modal-login').hide();
$(document).ready(function(){
    $('.popup-block').hide();
        $('#seller-phone-show').click(function () {
            $('.popup-block').show();
            $('.seller-phone-block').show();
        });
    $('.cancel').click(function () {
        $('.popup-block').hide();
        $('.seller-phone-block').hide();
    });

    $('#credit-phone-show').click(function () {
        $('.popup-block').show();
        $('.credit-phone-block').show();
    });
    $('.cancel').click(function () {
        $('.popup-block').hide();
        $('.credit-phone-block').hide();
    });

$('#complaint_to_mobile').click(function(){
$('#complaint_block_mobile').toggle();
});


 $('#show-login-modal').click(function () {
     $('.modal-login').show();
     $('.popup-block').show();
 });

    $('.modal-login .modal-close').click(function () {
        $('.modal-login').hide();
        $('.popup-block').hide();
    });
});