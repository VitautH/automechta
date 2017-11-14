define(['jquery', 'application', 'preloader'], function ($, application, preloader) {
    'use strict';

    var $form = $('#search_form_main');

    $('[name="ProductSearchForm[type]"]').on('change', function () {
        updateMakersList($(this).val());
        var $currentOption = $(this).find('option[value="' + $(this).val() + '"]');
    }).trigger('change');

    $('[name="ProductSearchForm[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });
    $('[name="ProductSearchForm[model]"]').on('change', function () {
        getCount();
    });
    $('[name="ProductSearchForm[yearFrom]"]').on('change', function () {
        getCount();
    });
    $('[name="ProductSearchForm[yearTo]"]').on('change', function () {
        getCount();
    });
    $('[name="ProductSearchForm[priceFrom]"]').on('change', function () {
        getCount();
    });
    $('[name="ProductSearchForm[priceTo]"]').on('change', function () {
        getCount();
    });
    function updateModelsList(makeId) {
        if (makeId) {
            preloader.show($form);
            $.ajax({
                url: '/api/productmake/models?makeId=' + makeId,
                dataType: 'json',
                success: function (response) {
                    $('[name="ProductSearchForm[model]"]').empty();
                    var $option = $('<option value="">Модель</option>');
                    $('[name="ProductSearchForm[model]"]').append($option);
                    $.each(response, function (key, val) {
                        var $option = $('<option value="' + key + '">' + key + '</option>');
                        $('[name="ProductSearchForm[model]"]').append($option);
                    });
                    preloader.hide($form);
                },
                error: function () {
                    preloader.hide($form);
                    $('[name="ProductSearchForm[model]"]').replaceWith($('<span>Error</span>'));
                }
            });
        } else {
            $('[name="ProductSearchForm[model]"]').empty();
            var $option = $('<option value="">Модель</option>');
            $('[name="ProductSearchForm[model]"]').append($option);
        }
        getCount();
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
                    var $option = $('<option value="">Марка</option>');
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
            var $option = $('<option value="">Марка</option>');
            $makeSelect.append($option);
        }
        getCount();
    }

    function getCount() {
        var data = $form.serialize();
        $.ajax({
            data: data,
            url: '/api/productmake/search',
            dataType: 'html',
            success: function (response) {
                $(".count_search_result #count").text(response);
            },
            error: function () {
            }
        });
    }
});