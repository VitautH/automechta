<?php
/* @var $this yii\web\view */
/* @var $model common\models\ProductMake */
/* @var $currentSpecifications array */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\ProductType;

?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'id' => 'productmake-form',
    'validationUrl' => Url::to(['productmake/validate', 'id' => $model->id]),
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
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--4-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?= $form->field($model, 'id')->textInput(['name' => 'id', 'disabled' => 'disabled']) ?>
    <?= $form->field($model, "product_type")->dropDownList(ProductType::getTypesAsArray()) ?>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' => $model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update')
    ])
?>
<?php ActiveForm::end(); ?>
