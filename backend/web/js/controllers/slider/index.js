define(['jquery', 'application', 'gridview'], function ($, application, gridview) {
    'use strict';

    var pjaxGridId = '#slider_grid_wrapper',
        gridViewHelper = new gridview({
            pjaxGridSelector : pjaxGridId,
            sortable : true,
            moveNodeUrl : '/slider/move-node'
        });
});