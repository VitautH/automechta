define(['jquery', 'application'], function ($, application) {
    'use strict';

    var socket = io.connect('https://automechta.by:3000');

    socket.on('newMessageNotify', function (data) {
       showMessage(data);
    });

    function showMessage(data) {
        var message = JSON.parse(data);
        var chatBox = '#chat-'+data.dialog_id+'';
        if ($('*').is(chatBox)) {
            var html = '<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">Гость №'+data.dialog_id+'</span><span class="direct-chat-timestamp pull-right">'+data.time+'</span></div><img width="40px" height="40px" class="direct-chat-img" src="/images/noavatar.png"><div class="direct-chat-text">'+data.message+'</div></div>';
            $(chatBox).find('.direct-chat-messages').append(html);
        }
    }
});