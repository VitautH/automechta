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
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= $this->title ?></h1>
    </div>
</section><!--b-pageHeader-->

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ЛК</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/account/bookmarks">Закладки</a></li>
                <li><a href="/account/index">Мои объявления</a></li>
                <li class="active"><a href="#">Настройки<span class="sr-only">(current)</span></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <?php
            $status = AuthAssignment::find()->select('item_name')->where(['user_id' => $model->id])->one();

            if ($status->item_name == 'RegisteredUnconfirmed'):
                ?>
                <div class="alert alert-danger col-md-12" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    НА ВАШ E-MAIL ОТПРАВЛЕНО ПИСЬМО С ССЫЛКОЙ ДЛЯ ПОДТВЕРЖДЕНИЯ РЕГИСТРАЦИИ
                    <br> Пожалуйста, активируйте регистрацию, перейдя по ссылке в письме, отправленном на ваш e-mail

                </div>
            <?php
            endif;
            ?>
            <div class="col-xs-6">
                <?= Alert::widget() ?>
                <div class="b-contacts__form">
                    <header class="b-contacts__form-header s-lineDownLeft">
                        <h2 class="s-titleDet">Аватарка</h2>
                    </header>
                    <div class="row">
                        <?= Html::activeHiddenInput($model, 'id') ?>
                        <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
                            <div class="js-dropzone"
                                 data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>">
                                <div class="dz-default dz-message"><span class="upload btn m-btn">Выбрать фотографию</span> <span
                                        class="drop">или перетащите изображения для загрзуки сюда</span></div>
                            </div>
                            <div class="hint-upload-photo">
                                Допускается загрузка 1 фотографии в формате JPG и PNG размером не более 8 МБ.
                                <br>
                                Мы не рекомендуем Вам использовать фотошоп, рекламу и чужие
                                фотографии.
                                <br>
                            </div>
                        </div>
                    </div>
                    <div id="success"></div>
                    <?php $formWidget = ActiveForm::begin([
                        'id' => 'account-form',
                        'options' => [
                            'class' => 's-form wow zoomInUp',
                            'data-wow-delay' => '0.5s',
                        ]
                    ]); ?>
                    <?= $formWidget->field($model, "username", ['options' => ['class' => 'b-submit__main-element']])
                        ->textInput(['maxlength' => true, 'class' => '']) ?>
                    <?= $formWidget->field($model, "email", ['options' => ['class' => 'b-submit__main-element']])
                        ->textInput(['maxlength' => true, 'class' => '']) ?>
                    <?= $formWidget->field($model, "password_raw", ['options' => ['class' => 'b-submit__main-element']])
                        ->passwordInput(['maxlength' => true, 'class' => '']) ?>
                    <header class="b-contacts__form-header s-lineDownLeft">
                        <h2 class="s-titleDet"><?= Yii::t('app', 'User data') ?></h2>
                    </header>
                    <?= $formWidget->field($model, "first_name", ['options' => ['class' => 'b-submit__main-element']])
                        ->textInput(['maxlength' => true, 'class' => '']) ?>
                    <?= $formWidget->field($model, "last_name", ['options' => ['class' => 'b-submit__main-element']])
                        ->textInput(['maxlength' => true, 'class' => '']) ?>
                    <label class="control-label" for="user-phone"><?= $model->getAttributeLabel('region') ?></label>
                    <div class='s-relative'>
                        <?= Html::activeDropDownList(
                            $model,
                            'region',
                            User::getRegions(),
                            ['class' => 'm-select']) ?>
                        <span class="fa fa-caret-down"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <?= $formWidget->field($model, "phone", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => '']) ?>
                        </div>
                        <div class="col-xs-5">
                            <label class="control-label"
                                   for="user-phone"><?= $model->getAttributeLabel('phone_provider') ?></label>
                            <div class='s-relative'>
                                <?= Html::activeDropDownList(
                                    $model,
                                    'phone_provider',
                                    User::getPhoneProviders(),
                                    ['class' => 'm-select']) ?>
                                <span class="fa fa-caret-down"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <?= $formWidget->field($model, "phone_2", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => '']) ?>
                        </div>
                        <div class="col-xs-5">
                            <label class="control-label"
                                   for="user-phone"><?= $model->getAttributeLabel('phone_provider') ?></label>
                            <div class='s-relative'>
                                <?= Html::activeDropDownList(
                                    $model,
                                    'phone_provider_2',
                                    User::getPhoneProviders(),
                                    ['class' => 'm-select']) ?>
                                <span class="fa fa-caret-down"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn m-btn" name="contact-button"><?= Yii::t('app', 'Save') ?><span
                                class="fa fa-angle-right"></span></button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>