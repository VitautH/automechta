define([
    'application',
    'jquery',
    'i18nForm',
    'tinymceHelper',
    'uploader'
], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';

    var $form = $('#appdata-form');

    i18nForm.initForm($form);
    tinymceHelper.init();

    $(".js-dropzone").each(function () {
        var id = $(this).data('upload-id');
        if (id) {
            new uploader({
                url : "/uploads/upload?linked_table=app_data&linked_id=" + id,
                container : $(this),
                maxFiles : 1
            });
        }
    });
});