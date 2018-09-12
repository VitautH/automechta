define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';
    $('#execute_date-datepicker').datepicker();

    $('#task-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function (response) {
                if (response['status'] == 'success') {
                    $('#task-form').find("input[type=text], textarea").val("");
                    modal.toast('Успех!', 'Задача отправлена');
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