define(['jquery', 'i18n', 'application', 'gridview', 'modal', 'preloader'], function ($, __, application, gridview, modal, preloader) {
    'use strict';

    var pjaxGridId = '#product_grid_wrapper',
        gridViewHelper = new gridview({
            pjaxGridSelector : pjaxGridId,
        });

    $('.js-create-product').on('click', function (e) {
        e.preventDefault();

        var $button = $(this),
            url = $(this).attr('href');

        preloader.show();
        $.ajax({
            url : '/product/type-select',
            success : function (response) {
                preloader.hide();
                var $form = $(response),
                    modalApi = modal({
                    content : {
                        text : response,
                        title : $('<h3>' + __('app', 'Please select product type') + '</h3>'),
                    },
                    events: {
                        show: function(event, api) {
                            componentHandler.upgradeDom();
                        }
                    }
                });
                modalApi.show();
            }
        })
    });

});