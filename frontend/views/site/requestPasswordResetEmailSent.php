<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
$appData = AppData::getData();

$this->title = 'Сбросить пароль';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= 'Сбросить пароль' ?></h1>
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
                        На ваш email отправлено письмо с инструкцией по сбросу пароля.
                    </p>
                    <p class=" wow zoomInUp" data-wow-delay="0.5s">
                        Для сброса пароля перейдите по ссылке в email.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section><!--b-contacts-->

