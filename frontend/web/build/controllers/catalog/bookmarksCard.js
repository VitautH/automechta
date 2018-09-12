define(['jquery'], function ($) {
    'use strict';
    function addBookmarks(action) {

        var productId = $(action).data('product');
        $.ajax({
            url: '/bookmarks/add?id=' + productId,
            type: 'GET',
            success: function (data) {
                $('#delete-bookmarks').show();
                $('#add-bookmarks').hide();
                $('#delete-bookmarks-mobile').show();
                $('#add-bookmarks-mobile').hide();
            }
        });
    };


    function deleteBookmarks(action) {
        var productId = $(action).data('product');
        $.ajax({
            url: '/bookmarks/delete?id=' + productId,
            type: 'GET',
            success: function (data) {
                $('#delete-bookmarks').hide();
                $('#add-bookmarks').show();
                $('#delete-bookmarks-mobile').hide();
                $('#add-bookmarks-mobile').show();
            }
        });

    };

    $('a.bookmarks').on('click', function (e) {
        e.preventDefault();
        var action = $(this).attr('id');

        switch (action) {
            case 'delete-bookmarks':
                deleteBookmarks(this);
                break;

            case 'add-bookmarks':
                addBookmarks(this);
                break;

        }
    });


    function addBookmarksRelative(action) {

        var productId = $(action).data('product');
        $.ajax({
            url: '/bookmarks/add?id=' + productId,
            type: 'GET',
            success: function (data) {
                $('#delete-bookmarks-'+data['id']).show();
                $('#add-bookmarks-'+data['id']).hide();
            }
        });
    };


    function deleteBookmarksRelative(action) {
        var productId = $(action).data('product');
        $.ajax({
            url: '/bookmarks/delete?id=' + productId,
            type: 'GET',
            success: function (data) {
                $('#delete-bookmarks-'+data['id']).hide();
                $('#add-bookmarks-'+data['id']).show();
            }
        });

    };

    $('a.bookmarks-relative').on('click', function (e) {
        e.preventDefault();
        var action = $(this).data('action');

        switch (action) {
            case 'delete-bookmarks':
                deleteBookmarksRelative(this);
                break;

            case 'add-bookmarks':
                addBookmarksRelative(this);
                break;

        }
    });

    function addBookmarksMobile(action) {

        var productId = $(action).data('product');
        $.ajax({
            url: '/bookmarks/add?id=' + productId,
            type: 'GET',
            success: function (data) {
                $('#delete-bookmarks-mobile').show();
                $('#add-bookmarks-mobile').hide();
            }
        });
    };


    function deleteBookmarksMobile(action) {
        var productId = $(action).data('product');
        $.ajax({
            url: '/bookmarks/delete?id=' + productId,
            type: 'GET',
            success: function (data) {
                $('#delete-bookmarks-mobile').hide();
                $('#add-bookmarks-mobile').show();
            }
        });

    };

    $('a.bookmarks-mobile').on('click', function (e) {
        e.preventDefault();
        var action = $(this).attr('id');

        switch (action) {
            case 'delete-bookmarks-mobile':
                deleteBookmarksMobile(this);
                break;

            case 'add-bookmarks-mobile':
                addBookmarksMobile(this);
                break;

        }
    });
});
