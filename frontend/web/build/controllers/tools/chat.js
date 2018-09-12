define(['jquery', 'application', 'modal', 'moment'], function ($, application, modal, moment) {
    'use strict';

    $(document).ready(function () {
        scrollblockToBootom('.direct-chat-messages');
    });

    function scrollblockToBootom(block) {
        var heightBlock = $(block).prop('scrollHeight');
        $(block).scrollTop(heightBlock);
    }

    function playAudio() {
        var myAudio = new Audio;
        myAudio.src = "/uploads/notifyAudi/warning.mp3";
        myAudio.play();
    }

    var user_id = $.cookie("chat_guest_id");
    var socket = io.connect('https://automechta.by:3000');
    var socket_second  = io.connect('https://automechta.by:3000');
    socket.on('message-to:' + user_id, function (msg) {
        playAudio();
        var data = JSON.parse(msg);
        var html = '<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">Менеджер  </span><span class="direct-chat-timestamp pull-right">' + data.time + '</span></div><img width="40px" height="40px" class="direct-chat-img" src="' + data.avatar + '"><div class="direct-chat-text">' + data.message + '</div></div>';
        $('.direct-chat-messages').append(html);
        scrollblockToBootom('.direct-chat-messages');
    });

    socket.on('upload-file:' + user_id, function (msg) {
        playAudio();
        var time = moment().format('YYYY-MM-DD HH:mm');
        var data = JSON.parse(msg);
        var html = '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">Менеджер</span><span class="direct-chat-timestamp pull-right">' + time + '</span></div><div class="media"><img class="media-object" src="' + data.path + '"/></div></div>';
        $('.direct-chat-messages').append(html);
        scrollblockToBootom('.direct-chat-messages');
    });

    socket.on('statusDeliveryMessageToAdmin#user:' + user_id, function (msg) {
        var data = JSON.parse(msg);
        if (data.avatar_url !== undefined) {
            var avatar_url = data.avatar_url;
        }
        else {
            avatar_url = 'https://backend.automechta.by/images/noavatar.png';
        }
        if (data.user_name !== undefined) {
            var user_name = data.user_name;
        }
        else {
            user_name = 'Гость №' + data.dialog_id;
        }
        var html = '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-right">' + user_name + '</span><span class="direct-chat-timestamp pull-right">' + data.time + '</span></div><img width="40px" height="40px" class="direct-chat-img" src="' + avatar_url + '"><div class="direct-chat-text">' + data.message + '</div></div>';
        $('.direct-chat-messages').append(html);
        $('textarea[name="message"]').val('');
        scrollblockToBootom('.direct-chat-messages');
    });


    $('input[type=file]').on('change', function () {
        if (window.File && window.FileReader && window.FormData) {
            var files = this.files;

            if (typeof files == 'undefined') return;

            var file = new FormData();

            $.each(files, function (key, value) {
                file.append(key, value);
            });
            file.append('file', 1);

            var site_user_id = $('input[name="site_user_id"]').val();

            if (site_user_id.length > 0) {
                file.append(site_user_id, site_user_id);
            }

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
                        var html = '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">Гость</span><span class="direct-chat-timestamp pull-right">' + time + '</span></div><div class="media"><img class="media-object" src="' + data.path + '"/></div></div>';
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
            alert('Устройство не поддерживает загрузку файлов в асинхронном режиме!');
        }
    });
    $('#whois').submit(function (e) {
        e.preventDefault();
        if ((typeof ($('input[name="user_name"]').val()) !== undefined) && (typeof ($('input[name="message"]').val())!==undefined)) {

            var user_name = $('input[name="user_name"]').val();
            var contact = $('input[name="contact"]').val();
            var data = {};
            data.user_name = user_name;
            data.contact = contact;
            data.user_id = user_id;
            socket.emit('sendUserContactData', data);
            $('input[name="user_name"]').remove();
            $('input[name="contact"]').remove();
            $('#whois').find('input[type="submit"]').remove();
            // socket.on('statusSendContactInformation#user:' + user_id, function (msg) {
            //     if (msg === true) {
            //         $('input[name="user_name"]').remove();
            //         $('input[name="contact"]').remove();
            //     }
            //
            // });

        }
    });

    $('#live_chat').submit(function (e) {
        e.preventDefault();


        var message = $('textarea[name="message"]').val();
        var site_user_id = $('input[name="site_user_id"]').val();
        var avatarUrl = $('input[name="avatarUrl"]').val();
        var username = $('input[name="username"]').val();
        var data_msg = {};
        data_msg.message = message;
        data_msg.user_id = user_id;
        if (site_user_id.length > 0) {
            data_msg.site_user_id = site_user_id;
        }
        if (avatarUrl.length > 0) {
            data_msg.avatar_url = avatarUrl;
        }
        if (username.length > 0) {
            data_msg.user_name = username;
        }

        socket.emit('message', data_msg);

    });
});
