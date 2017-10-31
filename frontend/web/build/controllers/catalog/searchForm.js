define(['jquery', 'application', 'preloader', 'urijs/URI'], function ($, application, preloader, URI) {
    'use strict';

    var $form = $('.js-catalog-search-form'),
        currentUri = URI(window.location.href),
        currentParams = currentUri.search(true);

    $('[name="ProductSearchForm[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });

    if ($('[name="ProductSearchForm[model]"]').val() === null) {
        $('[name="ProductSearchForm[make]"]');
    }

    $(document).on('change', '.js-vehicle-type-select', function () {
        updateMakersList($(this).val());
        var uri = currentUri.clone();
        uri.setQuery('ProductSearchForm[type]', $(this).val());
        preloader.show($form);
        $.ajax({
            url: uri.toLocaleString(),
            success: function (response) {
                var $result = $('<div>' + response + '</div>');
                $('.js-vehicle-type-specs').replaceWith($result.find('.js-vehicle-type-specs'));
                preloader.hide($form);
            }
        });
    });

    $form.on('change', 'input, select:not(.js-vehicle-type-select)', function () {
        $form.submit();
    });

    $('[name="ProductSearchForm[yearFrom]"]').on('change', function () {
        var from = $(this).val();
        $('[name="ProductSearchForm[yearTo]"] option').removeAttr('disabled').each(function () {
            if ($(this).attr('value') < from) {
                $(this).attr('disabled', 'disabled');
            }
        });

        if ($('[name="ProductSearchForm[yearTo]"]').val() < from || $('[name="ProductSearchForm[yearTo]"]').val() == from) {
            $('[name="ProductSearchForm[yearTo]"] option:eq(1)').attr('selected', 'selected');
        }

    });
    $('[name="ProductSearchForm[yearTo]"]').on('change', function () {
        var to = $(this).val();
        $('[name="ProductSearchForm[yearFrom]"] option').removeAttr('disabled').each(function () {

            if ($('[name="ProductSearchForm[yearFrom]"]').attr('value') > to) {
                $('[name="ProductSearchForm[yearFrom]"]').attr('disabled', 'disabled');
            }
        });

        if ($('[name="ProductSearchForm[yearFrom]"]').val() < to || $('[name="ProductSearchForm[yearFrom]"]').val() == to) {
            $('[name="ProductSearchForm[yearFrom]"] option:last').attr('selected', 'selected');
        }

    });

    $('.js-reset-form').on('click', function () {
        $form.reset();
    });


    $form.on('submit', function (e) {
        e.preventDefault();
        preloader.show($('.js-product-list'));
        var uri = currentUri.clone();
        var data = $form.serialize();
        if (currentParams.tableView !== undefined) {
            data += '&tableView=' + currentParams.tableView;
        }

        $.ajax({
            url: currentUri.path(),
            data: data,
            success: function (response) {
                var $response = $('<div>' + response + '</div>');
                $('.js-product-list').replaceWith($response.find('.js-product-list'));
                $('.b-pageHeader__search').replaceWith($response.find('.b-pageHeader__search'));
                preloader.hide($('.js-product-list'));
                history.pushState({}, null, this.url);
                document.title = $response.find('.js-title').text();
            }
        });
    });

    function updateModelsList(makeId) {
        if (makeId) {
            preloader.show($form);
            $.ajax({
                url: '/api/productmake/models?makeId=' + makeId,
                success: function (response) {
                    $('[name="ProductSearchForm[model]"]').empty();
                    var $option = $(' <option value="">Любой</option>');
                    $('[name="ProductSearchForm[model]"]').append($option);
                    $.each(response, function (key, val) {
                        var $option = $('<option value="' + key + '">' + key + '</option>');
                        $('[name="ProductSearchForm[model]"]').append($option);
                    });
                    preloader.hide($form);
                }
            });
        } else {
            $('[name="ProductSearchForm[model]"]').empty();
            var $option = $(' <option value="">Любой</option>');
            $('[name="ProductSearchForm[model]"]').append($option);
        }
    }

    function updateMakersList(type) {
        var $makeSelect = $('[name="ProductSearchForm[make]"]');
        if (type) {
            preloader.show($form);
            $.ajax({
                url: '/api/productmake/makers?type=' + type,
                dataType: 'json',
                success: function (response) {
                    $makeSelect.empty();
                    var $option = $('<option value="">Любая</option>');
                    $makeSelect.append($option);
                    $.each(response, function (key, val) {
                        var $option = $('<option value="' + key + '">' + val + '</option>');
                        $makeSelect.append($option);
                    });
                    preloader.hide($form);
                    $makeSelect.trigger('change');
                },
                error: function () {
                    preloader.hide($form);
                    $makeSelect.replaceWith($('<span>Error</span>'));
                }
            });
        } else {
            $makeSelect.empty();
            var $option = $('<option value="">Любая</option>');
            $makeSelect.append($option);
        }
    }
});