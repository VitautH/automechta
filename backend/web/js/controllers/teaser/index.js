define(['jquery', 'application', 'gridview'], function ($, application, gridview) {
    'use strict';

    var pjaxGridId = '#teaser_grid_wrapper',
        gridViewHelper = new gridview({
            pjaxGridSelector : pjaxGridId,
            sortable : true,
            moveNodeUrl : '/teaser/move-node'
        });
});