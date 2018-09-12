$(document).ready(function () {
    $('.modal-login').hide();
    $('.modal-maps').hide();
    $('.popup-block').hide();
    $('.modal-login-mobile').hide();
    $('.show-modal-login').click(function () {
        $('.modal-login').show();
        $('.popup-block').show();
        $('body').css("overflow-y", "hidden");
    });
    $('.show-modal-login-mobile').click(function () {
        $('.modal-login').show();
        $('.popup-block').show();
        $('body').css("overflow-y", "hidden");
    });
    $('.modal-login .modal-close').click(function () {
        $('.modal-login').hide();
        $('.popup-block').hide();
        $('body').css("overflow-y", "visible");
    });

    $('.show-modal-callback').click(function () {
        $(window).scrollTop(0);
        $('.popup-block').show();
        $('.modal-callback').show();
        $('.modal-callback').find('.modal-login').show();
        $('body').css("overflow-y", "hidden");
    });
    $('.modal-callback .modal-close').click(function () {
        $('.popup-block').hide();
        $('.modal-callback').hide();
        $('.modal-callback').find('.modal-login').hide();
        $('body').css("overflow-y", "visible");
    });



    $('.reset-password').click(function () {
        $('.modal-login').hide();
        $('.modal-reset-password').show();
        $('.modal-reset-password').find('.modal-login').show();
        $('.popup-block').show();
        $('body').css("overflow-y", "hidden");
    });
    $('.modal-reset-password .modal-close').click(function () {
        $('.modal-reset-password').hide();
        $('.modal-reset-password').find('.modal-login').hide();
        $('.popup-block').hide();
        $('body').css("overflow-y", "visible");
    });

    $('.show-modal-registration').click(function () {
        $('.modal-registration').show();
        $('.modal-registration').find('.modal-login').show();
        $('.popup-block').show();
        $('body').css("overflow-y", "hidden");
    });

    $('.show-modal-registration-login-block').click(function () {
        $('.modal-login').hide();
        $('.modal-registration').show();
        $('.modal-registration').find('.modal-login').show();
    });

    $('.show-modal-registration-mobile').click(function () {
        $('.modal-registration').show();
        $('.modal-registration').find('.modal-login').show();
        $('.popup-block').show();
        $('body').css("overflow-y", "hidden");
    });
    $('.modal-registration .modal-close').click(function () {
        $('.modal-registration').hide();
        $('.modal-registration').find('.modal-login').hide();
        $('.popup-block').hide();
        $('body').css("overflow-y", "visible");
    });


    $('#show-modal-maps').click(function () {
        $('.modal-maps').show();
        $('body').css("overflow-y", "hidden");
    });

    $('.modal-maps .modal-close').click(function () {
        $('.modal-maps').hide();
        $('body').css("overflow-y", "visible");
    });

    /*
    Reset Password
     */
    $('#request-password-reset-form').submit(function(e){
        e.preventDefault();
        var form = $('#request-password-reset-form');
        var data = form.serialize();
        var url = form.attr( 'action' );
        $.ajax({
            data: data,
            url: url,
            dataType: 'html',
            type: "post",
            success: function (response) {
                var message = JSON.parse(response);
                if (message.status == 'success') {
                    $('.modal-reset-password').find('.body').empty();
                    $('.modal-reset-password').find('.body').html('<p style="font-size: 18px;">' + message.text + '</p>');
                }
                if (message.status == 'error') {
                    $('.modal-reset-password').find('.error').html('<p style="font-size: 18px;">' + message.text + '</p>');
                }
            },
            error: function () {
                var message = JSON.parse(response);
                if (message.status == 'success') {
                    $('.modal-reset-password').find('.body').empty();
                    $('.modal-reset-password').find('.body').html('<p style="font-size: 18px;">' + message.text + '</p>');
                }
            }
        });
        e.preventDefault();
    });
})