define(['jquery', 'i18n', 'helpers', 'modal'], function ($, __, helpers, modal) {
    'use strict';


        function addBookmarks(action) {
            var productId = $(action).data('product');
            $.ajax({
                url: '/bookmarks/add?id=' + productId,
                type: 'GET',
                success: function (data) {
                    modal.toast(__('app', 'Добавлено в  закладки'), __('app', ''));
                    $('a[data-product="' + data['id'] + '"]').attr('title', 'Удалить из закладок').attr('id', 'delete-bookmarks').removeClass('inactive').addClass('active');
                }
            });
        }




function deleteBookmarks(action) {
    var productId = $(action).data('product');
    $.ajax({
        url: '/bookmarks/delete?id=' + productId,
        type: 'GET',
        success: function (data) {
            modal.toast(__('app', 'Удалено из  закладок'), __('app', ''));
            $('[data-product="' + data['id'] + '"]').attr('title', 'Добавить в закладки').attr('id', 'add-bookmarks').removeClass('active').addClass('inactive');
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
