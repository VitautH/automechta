define(['jquery', 'application', 'gridview', 'modal', 'preloader'], function ($, application, gridview, modal, preloader) {
    'use strict';
    var month = new Array();
    month[0] = "Янв";
    month[1] = "Февр";
    month[2] = "Март";
    month[3] = "Апрл";
    month[4] = "Май";
    month[5] = "Июнь";
    month[6] = "Июль";
    month[7] = "Авг";
    month[8] = "Сент";
    month[9] = "Окт";
    month[10] = "Нов";
    month[11] = "Дек";

    $('.send-message').click(function (e) {
        var messageBox = $('#' + $(this).data('for'));
        var form = $(messageBox).find('form.form-message');
        var message = $(form).find('input[name="message"]').val();
        var to = $(form).find('input[name="to"]').val();
        var currentUserName = $('input.current-user-name').val();
        if (message.length > 0) {
            $.ajax({
                url: '/message/send',
                type: 'POST',
                data: {message: message, to: to},
                success: function (data) {
                    if (data['status'] == 'success') {
                        var now = new Date(Date.now());
                        var time = now.getDate() + ' ' +  month[now.getMonth()] + ' '+ now.getHours() + ':' + now.getMinutes();
                   var html = '<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">'+currentUserName+'</span><span class="direct-chat-timestamp pull-right">'+time+'</span></div><div class="direct-chat-text">'+message+'</div></div>';
                        $(messageBox).find('.direct-chat-messages').append(html);
                            }
                    if (data['status'] == 'failed') {
                        modal.toast(__('app', 'Произошла ошибка!'), __('app', ''));
                    }
                },
                error: function (data) {
                    if (data['status'] == 'failed') {
                        modal.toast(__('app', 'Произошла ошибка!'), __('app', ''));
                    }
                }
            });

        }
        e.preventDefault();
    });

});
