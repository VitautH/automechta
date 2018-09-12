$(document).ready(function () {
    $("#year_form").hide();
    $("#price_form").hide();
    $("#year").click(function () {
        $("#year_form").slideToggle( "fast", function() {
        });

    });
    $("#price").click(function () {
        $("#price_form").slideToggle( "fast", function() {
        });
    });
    var $form = $('.form-filter');
    $('[name="ProductSearchForm[type]"]').on('change', function () {
        updateMakersList($(this).val());
        var $currentOption = $(this).find('option[value="' + $(this).val() + '"]').attr('selected', true);
    }).trigger('change');

    $('[name="ProductSearchForm[make]"]').on('change', function () {
        updateModelsList($(this).val());
    });
    $('[name="ProductSearchForm[model]"]').on('change', function () {
        getCount();
    });
    $('[name="ProductSearchForm[yearFrom]"]').on('change', function () {
        var from = $(this).val();
        $('[name="ProductSearchForm[yearTo]"] option').removeAttr('disabled').each(function () {
            if ($(this).attr('value') < from) {
                $(this).attr('disabled', 'disabled');
            }
        });
        getCount();
    });
    $('[name="ProductSearchForm[yearTo]"]').on('change', function () {
        var to = $(this).val();
        $('[name="ProductSearchForm[yearFrom]"] option').removeAttr('disabled').each(function () {

            if ($('[name="ProductSearchForm[yearFrom]"]').attr('value') > to) {
                $('[name="ProductSearchForm[yearFrom]"]').attr('disabled', 'disabled');
            }
        });
        getCount();
    });
    $('[name="ProductSearchForm[priceFrom]"]').on('change', function () {
        var from = Number($(this).val());
        $('[name="ProductSearchForm[priceTo]"] option').removeAttr('disabled').each(function () {
            if ($(this).attr('value') < from) {
                $(this).attr('disabled', 'disabled');
            }
        });
        getCount();
    });
    $('[name="ProductSearchForm[priceTo]"]').on('change', function () {
        var to = Number($(this).val());
        $('[name="ProductSearchForm[priceFrom]"] option').removeAttr('disabled').each(function () {
            if ($('[name="ProductSearchForm[priceFrom]"]').attr('value') > to) {
                $('[name="ProductSearchForm[priceFrom]"]').attr('disabled', 'disabled');
            }
        });
        getCount();
    });
    function updateModelsList(makeId) {
        if (makeId) {
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
                },
                error: function () {
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
                    $makeSelect.trigger('change');
                },
                error: function () {
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
                $("#result").text(response);
            },
            error: function () {
            }
        });
    }


    $('#search').click(function(e){
        e.preventDefault();
        var $form = $('.form-filter');
        var data = $form.serialize();
        var type = $('[name="ProductSearchForm[type]"]').val();
        switch (type){
            case '2':
                type = 'cars';
                break;
            case '3':
                type = 'moto';
                break;
            case '4':
                type = 'scooter';
                break;
            case '5':
                type = 'atv';
                break;
            default:
                type = 'cars';
                break;
        }


            location.assign('http://www.automechta.by/search/'+type+'?'+data);

        
    });
});