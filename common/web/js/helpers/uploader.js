/**
 * Uploader
 */
define(['jquery', 'i18n', 'dropzone', 'helpers', 'modal'], function ($, __, dropzone, helpers, modal) {
    'use strict';

    dropzone.autoDiscover = false;

    /**
     * @param id
     */
    function removeFile(id) {
        $.ajax({
            url : '/uploads/remove?id=' + id,
            type : 'POST',
            success : function () {
                modal.toast(__('app', 'Deleted'), __('app', 'File deleted'));
            }
        });
    }

    /**
     * @param id
     */
    function rotateFile(id) {
        $.ajax({
            url : '/uploads/rotate?id=' + id,
            type : 'POST',
            success : function (e) {
               var $image = $('.dz-preview :input[value="'+id+'"]').parent().find('.dz-image img');

               var date = new Date();
               var time = date.getTime();

               $image.attr('src',e.url+'?'+time);
            }
        });
    }

    /**
     * @param options
     * @param options.container jOuery uploader container
     */
    return function (options) {
        var self = this;

        this.init = function () {
            var defaultOptions = {
                    modelName : 'Uploads',
                    dictDefaultMessage : __('app', 'Drop files here to upload'),
                    addRemoveLinks : true,
                    maxFilesize : 10,
                    dictRemoveFile : 'close',
                    previewTemplate: "<div class=\"dz-preview dz-file-preview dz-custom-style\">" +
                        "<div class=\"dz-image\"><img data-dz-thumbnail /></div>" +
                        "<div class=\"dz-details\">" +
                            "<div class=\"dz-size\">" +
                                "<span data-dz-size></span>" +
                            "</div>" +
                            "<div class=\"dz-filename\">" +
                                "<span data-dz-name></span>" +
                            "</div>" +
                        "</div>" +
                        "<div class=\"dz-progress\">" +
                            "<span class=\"dz-upload\" data-dz-uploadprogress></span>" +
                        "</div>" +
                        "<div class=\"dz-error-message\">" +
                            "<span class=\"dz-error-message-text\" data-dz-errormessage></span>" +
                        "</div>" +
                        "<div class=\"dz-success-mark\">" +
                            "<a class=\"mdl-button mdl-js-button mdl-button--fab mdl-button--success\"><i class=\"material-icons\">done</i></a>" +
                        "</div>" +
                        '<a class="dz-title-image" title="Фотография, которая будет отображаться в каталоге">Главная</a>' +
                        "<a class=\"dz-copy-to-clipboard\">content_copy</a>" +
                        '<a class="dz-rotate" href="javascript:undefined;" data-dz-rotate="">rotate</a>' +
                        '<input class="dz-file-id" type="hidden">' +
                    "</div>",
                    uploadedFileTemplate: '<div class="dz-preview dz-custom-style dz-processing dz-image-preview dz-success dz-complete">' +
                        '<div class="dz-image">' +
                            '<img data-dz-thumbnail="">' +
                        '</div>' +
                        '<div class="dz-details">' +
                            '<div class="dz-filename">' +
                                '<span data-dz-name="">abstract-q-c-800-600-3.jpg</span>' +
                            '</div>' +
                        '</div>' +
                        '<a class="dz-title-image" title="Фотография, которая будет отображаться в каталоге">Главная</a>' +
                        '<a class="dz-copy-to-clipboard">content_copy</a>' +
                        '<input class="dz-file-id" type="hidden">' +
                        '<a class="dz-rotate" href="javascript:undefined;" data-dz-rotate="">rotate</a>' +
                        '<a class="dz-remove" href="javascript:undefined;" data-dz-remove="">close</a>' +
                    '</div>'
                },
                dz,
                self = this;

            options = $.extend(true, {}, defaultOptions, options);

            if (typeof options.container === 'undefined') {
                throw new TypeError('option container is required');
            }

            if (typeof options.url === 'undefined') {
                throw new TypeError('option url is required');
            }

            options.container.addClass('dropzone');
            options.container.dropzone(options);
            this.dz = dz = options.container[0].dropzone;
            this.bindEvents();
            this.addUploadedFiles();

            dz.addUploadedFile = function (file) {
                addUploadedFile.call(dz, options, file);
            }
        };

        /**
         *
         */
        this.bindEvents = function () {
            this.dz.on('error', function (file, response) {
                var $previewElement = $(file.previewElement);
                if (response.message) {
                    $previewElement.find('.dz-error-message-text').html(response.message);
                }
            });

            this.dz.on('success', function (file, response) {
                var $previewElement = $(file.previewElement);

                $previewElement.find('.dz-copy-to-clipboard').on('click', function () {
                    helpers.copyTextToClipboard(response.path);
                    modal.toast(__('app', 'Copied'), __('app', 'Url copied to clipboard'));
                });

                $previewElement.find('.dz-file-id').attr('name', options.modelName+'[]').val(response.id);

                $previewElement.find('.dz-remove').on('click', function () {
                    removeFile(response.id);
                    self.checkState();
                });

                $previewElement.find('.dz-rotate').on('click', function () {
                    rotateFile(response.id);
                    self.checkState();
                });

                $previewElement.find('.dz-title-image').on('click', function () {
                    self.setTitle($previewElement);
                });

                self.checkState();
            });
        };

        /**
         * Add previously uploaded files
         */
        this.addUploadedFiles = function () {
            var filesData = options.container.data('uploaded-files'),
                self = this;
            $.each(filesData, function (key, file) {
                self.addUploadedFile(file);
            });
        };

        /**
         * Add previously uploaded file
         * @param object file
         */
        this.addUploadedFile = function(file) {
            var $previewElement = $(options.uploadedFileTemplate);

            $previewElement.find('.dz-copy-to-clipboard').on('click', function () {
                helpers.copyTextToClipboard(file.path);
                modal.toast(__('app', 'Copied'), __('app', 'Url copied to clipboard'));
            });

            var uploadedFile = {
                accepted: true,
                _removeLink: $(this),
                name: file.name,
                status: 'success',
                previewElement: $previewElement,
                previewTemplate: $previewElement
            };

            self.dz.files.push(uploadedFile);

            $previewElement.find('.dz-file-id').attr('name', options.modelName+'[]').val(file.id);

            $previewElement.find('.dz-remove').on('click', function () {
                removeFile(file.id);
                $previewElement.remove();
                self.dz.files.splice(self.dz.files.indexOf(uploadedFile), 1);
                self.checkState();
            });

            $previewElement.find('.dz-rotate').on('click', function () {
                rotateFile(file.id);
                self.dz.files.splice(self.dz.files.indexOf(uploadedFile), 1);
                self.checkState();
            });


            $previewElement.find('.dz-image img').attr('src', file.path);

            $previewElement.find('.dz-title-image').on('click', function () {
                self.setTitle($previewElement);
            });

            $(this.dz.previewsContainer).append($previewElement);

            if (file.type == 1) {
                this.setTitle($previewElement);
            }

            self.checkState();
        };

        this.setTitle = function ($previewElement) {
            var $container = $(this.dz.previewsContainer);
            $container.find('.dz-file-id').attr('name', options.modelName+'[]');
            $container.find('.dz-preview').removeClass('dz-title');

            $previewElement.addClass('dz-title');
            $previewElement.find('.dz-file-id').attr('name', options.modelName+'[title]');
        }

        this.checkState = function () {
            if ((self.dz.options.maxFiles != null) && self.dz.getAcceptedFiles().length >= self.dz.options.maxFiles) {
                self.dz.disable()
            } else {
                self.dz.enable()
            }
        };

        this.init();
    };
});