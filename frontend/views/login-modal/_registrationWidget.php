<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\models\SignupForm;
use yii\helpers\Url;

$model = new SignupForm();
?>
<div class="modal-login-bookmarks">
    <div class="head row justify-content-between">
        <div class="col-5">
            <h2 class="modal-title">Регистрация</h2>
        </div>
        <div class="col-2">
            <button type="button" class="modal-close">
                <i class="fas fa-close"></i></button>
        </div>
    </div>
    <div class="body">
        <span class="fill-form">
            Заполните форму регистрации
        </span>
        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'action' => '/site/signup',
            'enableAjaxValidation' => true,
            'validationUrl' => '/site/signupvalidation',
            'options' => [
                'class' => 'login-form',
            ]
        ]); ?>
        <div class="form-block">
        <?= $form->field($model, 'username')->textInput(['class' => 'login-input', 'required'=>'required','placeholder'=>'Имя пользователя (не менее 3-х символов)'])->label(false); ?>
        </div>
        <div class="form-block">
        <?= $form->field($model, 'email')->textInput(['class' => 'login-input', 'required'=>'required','placeholder'=>'E-mail'])->label(false);?>
        </div>
        <div class="form-block">
        <?= $form->field($model, 'password')->passwordInput(['class' => 'login-input', 'required'=>'required','placeholder'=>'Пароль (не менее 4-х символов)'])->label(false);?>
        </div>
        <div class="form-block">
        <?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'login-input', 'required'=>'required','placeholder'=>'Повторите пароль'])->label(false);?>
        </div>
        <div class="hint form-block">
            <p>
                Нажимая кнопку "Зарегистрироваться", Вы принимаете условия <a href="/oferta">пользовательского соглашения</a>
            </p>
        </div>
         <div class="form-button form-block">
             <button type="submit" class="custom-button"
                     name="login-button">Зарегистрироваться</button>
         </div>

             <?php ActiveForm::end(); ?>
    </div>
    <div class="footer">
         <h3>Или войдите через социальные сети</h3>

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
     </div>
</div>