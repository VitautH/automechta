define(['jquery', 'application', 'gridview'], function ($, application, gridview) {
    'use strict';

    var pjaxGridId = '#reviews_grid_wrapper',
        gridViewHelper = new gridview({
            pjaxGridSelector : pjaxGridId,
            sortable : true,
            moveNodeUrl : '/reviews/move-node'
        });
});