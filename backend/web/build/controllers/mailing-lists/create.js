define(['application', 'jquery', 'i18nForm', 'tinymceHelper', 'uploader'], function (application, $, i18nForm, tinymceHelper, uploader) {
    'use strict';

    i18nForm.initForm($('#mailinglist-form'));
    tinymceHelper.init();

});