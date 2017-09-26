define(['jquery', 'application', 'preloader', 'uploader', 'maskedinput'], function ($, application, preloader, uploader) {
    'use strict';
    var $form = $('#create_product_form'),
        id = $('[name="Product[id]"]').val();

    $('[name="Product[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });

    if ($('[name="Product[model]"]').val() === null) {
        $('[name="Product[make]"]').trigger('change');
    }

    function updateModelsList(makeId) {
        if (makeId) {
            preloader.show($form);
            $.ajax({
                url : '/api/productmake/models?makeId=' + makeId,
                success : function (response) {
                    $('[name="Product[model]"]').empty();
                    $.each(response, function (key, val) {
                        var $option = $('<option value="' + key + '">'+ key +'</option>');
                        $('[name="Product[model]"]').append($option);
                    });
                    preloader.hide($form);
                }
            });
        }
    }

    initUploads()

    function initUploads() {
        if ($(".js-dropzone").length === 1) {
            var fileUploader = new uploader({
                url : "/uploads/upload?linked_table=product&linked_id=" + id,
                container : $(".js-dropzone")
            });
        }
    }

    if ($('#user-phone').length) {
        $('#user-phone').mask("+375 (99) 999-99-99");
    }

    if ($('#user-phone_2').length) {
        $('#user-phone_2').mask("+375 (99) 999-99-99");
    }
});