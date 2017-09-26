<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\models\AppData;

$this->title = Yii::t('app', 'Reset password');
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
            $this->title
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->

<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <div class="b-contacts__form">
                    <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                        <h2 class="s-titleDet"><?= Html::encode($this->title) ?></h2>
                    </header>
                    <p class=" wow zoomInUp" data-wow-delay="0.5s">
                        <?= Yii::t('app', 'Please choose your new password')?>:
                    </p>
                    <div id="success"></div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'reset-password-form',
                        'options' => [
                            'class' => 's-form wow zoomInUp',
                            'data-wow-delay' => '0.5s',
                        ]
                    ]); ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group">
                        <button type="submit" class="btn m-btn" name="login-button"><?= Yii::t('app', 'Save') ?><span class="fa fa-angle-right"></span></button>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section><!--b-contacts-->
