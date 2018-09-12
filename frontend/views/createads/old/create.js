define(['jquery', 'application', 'preloader', 'uploader', 'maskedinput'], function ($, application, preloader, uploader) {
    'use strict';
    
    /*
       ToDo: Временное решение!!! Убрать!!!
        */
    localStorage.clear();

    var $form = $('#create_product_form'),
        id = $('[name="Product[id]"]').val();

    var stepLocalStorage = ["adsTextStep1", "adsSelectStep1", "adsTextareaStep1", "adsCheckboxStep1", "adsRadioStep1", "adsTextStep2", "adsTextStep3", "adsSelectStep3"];

    /*
    Local Storage
     */
    var adsTextStep1 = JSON.parse(localStorage.getItem("adsTextStep1"));
    $.each(adsTextStep1, function (key, value) {
        $("input[name='" + key + "']").val(value);
    });
    var adsTextareaStep1 = JSON.parse(localStorage.getItem("adsTextareaStep1"));
    $.each(adsTextareaStep1, function (key, value) {
        $("textarea[name='" + key + "']").val(value);
    });
    var adsSelectStep1 = JSON.parse(localStorage.getItem("adsSelectStep1"));
    $.each(adsSelectStep1, function (key, value) {
        $("select[name='" + key + "']").val(value);
    });

    var adsCheckboxStep1 = JSON.parse(localStorage.getItem("adsCheckboxStep1"));
    $.each(adsCheckboxStep1, function (key, value) {
        $("#" + key + "").prop('checked', true);
    });

    var adsRadioStep1 = JSON.parse(localStorage.getItem("adsRadioStep1"));
    $.each(adsRadioStep1, function (key, value) {
        $("#" + key + "").prop('checked', true);
    });

    var adsTextStep2 = JSON.parse(localStorage.getItem("adsTextStep2"));
    $.each(adsTextStep2, function (key, value) {
        $("input[name='" + key + "']").val(value);
    });

    var adsSelectStep3 = JSON.parse(localStorage.getItem("adsSelectStep3"));
    $.each(adsSelectStep3, function (key, value) {
        $("select[name='" + key + "']").val(value);
    });
    var adsTextStep3 = JSON.parse(localStorage.getItem("adsTextStep3"));
    $.each(adsTextStep3, function (key, value) {
        $("input[name='" + key + "']").val(value);
    });
    /*
    End Local Storage
     */

    $('[name="Product[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });

    if ($('[name="Product[model]"]').val() === null) {
        $('[name="Product[make]"]').trigger('change');
    }

    function updateModelsList(makeId) {
        if (makeId) {
            $.ajax({
                url: '/api/productmake/models?makeId=' + makeId,
                success: function (response) {
                    $('[name="Product[model]"]').empty();
                    $('[name="Product[model]"]').append('<option value="" selected>Выбрать</option>');
                    $.each(response, function (key, val) {
                        var $option = $('<option value="' + key + '">' + key + '</option>');
                        $('[name="Product[model]"]').append($option);
                    });
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
    if ($('#product-phone_3').length) {
        $('#product-phone_3').mask("+375 (99) 999-99-99");
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
        var adsTextStep1 = {};
        $('.step-1').find('input[type=text]').each(function (key, value) {
            adsTextStep1[this.name] = this.value;
        });
        localStorage.setItem('adsTextStep1', JSON.stringify(adsTextStep1));

        var adsCheckboxStep1 = {};
        $('.step-1').find('input[type=checkbox]').each(function () {
            if ($(this).is(':checked')) {
                adsCheckboxStep1[this.id] = true;
            }
        });
        localStorage.setItem('adsCheckboxStep1', JSON.stringify(adsCheckboxStep1));

        var adsRadioStep1 = {};
        $('.step-1').find('input[type=radio]').each(function () {
            if ($(this).is(':checked')) {
                adsRadioStep1[this.id] = true;
            }
        });
        localStorage.setItem('adsRadioStep1', JSON.stringify(adsRadioStep1));

        var adsTextareaStep1 = {};
        $('.step-1').find('textarea').each(function () {
            adsTextareaStep1[this.name] = this.value;
        });
        localStorage.setItem('adsTextareaStep1', JSON.stringify(adsTextareaStep1));

        var adsSelectStep1 = {};
        $('.step-1').find('select').each(function () {
            adsSelectStep1[this.name] = this.value;
        });
        localStorage.setItem('adsSelectStep1', JSON.stringify(adsSelectStep1));

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
            $('#nav-step-3').addClass('active');
        }
        else {
            $(window).scrollTop($('.step-1').offset().top);
        }
    });

    $('#to-step-3').click(function () {

        var adsTextStep2 = {};
        $('.step-2').find('input[type=text]').each(function (key, value) {
            adsTextStep2[this.name] = this.value;
        });
        localStorage.setItem('adsTextStep2', JSON.stringify(adsTextStep2));

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
            $('#nav-step-4').addClass('active');
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

    $('#button_publish').submit(function (e) {

        stepLocalStorage.forEach(function (item) {
            localStorage.removeItem(item);
        });

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
            var adsTextStep3 = {};
            $('.step-3').find('input[type=text]').each(function (key, value) {
                adsTextStep3[this.name] = this.value;
            });
            localStorage.setItem('adsTextStep3', JSON.stringify(adsTextStep3));

            var adsSelectStep3 = {};
            $('.step-3').find('select').each(function () {
                adsSelectStep3[this.name] = this.value;
            });
            localStorage.setItem('adsSelectStep3', JSON.stringify(adsSelectStep3));
            $('#button_publish').attr("disabled", true);
            $(window).scrollTop($('.step-3').offset().top);
        }
        else {
            stepLocalStorage.forEach(function (item) {
                localStorage.removeItem(item);
            });
        }

    });

    $('#contact-information-block-3').hide();
    $('.add_phone-block').click(function (e) {
        $('#contact-information-block-3').show();
        $('.add_phone-block').hide();
    });
});