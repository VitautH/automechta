define(['jquery', 'application', 'preloader', 'uploader', 'maskedinput'], function ($, application, preloader, uploader) {
    'use strict';
    initUploads()

    function initUploads() {

        var id = $('#user-id').val();
        var fileUploader = new uploader({
            maxFiles: 1,
            url: '/uploads/upload?linked_table=user&linked_id=' + id,
            container: $('.js-dropzone')
        });

    }
    if ($('#user-phone').length) {
        $('#user-phone').mask("+375 (99) 999-99-99");
    }

$('#datepicker').datepicker();

});