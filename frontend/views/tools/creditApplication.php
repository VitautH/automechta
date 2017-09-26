<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\models\CreditApplication;
use common\widgets\Alert;

$this->title = Yii::t('app', 'Credit application');

$this->registerJs("require(['controllers/tools/creditApplication']);", \yii\web\View::POS_HEAD);

$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
$model->term = '60m';
$model->loans_payment = '0';
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


<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?= Alert::widget() ?>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'credit-application-form',
                'fieldConfig' => [
                    'options' => [
                        'class' => '',
                    ]
                ],
                'options' => [
                    'class' => 's-submit wow zoomInUp',
                    'data-wow-delay' => '0.5s',
                ]
            ]); ?>
            <div class="col-xs-12">
                <div class="b-contacts__form">
                    <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                        <h2 class="s-titleDet"><?= Yii::t('app', 'Online credit application') ?></h2>
                    </header>
                    <div id="success"></div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'name', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('name') . ' <span class="text-danger">*</span>')?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'firstname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('firstname') . ' <span class="text-danger">*</span>')?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'lastname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('lastname'))?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'phone', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('phone') . ' <span class="text-danger">*</span>')?>
                        <?= $form->field($model, "sex", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getSexList(), ['class' => 'm-select'])->label($model->getAttributeLabel('sex') . ' <span class="text-danger">*</span>')?>
                        <?= $form->field($model, "previous_conviction", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getConvictionList(), ['class' => 'm-select'])->label($model->getAttributeLabel('previous_conviction') . ' <span class="text-danger">*</span>')?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'dob', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('dob') . ' <span class="text-danger">*</span>')?>
                        <?= $form->field($model, "family_status", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getFamilyStatueList(), ['class' => 'm-select'])->label($model->getAttributeLabel('family_status') . ' <span class="text-danger">*</span>')?>
                        <?= $form->field($model, "information_on_income", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getInformationOnIncomeList(), ['class' => 'm-select'])->label($model->getAttributeLabel('information_on_income') . ' <span class="text-danger">*</span>')?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'job', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('job') . ' <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'experience', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('experience') . ' <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'salary', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('salary') . ' <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'loans_payment', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('loans_payment') . ' <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'product', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('product') . ' <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'credit_amount', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => ''])->label($model->getAttributeLabel('credit_amount') . ' <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, "term", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getTermList(), ['class' => 'm-select'])->label($model->getAttributeLabel('term') . ' <span class="text-danger">*</span>')?>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn m-btn" name="contact-button"><?= Yii::t('app', 'Submit') ?><span class="fa fa-angle-right"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section><!--b-contacts-->
