define(['jquery', 'i18n', 'helpers', 'modal'], function ($, __, helpers, modal) {
    'use strict';

    $('.delete').on('click',function(e){
        e.preventDefault();

        var r = confirm('Вы действительно хотите удалить изображение?');
        if (r == true) {
            var delete_url = $(this).data('delete_url');
            $.ajax({
                url: delete_url,
                type: 'POST',
                success: function(data) {
                    if ( data['status'] == 'success') {
                        $('#imagebox-' + data['id']).fadeOut();
                    }
                    else {
                        alert('Произошла ошибка!');
                    }
                }
            });
        }
    });

});