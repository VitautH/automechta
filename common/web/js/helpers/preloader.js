define([
    'jquery',
    'qtip'
], function ($) {
    'use strict';

    return {
        /**
         * Function shows waiting cover
         * @param {object} $container element to append waiting cover;
         * @param {Function} callback Function;
         * @return void
         */
        show : function ($container, callback) {
            if (!$container || (!!$container.length && $container.length === 0)) {
                $container = $('body');
            }
            this.hide($container);
            var $elem = $('<div class="waiting js-waiting"><div class="mdl-spinner mdl-js-spinner mdl-spinner--single-color is-active"></div></div>');
            $container.prepend($elem);
            $container.addClass('has-preloader');
            if (typeof callback === 'function') {
                callback($elem);
            }
            if (componentHandler) {
                componentHandler.upgradeDom();
            }
        },

        /**
         * Function hides waiting cover
         * @param {object} $container element to remove waiting cover;
         * @param {Function} callback Function;
         * @return void
         */
        hide : function ($container, callback) {
            if (!$container || (!!$container.length && $container.length === 0)) {
                $container = $('body');
            }
            $container.removeClass('has-preloader');
            $container.children(".js-waiting").remove();
            if (typeof callback === 'function') {
                callback();
            }
        },
    }
});
