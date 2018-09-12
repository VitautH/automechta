define(['jquery'], function ($) {
    'use strict';
    $('.modal-login').hide();
    $('.popup-block').hide();
        $('.show-modal-login').click(function () {
            $('.modal-login').show();
            $('.popup-block').show();
        });

        $('.modal-login .modal-close').click(function () {
            $('.modal-login').hide();
            $('.popup-block').hide();
        });
});