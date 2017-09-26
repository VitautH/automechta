define(['jquery', 'application', 'gridview'], function ($, application, gridview) {
    'use strict';

    var pjaxGridId = '#specification_grid_wrapper',
        gridViewHelper = new gridview({
            pjaxGridSelector : pjaxGridId,
            sortable : true,
            moveNodeUrl : '/specification/move-node'
        });
});