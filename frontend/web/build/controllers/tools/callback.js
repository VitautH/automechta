define(['jquery', 'application', 'maskedinput','modal'], function ($, application, mask,modal) {
    'use strict';
if ($('#callback-phone-field').length) {
        $('#callback-phone-field').mask("+375 (99) 999-99-99");
    }
    $('#callback-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function (response) {
                if (response['status'] == 'success'){
                    $('#callback-form').find("input[type=text]").val("");
                    $( "#callback-form" ).after( "<span class='callback-form-succes'>Мы свяжемся с Вами в ближайшее время.</span>" );
                    setTimeout(function(){
                        $('.callback-form-succes').fadeOut( "slow", function() {
                            $('.callback-form-succes').remove();
                        });
                    }, 1000);
                }
                if (response['status'] == 'failed') {
                    $('.callback-form').find("input[type=text]").val("");
                        modal.toast('Ошибка!', 'Произошла ошибка');
                }
            },
            error:
                function () {
                    $('.callback-form').find("input[type=text]").val("");
                     modal.toast('Ошибка!', 'Произошла ошибка');
                }
        });
    });

});