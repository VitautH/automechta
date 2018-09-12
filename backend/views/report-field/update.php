<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\AuthItem;
use backend\models\ReportField;

$name = 'Обновить поле для отчётов';
$this->title = $name;
$form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'id' => 'report-field-form',
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
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Поле для отчётов</h3>
        <?= Html::submitButton(
            ' <i class="fa fa-save"></i>',
            [
                'class' => 'btn btn-app',
                'title' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update')
            ])
        ?>
    </div>
    <div class="box-body">
        <?echo $form->field($model, 'name_field')->textInput(['required'=>true])->hint('Пожалуйста, введите имя поля')->label('Имя поля');?>
        <?= $form->field($model, 'role_id')->dropDownList($model::getAdminRoles(), [])->label('Роль'); ?>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- /.box-footer-->
</div>
<?php ActiveForm::end(); ?>
