define(['jquery', 'i18n', 'application', 'gridview', 'modal', 'preloader', 'maskedinput'], function ($, __, application, gridview, modal, preloader) {
    'use strict';

    var pjaxGridId = '#product_grid_wrapper',
        gridViewHelper = new gridview({
            pjaxGridSelector : pjaxGridId,
        });

    if ($('#user-phone').length) {
        $('#user-phone').mask("+375 (99) 999-99-99");
    }

    if ($('#user-phone_2').length) {
        $('#user-phone_2').mask("+375 (99) 999-99-99");
    }

    $(pjaxGridId).on('click', '.js-up-row', function () {
        var $upButton = $(this);
        var url = $(this).data('up_url');
        if (url) {
            $.ajax({
                url : url,
                type : 'POST',
                success : function (response) {
                    if (response.status === 'success') {
                        modal.toast(__('app', 'Up'), __('app', 'Your ad raised in the list'), 'success');
                    } else {
                        modal.toast(__('app', 'Up'), __('app', 'Error'), 'error');
                    }
                    $upButton.remove();
                }
            });
        }
    });
    $(pjaxGridId).on('click', '.js-up-disabled', function () {
        var $link = $(this);
        var text = $link.attr('title');
        modal.toast(__('app', 'Up'), text, 'error');
    });
});