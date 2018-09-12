define(['jquery', 'application', 'modal', 'moment'], function ($, application, modal, moment) {
    'use strict';

    $(window).load(function () {
        scrollblockToBootom('.direct-chat-messages');
    })


    function scrollblockToBootom(block) {
        var heightBlock = $(block).prop('scrollHeight');
        $(block).scrollTop(heightBlock);
    }

    function playAudio() {
        var myAudio = new Audio;
        myAudio.src = "/uploads/notifyAudi/warning.mp3";
        myAudio.play();
    }

    var socket = io.connect('https://automechta.by:3000');

    socket.on('notification', function (data) {

        var message = JSON.parse(data);
        var nameEvent = message.event;
        notificationEvent(nameEvent);
        countNotification();
        modal.toast('Уведомление!', message.message);
        playAudio();

    });

    function notificationEvent(nameEvent) {
        switch (nameEvent) {
            case 'complaint':
                var html = '<li><a href="/complaint"><i class="fa fa-warning text-red"></i> 1 жалоба </a> </li>';
                $(".menu").innerHTML(html);
                break;
            case 'callback':
                var html = '<li><a href="/complaint"><i class="fa fa-phone text-green"></i> 1 обратный звонок </a> </li>';
                $(".menu").innerHTML(html);
                break;
        }
    }

    function countNotification() {
        var countNotification = 0;
        if ($('*').is('span.label-warning')) {
            countNotification = parseInt($('span.label-warning').text());
            var html = '<span class="label label-warning">' + (countNotification + 1) + '</span>';
            $('span.label-warning').remove();
            $(".notifications-count").after(html);
        }
        else {

            var html = '<span class="label label-warning">1</span>';
            $(".notifications-count").after(html);
        }
    }


    /*
    Live Chat Notify
     */
    function countChatMainPage() {
        if ($('*').is('span.chat-count')) {
            var countChat = parseInt($('span.chat-count').text());
            $("span.chat-count").text(countChat + 1);
        }
    }

    function showMessage(message) {
        var chatBox = '#chat-' + message.dialog_id;

        if ($('*').is(chatBox)) {
            if (message.avatar_url !== undefined){
                var avatar_url = message.avatar_url;
            }
            else {
                avatar_url = 'https://backend.automechta.by/images/noavatar.png';
            }
            if (message.user_name !== undefined){
                var user_name = message.user_name;
            }
            else {
                user_name = 'Гость №' + message.dialog_id;
            }
            var html = '<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">' + user_name + '</span><span class="direct-chat-timestamp pull-right">' + message.time + '</span></div><img width="40px" height="40px" class="direct-chat-img" src="'+avatar_url+'"><div class="direct-chat-text">' + message.message + '</div></div>';
            $('.direct-chat-messages').append(html);
            scrollblockToBootom('.direct-chat-messages');
        }
    }

    function showOwnMessage(message) {
        var chatBox = '#chat-' + message.dialog_id;
        if ($('*').is(chatBox)) {
            var html = '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">Менеджер</span><span class="direct-chat-timestamp pull-right">' + message.time + '</span></div><img width="40px" height="40px" class="direct-chat-img" src="' + message.avatar + '"><div class="direct-chat-text">' + message.message + '</div></div>';
            $('.direct-chat-messages').append(html);
            scrollblockToBootom('.direct-chat-messages');
        }
    }

    function showMessageWithFile(message) {
        var chatBox = '#chat-' + message.dialog_id;
        if ($('*').is(chatBox)) {
            var time = moment().format('YYYY-MM-DD HH:mm');
            var html = '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">Гость</span><span class="direct-chat-timestamp pull-right">' + time + '</span></div><div class="media"><a href="https://automechta.by' + message.path + '" target="_blank"><img class="media-object" src="https://automechta.by' + message.path + '"/></a></div></div>';
            $('.direct-chat-messages').append(html);
            scrollblockToBootom('.direct-chat-messages');
        }
    }

    socket.on('newMessageNotify', function (data) {
        var msg = JSON.parse(data);
        showMessage(msg);
        countChatMainPage();
        playAudio();

        if (msg.user_name !== undefined){
            var user_name = msg.user_name;
        }
        else {
            user_name = 'Гость №' + msg.dialog_id;
        }
        modal.toast('Сообщение от ' + user_name, msg.message + ' <a href="/chat/index">Просмотреть</a>');
    });

    socket.on('chatToManagerLoadImage', function (data) {
        var msg = JSON.parse(data);
        showMessageWithFile(msg);
        countChatMainPage();
        playAudio();
        modal.toast('Уведомление от Гость №' + msg.dialog_id, 'Загружен файл <br><a href="/chat/index">Просмотреть</a>');
    });

    socket.on('statusDeliveryMessageToClient', function (data) {
        var msg = JSON.parse(data);
        $('input[name="message"]').val('');
        showOwnMessage(msg);
    });
    $('input[type=file]').on('change', function () {
        loadFile(this);
    });
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

    /*
    Подгрузка чатов, отправка чата и изображений
     */
    $('.load_dialog').click(function (e) {
        e.preventDefault();
        var dialogId = $(this).data('dialog');
        $.ajax({
            async: false,
            url: '/chat/load-dialog?id=' + dialogId,
            type: 'GET',
            success: function (data) {
                $('.direct-chat ').remove();

                $('.dialog_box').html(data);
                scrollblockToBootom('.direct-chat-messages');

                $('input[type=file]').on('change', function () {
                    loadFile(this);
                });
                $('.chat-form').on('submit', function (e) {
                    e.preventDefault();
                    var message = $(this).find('textarea[name="message"]').val();
                    var dialogId = $(this).data('chat');
                    var clientId = $(this).data('client_id');
                    var userId = $(this).data('user_id');
                    var avatarUrl = $(this).data('avatar');
                    var data = {
                        message: message,
                        dialog_id: dialogId,
                        client_id: clientId,
                        user_id: userId,
                        avatar: avatarUrl
                    };
                    if (message.length > 0) {
                        socket.emit('responseMessageSend', data);
                    }
                    else {
                        modal.toast('Ошибка', 'Введите сообщение');
                    }
                    e.preventDefault();
                });
            },
            error: function (data) {
                if (data['status'] == 'failed') {
                    modal.toast(__('app', 'РџСЂРѕРёР·РѕС€Р»Р° РѕС€РёР±РєР°!'), __('app', ''));
                }
            }
        });

    });

    function loadFile(formData) {
        if (window.File && window.FileReader && window.FormData) {
            var files = formData.files;
            var dialogId = $('.chat-form').data('chat');
            var clientId = $('.chat-form').data('client_id');
            var userId = $('.chat-form').data('user_id');

            if (typeof files == 'undefined') return;

            var file = new FormData();

            $.each(files, function (key, value) {
                file.append(key, value);
            });
            file.append('file', 1);

            var data = {dialog_id: dialogId, client_id: clientId, user_id: userId};
            $.each(data, function (key, value) {
                file.append(key, value);
            });
            $.ajax({
                url: '/chat/upload-file',
                type: 'POST',
                data: file,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    var html = '<span class="file-uploading">Идёт загрузка файлов...</span>';
                    $('.advance-input-group').append(html);
                },
                complete: function () {
                    $('.file-uploading').remove();
                },
                success: function (response) {
                    var data = JSON.parse(response);

                    if (data.status == 'success') {
                        var time = moment().format('YYYY-MM-DD HH:mm');
                        var html = '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">Менеджер</span><span class="direct-chat-timestamp pull-right">' + time + '</span></div><div class="media"><a href="https://automechta.by/' + data.path + '" target="_blank"><img class="media-object" src="https://automechta.by/' + data.path + '"/></a></div></div>';
                        $('.direct-chat-messages').append(html);
                        scrollblockToBootom('.direct-chat-messages');
                    }
                    if (data.status == 'failed') {
                        modal.toast('Ошибка!', 'Ошибка загрузки файла');
                    }
                    $('.file-uploading').remove();
                },
                error:
                    function (response) {
                        $('.file-uploading').remove();
                        modal.toast('Ошибка!', 'Ошибка загрузки файла');
                    }


            });
        }
        else {
            alert('Ошибка! Устройство не поддерживает загрузку файлов в асинхронном режиме!');
        }
    }
});
