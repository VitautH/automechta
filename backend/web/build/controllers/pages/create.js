define(['application', 'jquery', 'i18nForm', 'tinymceHelper', 'uploader'], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';
    i18nForm.initForm($('#page-form'));
    tinymceHelper.init();

    var fileUploader = new uploader({
        url : "/uploads/upload?linked_table=page",
        container : $(".js-dropzone")
    });

    $('#page-alias').on('change keyup', function(){
        $('.js-alias').text('/page/' + $(this).val());
    }).trigger('change');

});