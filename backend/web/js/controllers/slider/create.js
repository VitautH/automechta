define(['application', 'jquery', 'i18nForm', 'tinymceHelper', 'uploader'], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';
    i18nForm.initForm($('#slider-form'));
    tinymceHelper.init();

    var fileUploader = new uploader({
        url : "/uploads/upload?linked_table=slider",
        container : $(".js-dropzone"),
        maxFiles : 1
    });
});