define(['application', 'jquery'], function (application, $) {
    'use strict';

    $('.send-mailing').on('click',function(e){
        e.preventDefault();

        var r = confirm('Вы хотите отправить рассылку?');
        if (r == true) {
            var send_url = $(this).data('send_url');
            $.ajax({
                beforeSend: function() {
                    $('#loader').show();
                },
                complete: function(){
                    $('#loader').hide();
                },
                url: send_url,
                type: 'GET',
                success: function(data) {
                    if(data == true){
                        alert('Отправка рассылки завершена!');
                    }
                    else {
                        alert('Произошла ошибка!');
                    }
                }
            });
        }
    });
});