<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\models\AppData;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Войти</span></li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="header">
        <div class="row">
            <div class="col-12">
                <h3>
                    Чтобы войти на Automechta.by, пожалуйста, авторизуйтесь с вашим Логином или E-mail и паролем </h3>
                <span>или войдите через соцсети.</span>

            </div>
        </div>
        <div class="row">
            <div id="success"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-5 offset-lg-4">
            <div class="login-block">


                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'login-form',
                        'enableAjaxValidation' => true,
                        
                        'options' => [
                            'class' => 'login-form',
                        ]
                    ]
                );
                ?>

                <div class="form-field row">
                    <div class="col-lg-4">
                        <label class="control-label">
Логин / E-mail
                        </label>
                    </div>
                        <div class="col-12 col-lg-8">
                    <?= $form->field($model, 'email')->textInput(['class' => 'login-input'])->label(false) ?>
                    </div>
                </div>

                <div class="form-field row">
                    <div class="col-lg-4">
                        <label class="control-label">
Пароль
                        </label>
                    </div>
                    <div class="col-12 col-lg-8">
                    <?= $form->field($model, 'password')->passwordInput(['class' => 'login-input'])->label(false) ?>
                </div>
                </div>
                <div class="remember-form-block form-block">
                    <div class="form-group field-loginform-rememberme">
                        <div class="checkbox">
                            <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        </div>
                    </div>
                    <a href="#" class="reset-password">Забыли пароль ?</a>
                </div>
                <div class="form-button form-block">
                    <button type="submit" class="custom-button" name="login-button"><?= Yii::t('app', 'Login') ?><i
                                class="ml-2 fas fa-angle-right"></i></button>
                </div>
                <?php ActiveForm::end(); ?>
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
                    <span class="register-title">Впервые на сайте? </span>
                    <a href="#" class="registration show-modal-registration-login-block custom-button">
                        Регистрация </a>
                </div>
            </div>
        </div>
    </div>
</div>


