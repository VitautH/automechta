define(['jquery', 'application', 'preloader'], function ($, application, preloader) {
    'use strict';
    $('.js-select-maker').on('click', function (e) {
        e.preventDefault();
        var makerId = $(this).data('make-id');

        preloader.show($('.js-productlist'));

        $('.js-productlist').find('li.active').removeClass('active');
        $(this).closest('li').addClass('active');
        $.ajax({
            url : '/site/productlist?make=' + makerId,
            success : function (response) {
                var $result = $('<div>' + response + '</div>');
                if ($result.find('.js-productlist-first').length) {
                    $('.js-productlist-first').replaceWith($result.find('.js-productlist-first'));
                    preloader.hide($('.js-productlist'));
                }
                if ($result.find('.js-productlist-second').length) {
                    $('.js-productlist-second').replaceWith($result.find('.js-productlist-second'));
                    preloader.hide($('.js-productlist'));
                }
            },
            error : function () {

            }
        });
    });
});