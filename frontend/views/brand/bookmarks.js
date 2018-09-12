define(['jquery', 'i18n', 'helpers', 'modal'], function ($, __, helpers, modal) {
    'use strict';


        function addBookmarks(action) {
            var productId = $(action).data('product');
            $.ajax({
                url: '/bookmarks/add?id=' + productId,
                type: 'GET',
                success: function (data) {
                    $('a[data-product="' + data['id'] + '"]').attr('title', 'Удалить из закладок').attr('id', 'delete-bookmarks').removeClass('add-to-favorite').addClass('in-favorite');
                    modal.toast(__('app', 'Добавлено в  закладки'), __('app', ''));
                }
            });
        }




function deleteBookmarks(action) {
    var productId = $(action).data('product');
    $.ajax({
        url: '/bookmarks/delete?id=' + productId,
        type: 'GET',
        success: function (data) {
            $('[data-product="' + data['id'] + '"]').attr('title', 'Добавить в закладки').attr('id', 'add-bookmarks').removeClass('in-favorite').addClass('add-to-favorite');
            modal.toast(__('app', 'Удалено из  закладок'), __('app', ''));
        }
    });

}

$('a.bookmarks').on('click', function (e) {
    e.preventDefault();
    var action = $(this).attr('id');

    switch (action) {
        case 'delete-bookmarks':
            deleteBookmarks(this);
            break;

        case 'add-bookmarks':
            addBookmarks(this);
            break;

    }
});


});
