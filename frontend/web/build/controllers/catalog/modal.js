define(['jquery'], function ($) {
    'use strict';
    $('#seller-phone-show').click(function () {
        $('.popup-block').show();
        $('.seller-phone-block').show();
    });
    $('.cancel').click(function () {
        $('.popup-block').hide();
        $('.seller-phone-block').hide();
    });
    $('#credit-phone-show').click(function () {
        $('.popup-block').show();
        $('.credit-phone-block').show();
    });
    $('.cancel').click(function () {
        $('.popup-block').hide();
        $('.credit-phone-block').hide();
    });
    $('#complaint_to_mobile').click(function () {
        $('#complaint_block_mobile').toggle();
    });
});