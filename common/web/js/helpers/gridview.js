/**
 * Grid view helper.
 */
define([
    'jquery', 'i18n', 'preloader', 'modal', 'daterangepicker'
], function ($, __, preloader, modal) {
    'use strict';

    return function (options)
    {
        var defaultOptions = {
                pjaxGridSelector : null,
                deleteButtonSelector : '.js-delete-row',
                deleteConfirmationText: __('app', 'Are you sure you want to delete this item?'),
                sortable : false
            },
            self = this,
            $pjaxGrid;

        if (options.pjaxGridSelector) {
            $pjaxGrid = $(options.pjaxGridSelector);
        }

        options = $.extend(true, {}, defaultOptions, options);

        /**
         * Initialize grid
         * @param object options
         */
        this.initGrid = function () {
            var $container = getContainer();
            self = this;

            if ($pjaxGrid && $pjaxGrid.length) {
                $pjaxGrid.on('pjax:success', function () {
                    if (typeof componentHandler !== 'undefined') {
                        componentHandler.upgradeDom();
                    }
                    self.initDeleteButton();
                    self.initDateFilters();
                    if (options.sortable) {
                        self.initSorting();
                    }
                });

                $pjaxGrid.on('pjax:start', function () {
                    preloader.show($container);
                });
                $pjaxGrid.on('pjax:end', function () {
                    preloader.hide($container);
                });
            }
            self.initDeleteButton();
            self.initDateFilters();
            if (options.sortable) {
                self.initSorting();
            }
        };

        this.moveNode = function ($node) {
            if (options.moveNodeUrl) {
                var $container = getContainer();

                preloader.show($container);

                var data = {
                        id : $node.data('key'),
                        parentId : 0
                    },
                    $left = $node.prev(),
                    $right = $node.next();

                if ($left.length) {
                    data.lftSiblingId = $left.data('key');
                }
                if ($right.length) {
                    data.rgtSiblingId = $right.data('key');
                }


                $.ajax({
                    url : options.moveNodeUrl + '?id=' + data.id,
                    type : 'POST',
                    data : data,
                    success : function () {
                        preloader.hide($container);
                    },
                    error : function () {
                        preloader.hide($container);
                    }
                });
            }
        }

        this.initSorting = function () {
            var $container = getContainer(),
                self = this;

            $container.find('.grid-view table tbody').sortable({
                update: function(event, ui) {
                    self.moveNode(ui.item);
                }
            });

        }

        this.initDateFilters = function () {
            var $container = getContainer(),
                $dateInput = $container.find('.filters [name$="created_at]"], .filters [name$="updated_at]"]');

            $dateInput.daterangepicker({
                presetRanges : [],
                dateFormat : 'yy-mm-dd',
                rangeSplitter : ' / '
            });
            $dateInput.on('click', function () {
                $(this).parent().find('.comiseo-daterangepicker-triggerbutton').click();
            });
            $dateInput.show().parent().find('.comiseo-daterangepicker-triggerbutton').hide();
        }

        /**
         * Initialize delete button. Confirmation window will be shown on delete button click.
         */
        this.initDeleteButton = function () {
            var $container = getContainer();

            $container.find(options.deleteButtonSelector).on('click', function () {
                var url = $(this).data('delete_url');
                if (url) {
                    modal.confirm({
                        content : {
                            text : options.deleteConfirmationText
                        },
                        events : {
                            ok : function() {
                                deleteRow(url);
                            }
                        }
                    });
                }
            });
        };

        /**
         * Send request to delete row.
         * @param url
         */
        function deleteRow(url)
        {
            var $container = getContainer();
            preloader.show($container);
            $.ajax({
                url : url,
                type : 'POST',
                success : function () {
                    if ($pjaxGrid && $pjaxGrid.length) {
                        $.pjax.reload({container: $pjaxGrid});
                        preloader.hide($container);
                    } else {
                        window.location.reload();
                    }
                }
            });
        }

        function getContainer()
        {
            var $container;
            if ($pjaxGrid && $pjaxGrid.length) {
                $container = $pjaxGrid;
            } else {
                $container = $(document);
            }
            return $container;
        }

        this.initGrid();
    }
});