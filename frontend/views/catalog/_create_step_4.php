<?php
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $userModel User */
/* @var $formWidget yii\widgets\ActiveForm */
/* @var $model common\models\Product */

$formWidget->validationUrl = Url::to(['catalog/validate-seller', 'id' => $model->id])
?>

<div class="row">
    <header class="s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h2 class=""><?= Yii::t('app', 'Contact details for ads') ?></h2>
    </header>
    <div class="col-md-6 col-xs-12">
        <?= $formWidget->field($model, "first_name", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->textInput(['maxlength' => true, 'class' => '', 'required' => true])->label('Имя <span class="text-danger">*</span>') ?>
        <div class="b-submit__main-element wow zoomInUp field-user-last_name required" data-wow-delay="0.5s">
            <label class="control-label" for="user-phone"><?= $model->getAttributeLabel('region') ?> <span
                        class="text-danger">*</span></label>
            <div class='s-relative'>
                <?= Html::activeDropDownList(
                    $model,
                    'region',
                    User::getRegions(),
                    ['class' => 'm-select']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-7">
                <?= $formWidget->field($model, "phone", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                    ->textInput(['maxlength' => true, 'class' => '', 'required' => true])->label($model->getAttributeLabel('phone') . '<span class="text-danger">*</span>') ?>
            </div>
            <div class="col-xs-5">
                <label class="control-label" for="user-phone"><?= $model->getAttributeLabel('phone_provider') ?> <span
                            class="text-danger">*</span></label>
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
                <?= $formWidget->field($model, "phone_2", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                    ->textInput(['maxlength' => true, 'class' => '', 'required' => false])->label($model->getAttributeLabel('phone_2')) ?>
            </div>
            <div class="col-xs-5">
                <label class="control-label"
                       for="user-phone"><?= $model->getAttributeLabel('phone_provider_2') ?></label>
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
    </div>
</div>
