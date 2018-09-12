define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';

    $('.open-task').click(function (e) {
        $.ajax({
            type: "GET",
            url: $(this).data("url"),
            success: function (response) {
                if (response['status'] == 'success') {
                    var taskId= response['task-id'];
                    var button = '<a data-action="/task/change-status?task='+taskId+'&status=3" class="task-action during-task btn btn-app"><i class="fa fa-save"></i> Завершить';
                    $('#task-'+taskId+'-action').empty();
                    $('#task-'+taskId+'-action').html(button);
                    modal.toast('Успех!', 'Статус задачи изменён');
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

    $('.during-task').click(function (e) {
        $.ajax({
            type: "GET",
            url: $(this).data("url"),
            success: function (response) {
                if (response['status'] == 'success') {
                    var taskId= response['task-id'];
var text = '<span>Выполнена. Ожидает проверки</span>';
    $('#task-'+taskId+'-action').empty();
                    $('#task-'+taskId+'-action').html(text);
                    modal.toast('Успех!', 'Статус задачи изменён');
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