define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';
    $('#datepicker').datepicker();

    $('#report-search-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $('#report-search-form').attr("action"),
            data: $('#report-search-form').serialize(),
            success: function (data) {
                if (data == false){
                    modal.toast('Ошибка!', 'Нет отчётов на эту дату');
                }
                else {
                    $.each(data, function () {
                        $.each(this, function (i, user) {
                            var header = '<div class="col-md-6"><div class="box"><div class="box-header with-border"><h3 class="box-title">' + user.employees + '</h3><br>Отчёт за <b>' + user.report_date + '</b></div><div class="box-body"><table class="table table-bordered"><tbody><tr><th style="width: 10px">#</th><th>Задача</th><th>Значение</th></tr>';
                            var body = '';
                            var n = 1;
                            $.each(user.tasks, function (i, tasks) {
                                if (tasks.report_field !== undefined) {
                                    body += '<tr><td>' + n + '.</td><td>' + tasks.report_field + '</td><td>' + tasks.report + '</td></tr>';
                                    n++;
                                }
                            });

                            $.each(user.tasks.additional_task, function (i, task) {
                                if (task.report_field !== undefined) {
                                    body += '<tr><td><a href="/task/own-task?id=' + task.id +'">Перейти к задаче</a></td><td>' + task.report_field + '</td><td>' + task.report + '</td></tr>';
                                }
                            });
                            var footer = '</tbody></table></div></div></div>';

                            var result = header + body + footer;
                            $('#report').append(result);
                        });
                    });
                }
            },
            error: function (response) {
                modal.toast('Ошибка!', 'Произошла ошибка');
            }
        });
    });

});
