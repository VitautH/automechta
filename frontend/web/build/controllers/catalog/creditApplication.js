define(['jquery', 'application', 'maskedinput'], function ($, applicatione) {
    'use strict';

    if ($('#creditapplication-phone').length) {
        $('#creditapplication-phone').mask("+375 (99) 999-99-99");
    }

    $('.field').change(function () {
        if ($(this).val() != '') {
            $(this).removeClass('empty_field');
            $(this).css({
                "border-color": "green",
                "border-width": "1px",
                "border-style": "solid"
            });
        }
        else {
            $(this).addClass('empty_field');
            $(this).css({
                "border-color": "#df4142",
                "border-width": "1px",
                "border-style": "solid"
            });
        }

    });


});
