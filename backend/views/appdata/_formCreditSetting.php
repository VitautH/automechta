<?php
/* @var $this yii\web\view */
/* @var $models common\models\AppData[] */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use common\models\AppRegistry;

$data = AppRegistry::find()->where(['data_type' => 'credit_bank'])->all();
$data_count = count($data);
$modelsName = AppRegistry::getModelsName();
$fields = AppRegistry::$fields['credit_bank'];
?>
<script>
    function AddField(id, name) {
        var num = $("#add_new_fields").data("num");
        $("#add_new_fields").before('<div class="row" id="row_' + (parseInt(num) + 1) + '"><div class="mdl-cell--6-col" style="float: left;"><input type="hidden" name="AppRegistry[credit_bank_' + (parseInt(num) + 1) + '][data_key]" value="credit_bank_' + (parseInt(num) + 1) + '"><input type="text" id="AppRegistry-label-credit_bank_' + (parseInt(num) + 1) + '" class="mdl-textfield__input" name="AppRegistry[credit_bank_' + (parseInt(num) + 1) + '][label]" value="" aria-invalid="false"><label class="mdl-textfield__label" for="AppRegistry-label-credit_bank_' + (parseInt(num) + 1) + '">Название банка</label></div><div class="mdl-cell--6-col" style="float: left; margin-left: 10px;"><input type="text" id="AppRegistry-credit_bank_' + (parseInt(num) + 1) + '" class="mdl-textfield__input" name="AppRegistry[credit_bank_' + (parseInt(num) + 1) + '][value]" value="" aria-invalid="false"><label class="mdl-textfield__label" for="AppRegistry-credit_bank_' + (parseInt(num) + 1) + '">Процентная ставка</label></div>');
        $("#add_new_fields").attr("num", (parseInt(num) + 1))

    }
    $(document).ready(function () {
        $(".delete").click(function (e) {
            e.preventDefault();
            var key = $(this).data('key');
            var num = $(this).data('num');
            var url = "/appdata/delete-bank";

            $.ajax({
                type: "POST",
                url: url,
                data: {'data-key': key},
                success: function (data) {
                    if (data) {
                        $("#row_" + num).fadeOut("slow");
                    }
                    else {
                        alert('Ошибка удаления');
                    }
                },
                error: function (data) {
                    alert('Произошла ошибка программы во время удаления');
                }

            });

        });
    })
