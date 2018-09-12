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
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Сброс пароля</span></li>
        </ul>
    </div>
</div>

<div class="reset-password-page">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4 offset-lg-4">
                <div class="b-contacts__form">
                    <div class="header">
                        <h3><?= Html::encode($this->title) ?></h3>
                    </div>
                    <p class="">
                        <?= Yii::t('app', 'Please choose your new password')?>:
                    </p>
                    <div id="success"></div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'reset-password-form',
                        'options' => [
                        ]
                    ]); ?>

                    <?= $form->field($model, 'password')->passwordInput()->label(false) ?>

                    <div class="form-group">
                        <button type="submit" class="custom-button" name="login-button"><?= Yii::t('app', 'Save') ?><i class="ml-2 fas fa-angle-right"></i></button>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div><!--b-contacts-->
