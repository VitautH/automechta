<?php
/* @var $this yii\web\view */
/* @var $model common\models\User */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\helpers\MdlHtml;
use common\models\User;
use yii\helpers\Url;

?>
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['users/validate', 'id' => $model->id]),
    'options' => ['class' => "mdl-grid mdl-form"],
    'id' => 'user_form',
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
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone', ['options' => ['class'=>'mdl-textfield mdl-js-textfield mdl-textfield--floating-label']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone_provider', ['options' => ['class'=>'mdl-textfield mdl-js-textfield mdl-textfield--floating-label']])->dropDownList(User::getPhoneProviders()) ?>

    <?= $form->field($model, 'phone_2', ['options' => ['class'=>'mdl-textfield mdl-js-textfield mdl-textfield--floating-label']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone_provider_2', ['options' => ['class'=>'mdl-textfield mdl-js-textfield mdl-textfield--floating-label']])->dropDownList(User::getPhoneProviders()) ?>

    <?= $form->field($model, 'region')->dropDownList(User::getRegions()) ?>
    <?php if (!$model->isNewRecord): ?>
    <?= MdlHtml::toggle('change_password', false, ['label' => Yii::t('app', 'Change Password'), 'labelOptions' => ['class' => 'mdl-switch mdl-js-switch js-password-toggle']]) ?>
    <?php endif; ?>
    <div class="js-password-block">
        <?= $form->field($model, 'password_raw', ['enableClientValidation' => false])->passwordInput(['autocomplete'=>'off']) ?>
        <?= $form->field($model, 'password_repeat', ['enableClientValidation' => false])->passwordInput(['autocomplete'=>'off']) ?>
    </div>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <h4><?= Yii::t('app', 'Assigned Roles') ?></h4>
    <table class="mdl-list-table js-roles-list">
        <?php foreach (Yii::$app->authManager->getRoles() as $role): ?>
            <tr>
                <td class="mdl-list-table--checkbox-col">
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-roles-<?= $role->name ?>">
                        <?=
                        Html::checkbox(
                            'roles[' . $role->name . ']',
                            !$model->isNewRecord && Yii::$app->authManager->getAssignment($role->name, $model->id) ? true : false,
                            [
                                'id' => 'checkbox-roles-' . $role->name,
                                'class' => 'mdl-checkbox__input',
                            ])
                        ?>
                    </label>
                </td>
                <td>
                    <strong><?= $role->name ?></strong><br>
                    <?= $role->description ?>
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