</script>
<?php
//$form = ActiveForm::begin([
//    'enableAjaxValidation' => true,
//    'id' => 'appdata-form',
//    'validationUrl' => Url::to(['appdata/validate']),
//    'options' => ['class' => "mdl-grid mdl-form"],
//    'errorCssClass' => 'is-invalid',
//    'fieldConfig' => [
//        'template' => "{input}\n{label}\n{error}",
//        'options' => ['class' => 'mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label'],
//        'labelOptions' => ['class' => 'mdl-textfield__label'],
//        'errorOptions' => ['class' => 'mdl-textfield__error'],
//        'inputOptions' => ['class' => 'mdl-textfield__input']
//    ]
//]);
//?>
<!--<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">-->
<!--    --><?php //foreach($models as $model): ?>
<!--        --><?php //$filedConf = AppData::$fields[$model->data_key]; ?>
<!--        --><?php //if ($filedConf['data_type'] === 'credit_data'): ?>
<!--        --><?php //if ($filedConf['widget'] === 'select'): ?>
<!--            --><? //= $form->field(
//                $model,
//                "[{$model->data_key}]data_val")->dropDownList(
//                User::getPhoneProviders(),
//                    ['class' => 'm-select'])->label(Yii::t('app', $filedConf['label'])) ?>
<!---->
<!--        --><?php //elseif ($filedConf['widget'] === 'input'): ?>
<!--            --><? //= $form->field($model, "[{$model->data_key}]data_val")->textInput([])
//                ->label(Yii::t('app', $filedConf['label'])) ?>
<!--        --><?php //endif; ?>
<!--        --><?php //endif; ?>
<!--    --><?php
//    endforeach;
//    ?>
<!--</div>-->
<? //= Html::submitButton(
//    '<i class="material-icons">done</i>',
//    [
//        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
//        'title' => $model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update')
//    ])
//?>
<?php //ActiveForm::end(); ?>
<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'id' => 'credit-bank-form',
        'action' => '/appdata/save-bank',
        'options' => [],
        'errorCssClass' => 'is-invalid',
        'fieldConfig' => [
            'template' => "{input}\n{label}\n{error}",
            'options' => [],
            'labelOptions' => ['class' => 'mdl-textfield__label'],
            'errorOptions' => ['class' => 'mdl-textfield__error'],
            'inputOptions' => ['class' => 'mdl-textfield__input']
        ]
    ]);
    ?>
    <h3>Банки</h3>
    <form id="credit-bank-form">
        <?php
        if ($data_count == 0):
            ?>
            <div class="row" id="row_1">
                <div class="mdl-cell--5-col">
                    <input type="text"
                           id="<?= $modelsName. '-label-' . $fields['credit_bank_name']['data_key']; ?>_1"
                           class="mdl-textfield__input"
                           name="<?= $modelsName; ?>[<?= $fields['credit_bank_name']['data_key'] ?>_1][label]"
                           value="">
                    <label class="mdl-textfield__label"
                           for="<?= $modelsName. '-label-' . $fields['credit_bank_name']['data_key']; ?>_1"><?= $fields['credit_bank_name']['label']; ?></label>
                </div>
                <div class="mdl-cell--5-col" style="float:left; margin-left: 10px;">
                    <input type="text"
                           id="<?= $modelsName. '-' . $fields['credit_bank_value']['data_key']; ?>_1"
                           class="mdl-textfield__input"
                           name="<?= $modelsName; ?>[<?= $fields['credit_bank_value']['data_key']; ?>][value]"
                           value="">
                    <label class="mdl-textfield__label"
                           for="<?= $modelsName. '-' . $fields['credit_bank_value']['data_key']; ?>"><?= $fields['credit_bank_value']['label']; ?></label>
                </div>
            </div>
            <?
        else:
            foreach ($data as $i => $model): ?>
            <div class="row" id="row_<?= $i ?>">
                <?php if ($model->field_type === 'input'): ?>
                    <input type="hidden" name="<?= $modelsName; ?>[<?= $model->data_key; ?>][data_key]" value="<?= $model->data_key; ?>">
                    <div class="mdl-cell--5-col">
                        <input type="text" id="<?= $modelsName. '-label-' . $model->data_key; ?>"
                               class="mdl-textfield__input"
                               name="<?= $modelsName; ?>[<?= $model->data_key; ?>][label]"
                               value="<?= $model->label; ?>" aria-invalid="false">
                        <label class="mdl-textfield__label"
                               for="<?= $modelsName. '-' . $model->data_key; ?>"><?= $fields['credit_bank_name']['label']; ?></label>
                    </div>
                    <div class="mdl-cell--5-col" style="float:left; margin-left: 10px;">
                        <input type="text" id="<?= $model::getModelsName() . '-' . $model->data_key; ?>"
                               class="mdl-textfield__input"
                               name="<?= $model::getModelsName(); ?>[<?= $model->data_key; ?>][value]"
                               value="<?= $model->data_value; ?>" aria-invalid="false">
                        <label class="mdl-textfield__label"
                               for="<?= $model::getModelsName() . '-' . $model->data_key; ?>"><?= $fields['credit_bank_value']['label']; ?></label>
                    </div>
                    <div class="mdl-cell--2-col" style="float:left; margin-left: 10px;">
                        <a class="delete" data-num="<?= $i ?>" data-key="<?= $model->data_key; ?>" href="#">Удалить</a>
                    </div>
                    </div>
                <?php endif; ?>
                <?php
            endforeach;
        endif;
        ?>
        <div class="row">
            <div class="mdl-cell--6-col">
                <a id="add_new_fields" data-num="<?= $data_count; ?>" href="#"
                   onclick="AddField('<?= $modelsName. '-label-' . $fields['credit_bank_value']['data_key']; ?>','<?= $modelsName; ?>[<?= $fields['credit_bank_value']['data_key']; ?>][label]');">Добавить
                    еще банк</a>
            </div>
            <div class="mdl-cell--6-col">
                <?= Html::submitButton('Сохранить');
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
</div>