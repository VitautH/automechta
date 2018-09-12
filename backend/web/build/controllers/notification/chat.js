define(['jquery', 'application', 'modal'], function ($, application, modal) {
    'use strict';


    var socket = io.connect('https://automechta.by:3000');
    $('.chat-form').submit(function (e) {
        e.preventDefault();
        var message = $(this).find('input[name="message"]').val();
        var dialogId = $(this).data('chat');
        var clientId = $(this).data('client_id');
        var userId = $(this).data('user_id');
        var avatarUrl = $(this).data('avatar');
        var data = {message: message, dialog_id: dialogId, client_id: clientId, user_id: userId, avatar: avatarUrl};
        if (message.length > 0) {
            socket.emit('responseMessageSend', data);
        }
        else {
            modal.toast('Ошибка', 'Введите сообщение');
        }
        e.preventDefault();
    });
});