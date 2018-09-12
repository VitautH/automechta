<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\PasswordResetRequestForm;

$model = new PasswordResetRequestForm();
?>
<div class="modal-login-bookmarks">
    <div class="head row justify-content-between">
        <div class="col-10">
            <h2 class="modal-title">Сбросить пароль</h2>
        </div>
        <div class="col-2">
            <button type="button" class="modal-close">
                <i class="fas fa-close"></i></button>
        </div>
    </div>
    <div class="body">
            <span class="hint">
           Пожалуйста, введите Email. Мы отправим ссылку для сброса пароля
        </span>
        <?php $form = ActiveForm::begin(
            [
                'id' => 'request-password-reset-form',
                'action' => '/site/request-password-reset',
                'enableAjaxValidation' => true,
                'options' => [
                    'class' => 'login-form',
                ]
            ]
        );
        ?>
        <div class="form-block">
            <?= $form->field($model, 'email')->textInput(['class' => 'login-input', 'required'=>'required','placeholder'=>'Логин / E-mail'])->label(false); ?>
      <span class="error">

      </span>
        </div>
        <div class="form-button form-block">
            <button type="submit" id="reset-password-button" class="custom-button"
                    name="login-button">Отправить  ></button>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>