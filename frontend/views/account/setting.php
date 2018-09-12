<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\Url as UrlProduct;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\models\Product;
use common\models\User;
use common\widgets\Alert;
use yii\grid\GridView;
use common\models\AuthAssignment;
use frontend\widgets\CustomPager;
use frontend\assets\AppAsset;

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
$this->registerJs("require(['controllers/account/index']);", \yii\web\View::POS_HEAD);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
<script src="/js/account-setting.js"></script>
<link type="text/css" rel="stylesheet" href="/css/account-style.css">
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Личный кабинет</span></li>
        </ul>
    </div>
</div>
<div class="container">
    <nav>
        <ul class="nav nav-tabs row left-content-between" id="myTab" role="tablist">
            <li class="nav-item col-lg-2 p-0">
                <a class="nav-link" href="/account/index">Мои объявления</a>
            </li>
            <li class="nav-item col-lg-2 p-0">
                <a class="nav-link" href="/account/bookmarks">Закладки</a>
            </li>
            <li class="nav-item col-lg-2 p-0">
                <a class="nav-link active" href="#">Настройки</a>
            </li>
        </ul>
    </nav>
</div>

<div class="container">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="row">
            <div class="col-12 col-lg-6 alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <span><?= Yii::$app->session->getFlash('success') ?></span>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <?php
        $status = AuthAssignment::find()->select('item_name')->where(['user_id' => $model->id])->one();

        if ($status->item_name == 'RegisteredUnconfirmed'):
            ?>
            <div class="alert alert-danger col-md-12" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Ошибка:</span>
                НА ВАШ E-MAIL ОТПРАВЛЕНО ПИСЬМО С ССЫЛКОЙ ДЛЯ ПОДТВЕРЖДЕНИЯ РЕГИСТРАЦИИ
                <br> Пожалуйста, активируйте регистрацию, перейдя по ссылке в письме, отправленном на ваш e-mail

            </div>
        <?php
        endif;
        ?>
    </div>
    <div class="row left-content-center mt-3">
        <?= Alert::widget() ?>
        <div class="col-12 col-lg-6">
            <?php $formWidget = ActiveForm::begin([
                'id' => 'account-form',
                'options' => [
                    'class' => 's-form wow zoomInUp',
                    'data-wow-delay' => '0.5s',
                ]
            ]); ?>
            <?= $formWidget->field($model, "username", ['template' => "{label}\n<div class='col-lg-8 col-12'>{input}</div>\n{hint}\n{error}",
                'options' => ['class' => 'form-group row'], 'labelOptions' => [ 'class' => 'col-lg-4 col-12 col-form-label' ]])
                ->textInput(['maxlength' => true, 'class' => 'form-control','readonly'=>'readonly']) ?>
            <?= $formWidget->field($model, "email", ['template' => "{label}\n<div class='col-lg-8'>{input}</div>\n{hint}\n{error}",
                'options' => ['class' => 'form-group row'], 'labelOptions' => [ 'class' => 'col-lg-4 col-12 col-form-label' ]])
                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
            <?= $formWidget->field($model, "password_raw", ['template' => "{label}\n<div class='col-lg-8 col-12'>{input}</div>\n{hint}\n{error}",
                'options' => ['class' => 'form-group row'], 'labelOptions' => [ 'class' => 'col-lg-4 col-12 col-form-label' ]])
                ->passwordInput(['maxlength' => true, 'class' => 'form-control']) ?>
            <?= $formWidget->field($model, "first_name", ['template' => "{label}\n<div class='col-lg-8 col-12'>{input}</div>\n{hint}\n{error}",
                'options' => ['class' => 'form-group row'], 'labelOptions' => [ 'class' => 'col-lg-4 col-12 col-form-label' ]])
                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
            <?= $formWidget->field($model, "last_name", ['template' => "{label}\n<div class='col-lg-8 col-12'>{input}</div>\n{hint}\n{error}",
                'options' => ['class' => 'form-group row'], 'labelOptions' => [ 'class' => 'col-lg-4 col-12 col-form-label' ]])
                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
            <div class="form-group row">
            <label class="col-lg-4 col-12 col-form-label" for="user-region"><?= $model->getAttributeLabel('region') ?></label>
            <div class='col-lg-8 col-12'>
                <div class="select-form">
                <?= Html::activeDropDownList(
                    $model,
                    'region',
                    User::getRegions(),
                    ['class' => 'form-control']) ?>
                <i class="fas fa-chevron-down"></i>
            </div>
            </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-12 col-form-label">
                Телефон
                </label>
                <div class="col-lg-4 col-12">
                    <?= Html::activeTextInput(
                        $model,
                        'phone',
                        ['class' => 'form-control']
                       ) ?>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="select-form">
                        <?= Html::activeDropDownList(
                            $model,
                            'phone_provider',
                            User::getPhoneProviders(),
                            ['class' => 'form-control']) ?>
                    <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                </div>
            <div class="form-group row">
                <label class="col-lg-4 col-12 col-form-label">
                   Доп. телефон
                </label>
                <div class="col-lg-4 col-12">
                    <?= Html::activeTextInput(
                        $model,
                        'phone_2',
                        ['class' => 'form-control']
                    ) ?>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="select-form">
                    <?= Html::activeDropDownList(
                        $model,
                        'phone_provider_2',
                        User::getPhoneProviders(),
                        ['class' => 'form-control']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-lg-4 col-12 h-100">
                <button type="submit" class="save" name="contact-button"><i
                            class="justify-content-center mr-3 fas fa-check"></i><?= Yii::t('app', 'Save') ?></button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>

        </div>