define([
    'application',
    'jquery',
    'i18nForm',
    'tinymceHelper',
    'uploader',
    'select2'
], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';

    var $form = $('#specification-form'),
        id = $form.find('[name="id"]').val(),
        $typeSelect = $('#specification-type'),
        $valuesList = $('.js-specification-values'),
        id = $form.find('[name="id"]').val(),
        $valuesListSelect = $('.js-select2-input');

    i18nForm.initForm($('#specification-form'));

    $form.on('click', '.mdl-tabs__tab', function () {
        $valuesListSelect.select2({
            tags: true
        });
    });

    $typeSelect.on('change', function () {
        if ($typeSelect.val() === '1' || $typeSelect.val() === '2') {
            //list types
            $valuesList.show();
            $valuesListSelect.select2({
                tags: true
            });
        } else {
            $valuesList.hide();
        }
    });

    $typeSelect.trigger('change');

    var fileUploader = new uploader({
        url : "/uploads/upload?linked_table=specification&linked_id=" + id,
        container : $(".js-dropzone"),
        maxFiles : 1
    });
});