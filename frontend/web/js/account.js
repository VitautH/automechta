$(document).ready(function () {

    $('input.select-on-check-all:checkbox').click(function (event) {
        $("input[name='selection[]']").each(function () {
            if ($(this).is(':checked')) {
                $(this).prop("checked", false);
            }
            else {
                var disabled = $(this).attr('disabled');
                if (disabled !== 'disabled') {
                    $(this).prop("checked", true);
                }
            }
        });
    });
    $('#up-ads').click(function (e) {
        e.preventDefault();
        var selection = new Array();
        $("input[name='selection[]']:checked").each(function () {
            selection.push($(this).val());
        });
        if (selection.length === 0) {
            alert('Выберите минимум одно объявление!');
        }
        else {
            $('.popup-block').show();
            $('.load-spinner').show();
            $(window).scrollTop(0);
            $('body').css("overflow-y", "hidden");
            $.ajax({
                url: '/account/product-change',
                type: 'POST',
                data: {ads: selection, action: 'ads'},
                success: function (data) {
                    if (data['status'] == 'success') {
                        var protocol = document.location.protocol;
                        var host = document.location.host;
                        var path  = document.location.pathname;
                        window.location.replace(protocol+"//"+host+""+path);
                    }
                    if (data['status'] == 'failed') {
                        alert('Произошла ошибка');
                        $('.load-spinner').hide();
                        $('.popup-block').hide();
            $('body').css("overflow-y", "visible");
                    }
                },
                error: function (data) {
                    if (data['status'] == 'failed') {
                        alert('Произошла ошибка');
                        $('.load-spinner').hide();
                        $('.popup-block').hide();
            $('body').css("overflow-y", "visible");
                    }
                }
            });
        }
    });
    $('.js-delete-row').on('click', function (e) {
        e.preventDefault();

        var r = confirm('Вы действительно хотите удалить объявление?');
        if (r == true) {
            var delete_url = $(this).data('delete_url');
            $.ajax({
                url: delete_url,
                type: 'POST',
                success: function (data) {
                    $('tr[data-key=' + data['id'] + ']').fadeOut();
                }
            });
        }
    });

    $('.js-delete-bookmarks-row').on('click', function (e) {
        e.preventDefault();
        var delete_url = $(this).data('delete_url');
        $.ajax({
            url: delete_url,
            type: 'GET',
            success: function (data) {
                $('tr[data-key=' + data['id'] + ']').fadeOut();
            }
        });
    });
    $('.js-up-row').on('click', function (e) {
        e.preventDefault();
        var up_url = $(this).data('up_url');
        $.ajax({
            url: up_url,
            type: 'GET',
            success: function (data) {
                if (data['status'] == 'success') {
                    $('<br><span class="update">Объявление поднято</span>').insertAfter('#' + data['id']);
                    $('#' + data['id']).fadeOut();
                }
                if (data['status'] == 'failed') {
                    $('<br><span class="error">Извините, Вы не можете поднять объявление</span>').insertAfter('#' + data['id']);
                    $('#' + data['id']).fadeOut();
                }
            }
        });
    });
});