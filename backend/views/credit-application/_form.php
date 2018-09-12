<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 24.02.2018
 * Time: 21:50
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\MetaDataWidget;
?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'id' => 'page-form',
    'options' => ['class' => "mdl-grid mdl-form"],
    'errorCssClass' => 'is-invalid',
    'fieldConfig' => [
        'template' => "{input}\n{label}\n{error}",
        'options' => ['class' => 'mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label'],
        'labelOptions' => ['class' => 'mdl-textfield__label'],
        'errorOptions' => ['class' => 'mdl-textfield__error'],
        'inputOptions' => ['class' => 'mdl-textfield__input']
    ]
]);
?>
    <div class="mdl-cell mdl-cell--padding mdl-cell--8-col mdl-cell--12-col-tablet mdl-shadow--2dp">
        <div class="mdl-textfield mdl-textfield--full-width mdl-js-textfield">
            <label>Фамилия: </label>    <?= $form->field($model, 'firstname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false) ?>
            <br>
            <label>Имя: </label>  <?= $form->field($model, 'name', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false) ?>
            <br>
            <label>Отчество: </label>   <?= $form->field($model, 'lastname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false) ?>
            <br>
            <label>Номер телефона: </label>   <?= $form->field($model, 'phone', ['options' => ['class' => 'b-submit__main-element']])->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+375 (99) 999-99-99',
            ])->label(false); ?>
            <br>
            <label>Дата приезда: </label>   <?= $form->field($model, 'date_arrive', ['options' => ['class' => 'b-submit__main-element']])->input('date', ['class'=>'field'])->label(false) ?>
      <br>
            <label>Выбранное авто: </label>    <?= $form->field($model, 'product', ['options' => ['class' => 'b-submit__main-element']])->textInput( ['class'=>'field'])->label(false) ?>
            <br>

            <label>Заметка: </label>  <?= $form->field($model, 'note', ['options' => ['class' => 'b-submit__main-element']])->textarea(['rows'=>6])->label(false) ?>

        </div>
    </div>

<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' =>  $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app','Update')
    ])
?>
<?php ActiveForm::end(); ?>