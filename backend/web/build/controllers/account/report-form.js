define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';
    $('#datepicker').datepicker();

    $('#report-field-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $('#report-field-form').attr("action"),
            data: $('#report-field-form').serialize(),
            success: function (response) {
                if (response['status'] == 'success') {
                    $('#report-field-form').find("input[type=text], textarea").val("");
                    modal.toast('Успех!', 'Отчёт отправлен');
                }
                if (response['status'] == 'failed') {
                    if (response['message'] != null) {
                        modal.toast('Ошибка!', response['message']);
                    }
                    else {
                        modal.toast('Ошибка!', 'Произошла ошибка');
                    }
                }
            },
            error:

                function (response) {
                    modal.toast('Ошибка!', 'Произошла ошибка');
                }
        });
    });
});