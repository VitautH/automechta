define(['jquery', 'application', 'preloader', 'uploader', 'maskedinput'], function ($, application, preloader, uploader) {
    'use strict';
    var $form = $('#create_product_form'),
        id = $('[name="Product[id]"]').val();
    $('[name="Product[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });

    function updateModelsList(makeId) {
        if (makeId) {
            $.ajax({
                url: '/api/productmake/models?makeId=' + makeId,
                success: function (response) {
                    $('[name="Product[model]"]').empty();
                    $.each(response, function (key, val) {
                        $('[name="Product[model]"]').val(key);
                    });
                }
            });
        }
    }


    initUploads();

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
    if ($('#product-phone_3').length) {
        $('#product-phone_3').mask("+375 (99) 999-99-99");
    }


    $('.update_ads #city').removeAttr('disabled');
    $('#city').attr('disabled', 'disabled');





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

    $('#button_publish').submit(function (e) {


        if ($('.dz-complete').length == 0) {
            $('#button_publish').attr("disabled", true);
            $(window).scrollTop($('.dropzone').offset().top);
            e.preventDefault();
        }
        else {
            $('#button_publish').attr("disabled", false);
        }


    });

    $('#contact-information-block-3').hide();
    $('.add_phone-block').click(function (e) {
        $('#contact-information-block-3').show();
        $('.add_phone-block').hide();
    });
});