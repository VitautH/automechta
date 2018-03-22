define(['jquery'], function ($) {
    'use strict';

    $('.send-mailing').on('click', function (e) {
        e.preventDefault();

        var r = confirm('Вы хотите отправить рассылку?');
        if (r == true) {
            var send_url = $(this).data('send_url');
            $.ajax({
                beforeSend: function () {
                    $('#loader').show();
                },
                complete: function () {
                    $('#loader').hide();
                },
                url: send_url,
                type: 'GET',
                success: function (data) {
                    if (data == true) {
                        alert('Отправка рассылки завершена!');
                        location.reload();
                    }
                    else {
                        alert('Произошла ошибка!');
                    }
                },
                error: function (data) {
                    alert('Произошла ошибка!');

                }
            });
        }
    });
    $('.js-delete-row').on('click', function (e) {
        e.preventDefault();

        var r = confirm('Вы хотите удалить рассылку?');
        if (r == true) {
            var delete_url = $(this).data('delete_url');
            $.ajax({
                url: delete_url,
                type: 'GET',
                success: function (response) {
                    location.reload();
                },
                error: function (data) {
                    alert('Произошла ошибка!');
                }
            });
        }
    });
});