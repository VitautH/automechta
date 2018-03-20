define(['jquery', 'i18n', 'helpers', 'modal'], function ($, __, helpers, modal) {
    'use strict';

    $('#apply').click(function(e){
        e.preventDefault();
        var check = confirm('Вы действительно хотите произвести действия?');
        if (check == true) {
            var action =  $('#action').val();
            var selection = new Array();
            $("input[name='selection[]']:checked").each( function () {
                selection.push( $(this).val() );
            });
            if (selection.length === 0){
                alert('Выберите минимум одно объявление!');
            }
            else {
                $.ajax({
                    url: '/account/product-change',
                    type: 'POST',
                    data: {ads: selection, action: action},
                    success: function(data) {
                        if(data['status']=='failed'){
                            modal.toast(__('app', 'Произошла ошибка'), __('app', ''));
                        }
                    },
                    error: function(data) {
                        if(data['status']=='failed'){
                            modal.toast(__('app', 'Произошла ошибка'), __('app', ''));
                        }
                    }
                });
            }
        }
    });
    $('.js-delete-row').on('click',function(e){
        e.preventDefault();

        var r = confirm('Вы действительно хотите удалить объявление?');
        if (r == true) {
            var delete_url = $(this).data('delete_url');
            $.ajax({
                url: delete_url,
                type: 'POST',
                success: function(data) {
                    $('tr[data-key=' + data['id'] + ']').fadeOut();
                }
            });
        }
    });
    $('.js-up-row').on('click',function(e){
        e.preventDefault();
        var up_url = $(this).data('up_url');
        $.ajax({
            url: up_url,
            type: 'POST',
            success: function(data) {
                if(data['status']=='success'){
                    $('<br><span class="update">Объявление поднято</span>').insertAfter('#'+data['id']);
                    $('#'+data['id']).fadeOut();
                }
                if(data['status']=='failed'){
                    $('<br><span class="error">Извините, Вы не можете поднять объявление</span>').insertAfter('#'+data['id']);
                    $('#'+data['id']).fadeOut();
                }
            }
        });
    });
});