/**
 * Helper for build language form.
 */
define(['jquery', 'context', 'tinymce'], function ($, context) {
    'use strict';

    var localeMap = {
            'ru-RU' : 'ru',
            'en-US' : 'en'
        },
        defaultOptions =  {
            selector : '.js-wysiwyg',
            language: localeMap[context.locale] ? localeMap[context.locale] : context.locale,
            relative_urls: false,
            convert_urls : false,
            image_dimensions: false,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste"
            ],
            setup: function(editor) {
                var $textarea = $('#' + this.id);
                editor.on('focus', function(e) {
                    $textarea.closest('.mdl-textfield--floating-label').addClass('is-focused');
                });
                editor.on('blur', function(e) {
                    $textarea.closest('.mdl-textfield--floating-label').removeClass('is-focused');
                    $textarea.closest('.mdl-textfield--floating-label').toggleClass('is-dirty', editor.getContent()!=='');
                });

                if ($textarea.val() !== '') {
                    $textarea.closest('.mdl-textfield--floating-label').addClass('is-dirty');
                }
            }
        };

    return {
        init : function (options) {
            if (typeof options !== 'object') {
                options = {};
            }
            options = $.extend(true, {}, defaultOptions, options);
            var editor = tinymce.init(options);
        }
    }
});