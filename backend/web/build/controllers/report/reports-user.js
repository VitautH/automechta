define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';
    $('#datepicker').datepicker();
    $('#report-update-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function (response) {
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
                    // modal.toast('Ошибка!', 'Произошла ошибка');
                }
        });
    });
});