define([
    'application',
    'jquery',
    'i18nForm',
    'tinymceHelper',
    'uploader'
], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';

    var $form = $('#mainpage-form');

    i18nForm.initForm($form);
    tinymceHelper.init();

    $(".js-dropzone").each(function () {
        var id = $(this).data('upload-id');
        if (id) {
            new uploader({
                url : "/uploads/upload?linked_table=main_page&linked_id=" + id,
                container : $(this),
                maxFiles : 1
            });
        }
    });
});