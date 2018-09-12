define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';

    $('#decline-task').click(function () {
        $('.popup').show();
        $('.modal-block').show();
    });

    $('.modal-block button.close').click(function () {
        $('.popup').hide();
        $('.modal-block').hide();
    });

    $('#decline-task-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function (response) {
                if (response['status'] == 'success') {
                    $('.popup').hide();
                    $('.modal-block').hide();
                    $('td.action').empty();
                    var text ='<span>Отправлена на доработку</span>';
                    $('td.action').html(text);
                    modal.toast('Статус изменён!', 'Задача отправлена на доработку');
                }
                if (response['status'] == 'failed') {
                    if (response['message'] != null) {
                        $('.popup').hide();
                        $('.modal-block').hide();
                        modal.toast('Ошибка!', response['message']);
                    }
                    else {
                        $('.popup').hide();
                        $('.modal-block').hide();
                        modal.toast('Ошибка!', 'Произошла ошибка');
                    }
                }
            },
            error:

                function (response) {
                    $('.popup').hide();
                    $('.modal-block').hide();
                    modal.toast('Ошибка!', 'Произошла ошибка');
                }
        });
    });
    $('#approve-task').click(function (e) {
        e.preventDefault();

        var data = {};
        data.id = $(this).data("id");
        data.status = $(this).data("status");
        data.employee_to =$(this).data("employee_to");

        $.ajax({
            type: "POST",
            url: $(this).data("action"),
            data: data,
            success: function (response) {
                if (response['status'] == 'success') {
                    $('td.action').empty();
                    var text ='<span>Одобрено! Задача закрыта</span>';
                    $('td.action').html(text);
                    modal.toast('Статус изменён!', 'Задача закрыта');
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