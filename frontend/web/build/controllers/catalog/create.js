define(['jquery', 'application', 'preloader', 'uploader', 'maskedinput'], function ($, application, preloader, uploader) {
    'use strict';
    var $form = $('#create_product_form'),
        id = $('[name="Product[id]"]').val();

    $('[name="Product[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });

    if ($('[name="Product[model]"]').val() === null) {
        $('[name="Product[make]"]').trigger('change');
    }

    function updateModelsList(makeId) {
        if (makeId) {
            preloader.show($form);
            $.ajax({
                url: '/api/productmake/models?makeId=' + makeId,
                success: function (response) {
                    $('[name="Product[model]"]').empty();
                    $('[name="Product[model]"]').append('<option value=""   selected>Выбрать</option>');
                    $.each(response, function (key, val) {
                        var $option = $('<option value="' + key + '">' + key + '</option>');
                        $('[name="Product[model]"]').append($option);
                    });
                    preloader.hide($form);
                }
            });
        }
    }

    initUploads()

    function initUploads() {
        if ($(".js-dropzone").length === 1) {
            var fileUploader = new uploader({
                url: "/uploads/upload?linked_table=product&linked_id=" + id,
                container: $(".js-dropzone")
            });
        }
    }

    if ($('#product-phone').length) {
        $('#product-phone').mask("+375 (99) 999-99-99");
    }

    if ($('#product-phone_2').length) {
        $('#product-phone_2').mask("+375 (99) 999-99-99");
    }

    $('.step-2').hide();
    $('.step-3').hide();
    $('#to-step-3').hide();
    $('.update_ads #city').removeAttr('disabled');
    $('#city').attr('disabled', 'disabled');
    $('#button_publish').hide();

    $('.update_ads #button_publish').show();
    $('.required-field').change(function () {
        if ($(this).val() != '') {
            $(this).removeClass('empty_field');
            $(this).css({
                "border-color": "green",
                "border-width": "1px",
                "border-style": "solid"
            });
        }
        else {
            $(this).addClass('empty_field');
            $(this).css({
                "border-color": "#df4142",
                "border-width": "1px",
                "border-style": "solid"
            });
        }

    });

    $('#to-step-2').click(function () {
        $('.step-1').find('.required-field').each(function () {
            if ($(this).val() != '') {
                $(this).removeClass('empty_field');
            } else {
                $(this).addClass('empty_field');
                $(this).css({
                    "border-color": "#df4142",
                    "border-width": "1px",
                    "border-style": "solid"
                });
            }
        });

        if ($('.empty_field').length == 0) {
            $('.step-2').show();
            $('#to-step-2').hide();
            $('#to-step-3').show();
        }
        else {
            $(window).scrollTop($('.step-1').offset().top);
        }
    });

    $('#to-step-3').click(function () {
        $('.step-2').find('.required-field').each(function () {
            if ($(this).val() != '') {
                $(this).removeClass('empty_field');
            } else {
                $(this).addClass('empty_field');
                $(this).css({
                    "border-color": "#df4142",
                    "border-width": "1px",
                    "border-style": "solid"
                });
            }
        });

        if ($('.dz-complete').length == 0) {
            $(window).scrollTop($('.dropzone').offset().top);
        }
        else {
            $('.step-3').show();
            $('#to-step-2').hide();
            $('#to-step-3').hide();
            $('#button_publish').show();
        }
    });

    $('#region').change(function () {
        var regionId = $(this).val();
        updateCityList(regionId);
    })
    function updateCityList(regionId) {
        if (regionId) {
            $.ajax({
                url: '/api/city/city?regionId=' + regionId,
                success: function (city) {
                    $('[name="Product[city_id]"]').empty();
                    if (regionId != 1) {
                        $('[name="Product[city_id]"]').append('<option value=""  selected>Выбрать</option>');
                    }
                    for (var i = 0; i < city.length; i++) {
                        var $option = $('<option value="' + city[i].id + '">' + city[i].city_name + '</option>');
                        $('[name="Product[city_id]"]').append($option);
                    }
                    $('#city').removeAttr('disabled');
                }
            });
        }
    }

    $('#button_publish').click(function (e) {
        $('.step-3').find('.required-field').each(function () {
            if ($(this).val() != '') {
                $(this).removeClass('empty_field');
            } else {
                $(this).addClass('empty_field');
                $(this).css({
                    "border-color": "#df4142",
                    "border-width": "1px",
                    "border-style": "solid"
                });
            }
        });

        if (($('.empty_field').length != 0) && ($('.dz-complete').length != 0)) {
            e.preventDefault();
            $('#button_publish').attr("disabled", true);
            $(window).scrollTop($('.step-3').offset().top);
        }

    });
});