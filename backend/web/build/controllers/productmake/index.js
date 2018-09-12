define(['jquery', 'i18n', 'application', 'preloader', 'tree', 'modal'], function ($, __, application, preloader, tree, modal) {
    'use strict';

    var $tree = $('.js-tree'),
        jsTree,
        treeInstance;

    /**
     * Delete node from tree
     * @param string id
     */
    function updateItem(id) {
        window.location = '/productmake/update?id=' + id;
    }

    /**
     * Delete node from tree
     * @param string id
     */
    function deleteItem(id) {
        modal.confirm({
            content : {
                text : __('app', 'Are you sure you want to delete this item?')
            },
            events : {
                ok : function() {
                    preloader.show($tree);
                    $.ajax({
                        url : '/productmake/delete?id=' + id,
                        type : 'POST',
                        success : function () {
                            preloader.hide($tree);
                            var node = jsTree.get_node(id),
                                parentNode = jsTree.get_node(node.parent);

                            if (parentNode.id === '#') {
                                jsTree.refresh();
                            } else {
                                jsTree.refresh_node(parentNode);
                            }
                        },
                        error : function () {
                            console.log(arguments);
                            preloader.hide($tree);
                        }
                    });
                }
            }
        });
    }

    treeInstance = new tree($tree, {
        actions : [
            {
                name :  __('app', 'Update'),
                callback : function (id) {
                    updateItem(id);
                },
            },
             {
                 name : __('app', 'Delete'),
                 callback : function (id) {
                     deleteItem(id);
                 },
            },
        ],
        dataUrl : '/productmake/load-tree',
        moveNodeUrl : '/productmake/move-node'
    });

    jsTree = $tree.jstree(true);
});