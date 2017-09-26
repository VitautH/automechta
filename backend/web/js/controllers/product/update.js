define([
    'application',
    'jquery',
    'i18nForm',
    'tinymceHelper',
    'uploader'
], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';

    var $form = $('#product-form'),
        id = $form.find('[name="id"]').val();

    i18nForm.initForm($form);
    tinymceHelper.init();

    var fileUploader = new uploader({
            url : "/uploads/upload?linked_table=product&linked_id=" + id,
            container : $(".js-dropzone")
        });

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