define(['jquery', 'application', 'urijs/URI', 'controllers/catalog/searchForm'], function ($, application, URI) {
    'use strict';
    var currentUri = URI(window.location.href),
        currentParams = currentUri.search(true);

    $('.js-sorter a').on('click', function (e) {
        e.preventDefault();
        var uri = URI(window.location.href);
        uri.setQuery('sort', $(this).data('sort'));
        window.location = uri.toString();
    });

    $('.js-change-view').on('click', function (e) {
        e.preventDefault();
        currentUri = URI(window.location.href);
        if ($(this).data('view') === 'table') {
            currentUri.setQuery('tableView', '1');
        } else {
            currentUri.setQuery('tableView', '0');
        }
        window.location = currentUri.toLocaleString();
    });


});