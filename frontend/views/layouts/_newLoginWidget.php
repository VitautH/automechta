<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \common\models\LoginForm;
use yii\helpers\Url;

$model = new LoginForm();
?>
<div class="modal-login-bookmarks">
    <div class="head row justify-content-between">
        <div class="col-5">
            <h2 class="modal-title">Войти</h2>
        </div>
        <div class="col-2">
            <button type="button" class="modal-close">
                <i class="fas fa-close"></i></button>
        </div>
    </div>
    <div class="body">
         <?php $form = ActiveForm::begin(
             [
                 'id' => 'login-form',
                 'action' => '/site/login',
                 'enableAjaxValidation' => true,
                 'options' => [
                     'class' => 'login-form',
                 ]
             ]
         );
         ?>
     <div class="form-block">
         <?= $form->field($model, 'email')->textInput(['class' => 'login-input', 'required'=>'required','placeholder'=>'Логин / E-mail'])->label(false); ?>
     </div>
     <div class="form-block">
         <?= $form->field($model, 'password')->passwordInput(['class' => 'login-input', 'required'=>'required','placeholder'=>'Пароль'])->label(false);?>
     </div>
        <div class="remember-form-block form-block">
                 <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <a href="#" class="reset-password">Забыли пароль ?</a>
            </div>


         <div class="form-button form-block">
             <button type="submit" class="custom-button"
                     name="login-button"><?= Yii::t('app', 'Login') ?></button>
         </div>

             <?php ActiveForm::end(); ?>
    </div>
    <div class="footer">
         <h3>Вход через социальные сети</h3>

         <div class="login-block">
                 <div class="social_login">
                     <a href="/site/auth?authclient=vkontakte" class="vk-login"><i class="fab fa-vk fa"
                                                                                   aria-hidden="true"></i></a>
                     <a href="/site/auth?authclient=facebook" class="fb-login"><i class="fab fa fa-facebook"
                                                                                  aria-hidden="true"></i></a>
                     <a href="/site/auth?authclient=google" class="google-login"><i
                                 class="fab fa fa-google-plus-official" aria-hidden="true"></i></a>
                     <a href="/site/auth?authclient=yandex" class="ya-login"><span>Я</span></a>
                     <a href="/site/auth?authclient=odnoklassniki" class="ok-login"><i
                                 class="fab fa fa-odnoklassniki" aria-hidden="true"></i></a>
                 </div>
         </div>
         <span class="register-title">Впервые  на сайте? </span>
         <a href="#" class="registration show-modal-registration-login-block custom-button">
                    <?= Yii::t('app', 'Register') ?>
                </a>
     </div>
</div>