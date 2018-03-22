<?php
/* @var $this yii\web\view */

/* @var $model common\models\MailingLists */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;
use common\models\MailingLists;

?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['mailing-lists/validate', 'id' => $model->id]),
    'id' => 'mailinglist-form',
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
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect js-i18n-tabs">
        <?= $form->field($model, "title")->textInput(['maxlength' => true])->label('Название рассылки'); ?>
        <?= $form->field($model, "text")->textarea(['rows' => 8, 'class' => 'js-wysiwyg wysiwyg'])->label('Текст рассылки'); ?>
        <?= $form->field($model, 'status')->dropDownList($model::getStatuses(), [])->label('Статус'); ?>
        <?= $form->field($model, 'type')->dropDownList($model::getTypes(), [])->label('Тип'); ?>
        <?= $form->field($model, "note")->textarea(['rows' => 6])->label('Заметка (не обязательно)'); ?>
    </div>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update')
    ])
?>
<?php ActiveForm::end(); ?>
