define([
    'application',
    'jquery',
    'i18nForm',
    'tinymceHelper',
    'uploader'
], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';

    var $form = $('#page-form'),
        id = $form.find('[name="id"]').val();

    i18nForm.initForm($form);
    tinymceHelper.init();

    var fileUploader = new uploader({
        url : "/uploads/upload?linked_table=page&linked_id=" + id,
        container : $(".js-dropzone")
    });

    $('#page-alias').on('change keyup', function(){
        $('.js-alias').text('/' + $(this).val());
    }).trigger('change');

});