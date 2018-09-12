define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';

    $('.change-status').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).data('status_url'),
            success: function (response) {
                if (response['status'] == 'success') {
                    location.reload();
                }
                if (response['status'] == 'failed') {
                    modal.toast('Ошибка!', 'Произошла ошибка');
                }
            },
            error:
                function (response) {
                     modal.toast('Ошибка!', 'Произошла ошибка');
                }
        });
    });

    $('.js-delete-row').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).data('delete_url'),
            success: function (response) {
                if (response['status'] == 'success') {
                    location.reload();
                }
                if (response['status'] == 'failed') {
                    modal.toast('Ошибка!', 'Произошла ошибка');
                }
            },
            error:
                function (response) {
                    modal.toast('Ошибка!', 'Произошла ошибка');
                }
        });
    });
});