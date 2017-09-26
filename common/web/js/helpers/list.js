/**
 * Lists helper.
 */
define(['jquery', 'preloader'], function ($, preloader) {
    'use strict';

    return function (options)
    {
        var defaultOptions = {
                $list : null
            },
            self = this;

        options = $.extend(true, {}, defaultOptions, options);

        /**
         * Initialize list
         * @param object options
         */
        this.init = function () {
            self = this;

            self.initCheckboxes();
        };

        /**
         * Check checkbox on click on row.
         */
        this.initCheckboxes = function () {
            options.$list.on('click', 'tr', function (e) {
                var $target = $(e.target),
                    $checkbox = $(this).find('input[type="checkbox"]');

                if ($target.closest('.mdl-checkbox').length === 0 && $checkbox.length) {
                    $checkbox.click();
                }
            });
        };

        this.init();
    }
});