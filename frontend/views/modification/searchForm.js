define(['jquery', 'application', 'preloader'], function ($, application, preloader) {
    'use strict';
    $("#year_form").hide();
$(document).ready(function(){
    $("#year").click(function () {
        $("#year_form").slideToggle( "fast", function() {
        });

    });

    var $form = $('#search_form_main');
    $('[name="AutoSearch[make]"]').on('change', function () {
        updateModelsList($(this).val());
        getCount();
    });
    $('[name="AutoSearch[model]"]').on('change', function () {
        getCount();
    });

    $('[name="AutoSearch[yearFrom]"]').on('change', function () {
        // var from = parseInt($(this).val());
        // $('[name="AutoSearch[yearTo]"] option').removeAttr('disabled').each(function () {
        //     if (parseInt($(this).attr('value')) < from) {
        //         $(this).attr('disabled', 'disabled');
        //     }
        // });
        //
        // if (parseInt($('[name="AutoSearch[yearTo]"]').val()) < from) {
        //     $('[name="AutoSearch[yearTo]"]').val(from);
        // }
        getCount();
    });
    $('[name="AutoSearch[yearTo]"]').on('change', function () {
        getCount();
    })



    function updateModelsList(makeId) {
        if (makeId) {
            preloader.show($form);
            $.ajax({
                url: '/api/modificationsearch/models?makeId=' + makeId,
                dataType: 'json',
                success: function (response) {
                    $('[name="AutoSearch[model]"]').empty();
                   var $option = $('<option value="">Модель</option>');
                   $('[name="AutoSearch[model]"]').append($option);
                    $.each(response, function (key, val) {
                        var $option = $('<option value="' + key + '">' + val + '</option>');
                        $('[name="AutoSearch[model]"]').append($option);
                    });
                    preloader.hide($form);
                },
                error: function () {
                    preloader.hide($form);
                    $('[name="AutoSearch[model]"]').replaceWith($('<span>Error</span>'));
                }
            });
        } else {
            $('[name="AutoSearch[model]"]').empty();
          var $option = $('<option value="">Модель</option>');
           $('[name="AutoSearch[model]"]').append($option);
        }
        getCount();
    }

    function updateMakersList(region) {
        var $makeSelect = $('[name="AutoSearch[make]"]');
        if (region) {
            preloader.show($form);
            $.ajax({
                url: '/api/modificationsearch/makers?region=' + region,
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
            url: '/api/modificationsearch/search',
            dataType: 'html',
            success: function (response) {

                $("#search-result").html('Найдено <div id="result">'+ response+' модификаций</div>');
            },
            error: function () {
            }
        });
    }
    $('#search').click(function(e){
        e.preventDefault();
        var $form = $('#search_form_main');
        var data = $form.serialize();

         location.assign('http://www.automechta.by/catalog/search?'+data);
    });
});
});