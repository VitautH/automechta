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
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= Yii::t('app', 'Log in') ?></h1>
    </div>
</section><!--b-pageHeader-->

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
                    <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                        <h2 class="s-titleDet"><?= Html::encode($this->title) ?></h2>
                    </header>
                    <p class=" wow zoomInUp" data-wow-delay="0.5s">
                        <?= Yii::t('app', 'Please fill out the following fields to login')?>:
                    </p>
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

                    <?= $form->field($model, 'username')->textInput(['class' => 'login-input col-xs-10 col-sm-2 col-md-2 col-xl-2'])->label(false) ?>

                    <?= $form->field($model, 'password')->passwordInput(['class' => 'login-input col-xs-10 col-sm-2 col-md-2 col-xl-2'])->label(false) ?>

                    <div class="form-group">
                        <button type="submit" class="login-button btn m-btn" name="login-button"><?= Yii::t('app', 'Login') ?><span class="fa fa-angle-right"></span></button>
                        <a href="/site/auth?authclient=vkontakte" class="vk-login col-xs-10"><i class="fa fa-vk" aria-hidden="true"></i><?= Yii::t('app', 'Login_vk') ?></a>
                        <a href="/site/auth?authclient=facebook" class="fb-login col-xs-10"><i class="fa fa-facebook" aria-hidden="true"></i>Войти через Facebook</a>
                    </div>
                    <div class="clearfix"></div>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div style="color:#999;margin:1em 0">
                <?= Html::a(Yii::t('app', 'reset_password'), ['site/request-password-reset']) ?>.
                    </div>



                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-xs-6 wow zoomInUp" data-wow-delay="0.5s">
                <a href="/site/signup" class="btn m-btn m-btn-dark">
                    <?= Yii::t('app', 'Register') ?> <span class="fa fa-angle-right"></span>
                </a>
            </div>
        </div>
    </div>
</section><!--b-contacts-->

