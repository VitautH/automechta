/**
 * jsTree helper.
 */
define(['jquery', 'preloader', 'jstree'], function ($, preloader) {
    'use strict';

    return function ($tree, options)
    {
        var defaultOptions = {
                actions : [],
                max_depth : 1
            },
            self = this;

        options = $.extend(true, {}, defaultOptions, options);

        /**
         * Initialize list
         * @param object options
         */
        this.init = function () {

            this.jsTree = $tree.jstree({
                'plugins' : ['dnd', 'state', 'types'],
                'dnd':{
                    copy: false
                },
                'core' : {
                    'check_callback' : true,
                    'themes': {
                        'responsive': true
                    },
                    'data' : {
                        'url' : function (node) {
                            return options.dataUrl;
                        },
                        'data' : function (node) {
                            return { 'id' : node.id };
                        }
                    }
                },
                "types": {
                    "default": {
                        max_depth : options.max_depth,
                    },
                },
            });

            initEvents();
        };

        /**
         * Init tree events
         */
        function initEvents() {
            if (options.actions.length) {
                $tree.on('after_open.jstree', function(event, obj) {
                    var $openedNode = $('#' +  obj.node.id),
                        $nodes = $openedNode.find('.jstree-node');

                    $nodes = $nodes.add($openedNode);
                    addMenuToNodes($nodes);
                });
                $tree.on('redraw.jstree', function(event, obj) {
                    var $nodes = $tree.find('.jstree-node');
                    addMenuToNodes($nodes);
                });
                $tree.on('ready.jstree', function(event, obj) {
                    var $nodes = $tree.find('.jstree-node');
                    addMenuToNodes($nodes);
                });
            }

            $tree.on('move_node.jstree', function(event, obj) {
                preloader.show($tree);

                var data = {
                        id : obj.node.id
                    },
                    parent = obj.instance.get_node(obj.parent),
                    left,
                    right;

                if (parent.id !== '#') {
                    data.parentId = parent.id;
                }

                if (parent.children[obj.position - 1]) {
                    left = obj.instance.get_node(parent.children[obj.position - 1]);
                    data.lftSiblingId = left.id;
                }
                if (parent.children[obj.position + 1]) {
                    right = obj.instance.get_node(parent.children[obj.position + 1])
                    data.rgtSiblingId = right.id;
                }

                $.ajax({
                    url : options.moveNodeUrl + '?id=' + data.id,
                    type : 'POST',
                    data : data,
                    success : function () {
                        preloader.hide($tree);
                    },
                    error : function () {
                        preloader.hide($tree);
                    }
                })
            });
        }

        /**
         * Add menu to nodes
         * @param jQuery $nodes
         */
        function addMenuToNodes($nodes) {

            $nodes.find('>.jstree-anchor .js-node-menu-toggle').remove();
            $nodes.find('>.jstree-anchor .mdl-menu__container').remove();
            $nodes.each(function () {
                var $node = $(this),
                    $row = $node.find('>.jstree-anchor'),
                    $menu = getTreeMenu($node.attr('id'));

                $row.append($menu);
            });
            componentHandler.upgradeDom();
        }

        /**
         * Get item menu markup
         * @param id
         * @returns {string}
         */
        function getTreeMenu(id) {
            var menu = '<button id="js-node-menu-' + id + '" class="js-node-menu-toggle  jstree-node-button mdl-button mdl-js-button mdl-button--icon">' +
                '<i class="material-icons">more_vert</i>' +
                '</button>' +
                '<ul class="js-tree-menu mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="js-node-menu-' + id + '">' +
                '</ul>',
                $menu = $(menu),
                $menuList = $menu.filter('.js-tree-menu'),
                $menuNode,
                hidden,
                disabled;

            $.each(options.actions, function (key, action) {
                hidden = false;
                disabled = false;

                if (action.disabled !== undefined) {
                    if (typeof action.disabled === 'function') {
                        disabled = action.disabled(id);
                    } else {
                        disabled = action.disabled;
                    }
                }

                if (action.hidden !== undefined) {
                    if (typeof action.hidden === 'function') {
                        hidden = action.hidden(id);
                    } else {
                        hidden = action.hidden;
                    }
                }

                if (!hidden) {
                    $menuNode = $('<li' + (disabled ? ' disabled' : '') + ' class="mdl-menu__item">' + action.name + '</li>');
                    if (!disabled && action.callback && typeof action.callback === 'function') {
                        $menuNode.on('click', function () {
                            action.callback(id);
                        });
                    }
                    $menuList.append($menuNode);
                }
            });

            return $menu;
        }

        this.init();
    }
});