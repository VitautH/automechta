define(['application', 'jquery', 'i18nForm', 'tinymceHelper', 'uploader', 'select2'], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';

    i18nForm.initForm($('#specification-form'));
    tinymceHelper.init();

    var $typeSelect = $('#specification-type'),
        $valuesList = $('.js-specification-values'),
        $valuesListSelect = $('.js-select2-input');

    $typeSelect.on('change', function () {
        if ($typeSelect.val() === '1' || $typeSelect.val() === '2') {
            //list types
            $valuesList.show();
        } else {
            $valuesList.hide();
        }
    });

    $typeSelect.trigger('change');

    $valuesListSelect.select2({
        tags: true
    });

    var fileUploader = new uploader({
        url : "/uploads/upload?linked_table=specification",
        container : $(".js-dropzone"),
        maxFiles : 1
    });
});