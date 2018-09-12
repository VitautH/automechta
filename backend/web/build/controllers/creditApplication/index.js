define(['jquery', 'application', 'gridview'], function ($, application, gridview) {
    'use strict';

    var pjaxGridId = '#credit-application_grid_wrapper',
        gridViewHelper = new gridview({'pjaxGridSelector' : pjaxGridId});
    $('.button-arrive').click(function (){
var url = $(this).data('is_arrive');
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                if (response['status'] == 'success') {
                    location.reload();
                }
                if (response['status'] == 'failed') {
                    location.reload();
                }
            },
            error:
                function (response) {
                    location.reload();
            }
        });

    });

    $('.button-phone').click(function (){
        var url = $(this).data('is_phone');
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                if (response['status'] == 'success') {
                    location.reload();
                }
                if (response['status'] == 'failed') {
                    location.reload();
                }
            },
            error:
                function (response) {
                    location.reload();
                }
        });

    });
});