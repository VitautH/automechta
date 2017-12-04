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
<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            Yii::t('app', 'Log in')
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->

<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="b-contacts__form">
                    <p class=" wow zoomInUp" data-wow-delay="0.5s">
                        Чтобы войти на Automechta.by, пожалуйста, авторизуйтесь с вашим E-mail и паролем или войдите через соцсети.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-md-offset-3 col-sm-offset-0 col-xs-offset-0 col-sm-12 col-xs-12">
                    <div class="social_login">
                        <a href="/site/auth?authclient=vkontakte" class="vk-login"><i class="fa fa-vk" aria-hidden="true"></i></a>
                        <a href="/site/auth?authclient=facebook" class="fb-login"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="/site/auth?authclient=google" class="google-login"><i class="fa fa-google-plus-official" aria-hidden="true"></i></a>
                        <a href="/site/auth?authclient=yandex" class="ya-login"><span>Я</span></a>
                    </div>
                    <div id="success"></div>
                    <?php $form = ActiveForm::begin(
                        [
                            'id' => 'login-form',
                            'options' => [
                                'class' => 'login-form wow zoomInUp',
                                'data-wow-delay' => '0.5s',
                            ]
                        ]
                    );
                    ?>

                    <?= $form->field($model, 'username')->textInput(['class' => 'login-input col-xs-10 col-sm-5 col-md-5 col-xl-5'])->label(true) ?>

                    <?= $form->field($model, 'password')->passwordInput(['class' => 'login-input col-xs-10 col-sm-5 col-md-5 col-xl-5'])->label(true) ?>
                    <div class="form-group">
                        <button type="submit" class="login-button btn m-btn m-btn-dark" name="login-button"><?= Yii::t('app', 'Login') ?><span class="fa fa-angle-right"></span></button>
                    </div>
                        <div class="clearfix"></div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <a href="/site/request-password-reset" class="reset-password">Восстановить пароль</a>
                </div>
                    <?php ActiveForm::end(); ?>
               <span>Первый раз на сайте? <a href="/site/signup" class="registration">
                    <?= Yii::t('app', 'Register') ?>
                </a>
                   </span>
                </div>
            </div>

        </div>
    </div>
</section><!--b-contacts-->

