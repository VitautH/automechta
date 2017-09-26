<?php
/* @var $this yii\web\view */
/* @var $model common\models\AuthItem */
/* @var $permissionModels[] common\models\AuthItem */
/* @var $role yii\rbac\Role */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use \common\helpers\MdlHtml;

$role = Yii::$app->authManager->getRole($model->name);
?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['roles/validate', 'name' => $model->name]),
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
<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea() ?>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <h4><?= Yii::t('app', 'Permissions') ?></h4>
    <table class="mdl-list-table js-permissions-list">
    <?php foreach ($permissions as $permission): ?>
        <tr>
            <td class="mdl-list-table--checkbox-col">
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-permission-<?= $permission->name ?>">
                    <?=
                    Html::checkbox(
                        'permissions[' . $permission->name . ']',
                        $role !== null && Yii::$app->authManager->hasChild($role, $permission) ? true : false,
                        [
                            'id' => 'checkbox-permission-' . $permission->name,
                            'class' => 'mdl-checkbox__input',
                        ])
                    ?>
                </label>
            </td>
            <td>
                <strong><?= $permission->name ?></strong><br>
                <?= $permission->description ?>
            </td>
        </tr>
    <?php endforeach ?>
    </table>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' =>  $model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update')
    ])
?>
<?php ActiveForm::end(); ?>
