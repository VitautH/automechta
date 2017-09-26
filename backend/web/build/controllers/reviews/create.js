define(['application', 'jquery', 'i18nForm', 'tinymceHelper', 'uploader'], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';
    i18nForm.initForm($('#reviews-form'));
    tinymceHelper.init();

    var fileUploader = new uploader({
        url : "/uploads/upload?linked_table=reviews",
        container : $(".js-dropzone"),
        maxFiles : 1
    });
});