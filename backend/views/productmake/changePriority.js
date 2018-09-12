define(['jquery', 'i18n', 'application', 'preloader', 'tree', 'modal'], function ($, __, application, preloader, tree, modal) {
    'use strict';
    $('#form_change_priority').submit(function (e) {
        e.preventDefault();
        var priority = $( "[name='ProductMake[priority]'] option:selected" ).val();
        var id = $("[name='ProductMake[parentId]']").val();
        var type = $("[name='ProductMake[product_type]']").val();
        $.ajax({
            type: "GET",
            url: '/productmake/change-priority?type='+type+'&id='+id+'&priority='+priority,
            success: function (response) {
                if (response['status'] == 'success'){
                    var text_priority;

                    if (response['priority'] == 1) {
                        text_priority = 'Высокий';
                    }
                    if (response['priority'] == 0) {
                        text_priority = 'Низкий';
                    }
                    $('.priority').empty();
                    $('.priority').text(text_priority);
                    modal.toast('Успех!', 'Приоритет изменён!');
                }
                if (response['status'] == 'failed') {
                    modal.toast('Ошибка!', 'Произошла ошибка');
                }
            },
            error:
                function (response) {
                    modal.toast('Ошибка!', 'Произошла ошибка');
                }
        });
    });

});