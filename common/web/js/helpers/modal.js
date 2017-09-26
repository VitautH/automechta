define([
    'jquery',
    'i18n',
    'qtip'
], function ($, __) {
    'use strict';

    var defaultOptions = {
            prerender : true,
            content : {
                text : ' ',
                title : ' ',
                footer : false
            },
            position: {
                my : 'top center', at: 'top center',
                target : $(window),
                adjust : {
                    scroll : false
                }
            },
            show : {
                ready : false,
                modal : {
                    on : true,
                    blur : true,
                    escape : true
                }
            },
            hide : false,
            style : {
                width : '30%',
                classes : 'dialogue qtip-mdl qtip-shadow'
            }
        },
        toastTypes = {
            info : 'info',
            warning : 'warning',
            error : 'error',
            success : 'success'
        };

    /**
     * @returns {jQuery|HTMLElement}
     */
    function getToastContainer() {
        var $container = $('#qtip-growl-container');
        if ($container.length === 0) {
            $container = $('<div id="qtip-growl-container"></div>');
            $('body').append($container);
        }
        return $container;
    }

    /**
     * Wrapper for qtip library.
     * @param object options
     * @see http://qtip2.com/options for further information
     * Usage example:
     * var api = modal({
     *   content : {
     *       text : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
     *       title : $('<h3>Lorem ipsum</h3>'),
     *       footer : 'Footer text'
     *   }
     * });
     * api.show();
     */
    var modal =  function (options)
    {
        var $footer;
        options = $.extend({}, defaultOptions, options);

        if (typeof options.content.text === 'string') {
            options.content.text = $('<div>' + options.content.text + '</div>');
        }

        if (options.content.footer) {
            if (typeof options.content.footer === 'string'){
                $footer = $('<div class="qtip-footer">' + options.content.footer + '</div>');
            } else {
                $footer = $('<div class="qtip-footer"></div>').append(options.content.footer);
            }

            options.content.text.append($footer);
            delete options.content.footer;
        }

        var api = $('<div />').qtip(options).qtip('api');

        return api;
    }

    /**
     * Usage example:
     * modal.alert({
     *   content : {
     *       text : 'alert message',
     *   },
     *   events: {
     *       hide: function(event, api) {
     *           console.log('hidden!');
     *       }
     *   }
     * });
     * @param options
     */
    modal.alert = function (options) {
        var api;

        options = $.extend({}, defaultOptions, options);
        options.content.footer = $('<button class="mdl-button mdl-js-button mdl-js-ripple-effect">' + __('app', 'Ok') + '</button>');

        options.content.footer.on('click', function () {
            api.destroy();
        })

        api = modal(options);
        api.show();

        return api;
    };


    /**
     * Usage example:
     * modal.confirm({
     *   content : {
     *       text : 'alert message',
     *   },
     *   events: {
     *       ok: function(event, api) {
     *           console.log('hidden!');
     *       },
     *       cancel: function(event, api) {
     *           console.log('hidden!');
     *       },
     *   }
     * });
     * @param options
     */
    modal.confirm = function (options) {
        var api;

        options = $.extend({}, defaultOptions, options);
        options.content.footer = $(
            '<div>' +
            '<button class="mdl-button mdl-js-button mdl-js-ripple-effect js-modal-button-ok">' + __('app', 'Ok') + '</button>' +
            '<button class="mdl-button mdl-js-button mdl-js-ripple-effect js-modal-button-cancel">' + __('app', 'Cancel') + '</button>' +
            '</div>'
        );

        options.content.footer.find('.js-modal-button-ok').on('click', function () {
            if (options.events.ok && typeof options.events.ok === 'function') {
                options.events.ok(api);
            }
            api.destroy();
        });

        options.content.footer.find('.js-modal-button-cancel').on('click', function () {
            if (options.events.cancel && typeof options.events.cancel === 'function') {
                options.events.cancel(api);
            }
            api.destroy();
        });

        api = modal(options);
        api.show();

        return api;
    };

    /**
     * Usage example:
     * modal.toast('Oops!', 'Alert message', 'warning');
     *
     * @param string text
     * @param string text
     * @param string type default 'info'
     */
    modal.toast = function (title, text, type) {
        var $container = getToastContainer();

        if (text === undefined) {
            throw new TypeError('Text argument should be specified');
        }

        if (type === undefined || !toastTypes[type]) {
            type = 'info';
        }

        title = title || '';

        var api = $('<div/>').qtip({
            content: {
                text: text,
                title: {
                    text: title,
                    button: true
                }
            },
            position: {
                target: [0,0],
                container: $container
            },
            show: {
                event: false,
                ready: true,
                effect: function() {
                    $(this).stop(0, 1).animate({ height: 'toggle' }, 400, 'swing');
                },
                delay: 0
            },
            hide: {
                event: false,
                effect: function(api) {
                    $(this).stop(0, 1).animate({ height: 'toggle' }, 400, 'swing');
                }
            },
            style: {
                width: 300,
                classes: 'jgrowl jgrowl-' + type,
                tip: false
            },
            events: {
                render: function(event, api) {
                    if(!api.options.show.persistent) {
                        $(this).bind('mouseover mouseout', function(e) {
                                var lifespan = 5000;

                                clearTimeout(api.timer);
                                if (e.type !== 'mouseover') {
                                    api.timer = setTimeout(function() { api.hide(e) }, lifespan);
                                }
                            })
                            .triggerHandler('mouseout');
                    }
                }
            }
        }).qtip('api');

        return api;
    };

    return modal;
});