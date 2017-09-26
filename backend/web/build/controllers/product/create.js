define([
    'application',
    'jquery',
    'preloader',
    'i18nForm',
    'tinymceHelper',
    'uploader'
],
function (application, $, preloader, i18nForm, tinymceHelper, uploader) {
    'use strict';

    var $form = $('#product-form');

    i18nForm.initForm($form);
    tinymceHelper.init();

    var fileUploader = new uploader({
            url : "/uploads/upload?linked_table=product",
            container : $(".js-dropzone"),
        }),
        $specificationsFormWrapper = $('.js-specifications-form');

    $('[name="Product[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });

    function updateModelsList(makeId) {
        preloader.show($form);
        $.ajax({
            url : '/productmake/models?makeId=' + makeId,
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
});