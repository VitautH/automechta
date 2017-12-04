<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\models\AppData;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>
<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            Yii::t('app', 'Signup')
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>Регистрация</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-5 col-md-offset-4 col-xs-offset-0 col-sm-offset-0">
                <div class="b-contacts__form">
                    <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                        <h2 class="s-titleDet" style="text-align: center;">Регистрация</h2>
                    </header>
                    <p class=" wow zoomInUp" data-wow-delay="0.5s">
                        Пожалуйста, заполните форму регистрации или войдите через социальные сети!
                    </p>
                    <div class="social_login">
                        <a href="/site/auth?authclient=vkontakte" class="vk-login"><i class="fa fa-vk" aria-hidden="true"></i></a>
                        <a href="/site/auth?authclient=facebook" class="fb-login"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="/site/auth?authclient=google" class="google-login"><i class="fa fa-google-plus-official" aria-hidden="true"></i></a>
                        <a href="/site/auth?authclient=yandex" class="ya-login"><span>Я</span></a>
                    </div>
                    <div id="success"></div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-signup',
                        'options' => [
                            'class' => 's-form wow zoomInUp',
                            'data-wow-delay' => '0.5s',
                        ]
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput(['class' => '']) ?>

                    <?= $form->field($model, 'email')->textInput(['class' => '']) ?>

                    <?= $form->field($model, 'password')->passwordInput(['class' => '']) ?>

                    <div class="form-group">
                        <button type="submit" class="btn m-btn" name="signup-button"><?= Yii::t('app', 'Signup') ?><span class="fa fa-angle-right"></span></button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>
    </div>
</section><!--b-contacts-->