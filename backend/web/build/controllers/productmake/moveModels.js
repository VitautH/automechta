define(['jquery', 'i18n', 'helpers', 'modal'], function ($, __, helpers, modal) {
    'use strict';

    $('#add_model').click(function (e) {
        e.preventDefault();
        var data = $('#form_add_model').serialize();
        $.ajax({
            url: '/productmake/add-model',
            type: 'POST',
            data: data,
            success: function (response) {

                var response = JSON.parse(response);
                var nameModel = response.nameModel;
                var id = response.id;
                var parentId = response.parentId;
                var lft = response.lft;
                var rgt = response.rgt;
                MoveModels(nameModel, id, parentId, lft, rgt);

            },
            error: function () {
                modal.toast(__('app', 'Произошла ошибка'), __('app', ''));
            }
        });

    });

    function MoveModels(nameModel, id, parentId, lft, rgt) {

        if (lft == null || rgt == null) {
            var data = {
                'id': 'productmake_' + id,
                'parentId': 'productmake_' + parentId,
            };
        }
        else {
            var data = {
                'id': 'productmake_' + id,
                'parentId': 'productmake_' + parentId,
                'lftSiblingId': 'productmake_' + lft,
                'rgtSiblingId': 'productmake_' + rgt
            };
        }

        $.ajax({
            url: '/productmake/move-node?id=productmake_' + id,
            type: 'POST',
            data: data,
            success: function (response) {
                $('#models_list').prepend('<li style="color: green;">' + nameModel + '</li>');
                modal.toast(__('app', 'Добавлена модель'), __('app', ''));
            },
            error: function () {
                modal.toast(__('app', 'Произошла ошибка'), __('app', ''));
            }
        });

    }


});
