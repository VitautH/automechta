<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \common\models\LoginForm;
use yii\helpers\Url;

$model = new LoginForm();
Url::remember();
?>
<div class="modal-login-bookmarks">
    <div class="modal-login-bookmarks-table">
        <div class="modal-login-bookmarks-row">
            <div class="modal-login-bookmarks-cell">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="modal-title">Закладки</h2>
                        <button type="button" class="modal-close">
                            <i class="fa fa-close"></i></button>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <p class="info">Только зарегистрированные на сайте пользователи могут создавать закладки</p>
                        </div>
                        <div class="login-block">
                            <div class="row">
                                <div class="social_login">
                                    <a href="/site/auth?authclient=vkontakte" class="vk-login"><i class="fa fa-vk"
                                                                                                  aria-hidden="true"></i></a>
                                    <a href="/site/auth?authclient=facebook" class="fb-login"><i class="fa fa-facebook"
                                                                                                 aria-hidden="true"></i></a>
                                    <a href="/site/auth?authclient=google" class="google-login"><i
                                                class="fa fa-google-plus-official" aria-hidden="true"></i></a>
                                    <a href="/site/auth?authclient=yandex" class="ya-login"><span>Я</span></a>
                                    <a href="/site/auth?authclient=odnoklassniki" class="ok-login"><i
                                                class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div id="success"></div>
                            <div class="row">
                                <?php $form = ActiveForm::begin(
                                    [
                                        'id' => 'login-form',
                                        'action' => '/site/login',
                                        'options' => [
                                            'class' => 'login-form',
                                        ]
                                    ]
                                );
                                ?>

                                <?= $form->field($model, 'email')->textInput(['class' => 'login-input'])->label('Логин / E-mail') ?>

                                <?= $form->field($model, 'password')->passwordInput(['class' => 'login-input'])->label(true) ?>
                                <div class="form-group">
                                    <button type="submit" class="login-button btn m-btn m-btn-dark"
                                            name="login-button"><?= Yii::t('app', 'Login') ?><span
                                                class="fa fa-angle-right"></span></button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="remember-block">
                                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                                    <a href="/site/request-password-reset" class="reset-password">Восстановить
                                        пароль</a>

                                    <?php ActiveForm::end(); ?>
                                    <span>Первый раз на сайте? <a href="/site/signup" class="registration">
                    <?= Yii::t('app', 'Register') ?>
                </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>