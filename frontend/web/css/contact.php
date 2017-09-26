<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\widgets\Alert;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= $this->title ?></h1>
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

<div class="b-map wow zoomInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomInUp;">
    <?= $appData['map'] ?>
</div>

<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?= Alert::widget() ?>
            </div>
            <div class="col-xs-6">
                <div class="b-contacts__address">
                    <div class="b-contacts__address-hours">
                        <h2 class="s-titleDet wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'opening hours') ?></h2>
                        <div class="b-contacts__address-hours-main wow zoomInUp" data-wow-delay="0.5s">
                            <div class="row">
                                <?= $appData['openingHours'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="b-contacts__address-info">
                        <h2 class="s-titleDet wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'Contact Information') ?></h2>
                        <address class="b-contacts__address-info-main wow zoomInUp" data-wow-delay="0.5s">
                            <div class="b-contacts__address-info-main-item">
                                <span class="fa fa-credit-card"></span>
                                <?= Yii::t('app', 'Legal address') ?>
                                <p><?= $appData['contacts'] ?></p>
                            </div>
                            <div class="b-contacts__address-info-main-item">
                                <span class="fa fa-home"></span>
                                <?= Yii::t('app', 'Adress') ?>
                                <p><?= $appData['address'] ?></p>
                            </div>
                            <div class="b-contacts__address-info-main-item">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-12">
                                        <span class="fa fa-phone"></span>
                                        <?= Yii::t('app', 'Phone') ?>
                                    </div>
                                    <div class="col-lg-9 col-md-8 col-xs-12">
                                        <em><a href="tel:<?= $appData['phone'] ?>" class="inheritColor"><?= $appData['phone'] ?></a></em><br>
                                        <em><a href="tel:<?= $appData['phone_2'] ?>" class="inheritColor"><?= $appData['phone_2'] ?></a></em><br>
                                        <em><a href="tel:<?= $appData['phone_3'] ?>" class="inheritColor"><?= $appData['phone_3'] ?></a></em>
                                    </div>
                                </div>
                            </div>
                            <div class="b-contacts__address-info-main-item">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-12">
                                        <span class="fa fa-fax"></span>
                                        <?= Yii::t('app', 'FAX') ?>
                                    </div>
                                    <div class="col-lg-9 col-md-8 col-xs-12">
                                        <em><?= $appData['fax'] ?></em>
                                    </div>
                                </div>
                            </div>
                            <div class="b-contacts__address-info-main-item">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-12">
                                        <span class="fa fa-envelope"></span>
                                        <?= Yii::t('app', 'Email') ?>
                                    </div>
                                    <div class="col-lg-9 col-md-8 col-xs-12">
                                        <em><a href="mailto:<?= $appData['email'] ?>" class="inheritColor"><?= $appData['email'] ?></a></em>
                                    </div>
                                </div>
                            </div>
                        </address>
                    </div>
                </div>
            </div>
            <section class="b-best">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="b-best__info">
                                <header class="s-lineDownLeft b-best__info-head">
                                    <h2 class="wow zoomInUp" data-wow-delay="0.5s"><?= $appData['aboutUsHeader'] ?></h2>
                                </header>
                                <p class="wow zoomInUp" data-wow-delay="0.5s"><?= $appData['aboutUs'] ?></p>
                            </div>
                        </div>
<!--                        <div class="col-sm-6 col-xs-12">-->
<!--                            --><?php //if($appData['aboutUsPhoto']): ?>
<!--                                <img class="img-responsive center-block wow zoomInUp" data-wow-delay="0.5s" alt="best" src="--><?//= $appData['aboutUsPhoto']->getThumbnail(555, 336, 'inset') ?><!--" />-->
<!--                            --><?php //endif; ?>
<!--                        </div>-->
                    </div>
                </div>
            </section><!--b-best-->
<!--            <div class="col-xs-6">-->
<!--                <div class="b-contacts__form">-->
<!--                    <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">-->
<!--                        <h2 class="s-titleDet">--><?//= Yii::t('app', 'Contact Form') ?><!--</h2>-->
<!--                    </header>-->
<!--                    <div id="success"></div>-->
<!--                    --><?php //$form = ActiveForm::begin([
//                        'id' => 'contact-form',
//                        'fieldConfig' => [
//                            'options' => [
//                                'class' => '',
//                            ]
//                        ],
//                        'options' => [
//                            'class' => 's-submit wow zoomInUp',
//                            'data-wow-delay' => '0.5s',
//                        ]
//                    ]); ?>
<!--                    --><?//= $form->field($model, 'name', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])
//                        ->label($model->getAttributeLabel('name') . ' <span class="text-danger">*</span>') ?>
<!--                    --><?//= $form->field($model, 'email', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])
//                        ->label($model->getAttributeLabel('email') . ' <span class="text-danger">*</span>') ?>
<!--                    --><?//= $form->field($model, 'subject', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])
//                        ->label($model->getAttributeLabel('subject') . ' <span class="text-danger">*</span>') ?>
<!--                    --><?//= $form->field($model, 'body', ['options' => ['class' => 'b-submit__main-element']])->textArea(['rows' => 6, 'class' => ''])
//                        ->label($model->getAttributeLabel('body') . ' <span class="text-danger">*</span>') ?>
<!--                    --><?//= $form->field($model, 'verifyCode', ['options' => ['class' => 'b-submit__main-element']])->widget(Captcha::className(), [
//                        'options' => ['class' => ''],
//                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
//                    ])->label($model->getAttributeLabel('verifyCode') . ' <span class="text-danger">*</span>') ?>
<!--                    <div class="form-group">-->
<!--                        <button type="submit" class="btn m-btn" name="contact-button">--><?//= Yii::t('app', 'Submit') ?><!--<span class="fa fa-angle-right"></span></button>-->
<!--                    </div>-->
<!--                    --><?php //ActiveForm::end(); ?>
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</section><!--b-contacts-->
