<?php
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $userModel User */
/* @var $formWidget yii\widgets\ActiveForm */
/* @var $model common\models\Product */

$formWidget->validationUrl = Url::to(['catalog/validate-seller', 'id' => $userModel->id])
?>

<div class="row">
    <header class="s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h2 class=""><?= Yii::t('app', 'Contact details for ads') ?></h2>
    </header>
    <div class="col-md-6 col-xs-12">
        <?= $formWidget->field($userModel, "first_name", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->textInput(['maxlength' => true, 'class' => '', 'required' =>true]) ?>
        <div class="b-submit__main-element wow zoomInUp field-user-last_name required" data-wow-delay="0.5s">
            <label class="control-label" for="user-phone"><?= $userModel->getAttributeLabel('region') ?></label>
            <div class='s-relative'>
            <?= Html::activeDropDownList(
                $userModel,
                'region',
                User::getRegions(),
                ['class' => 'm-select']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-7">
            <?= $formWidget->field($userModel, "phone", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                ->textInput(['maxlength' => true, 'class' => '', 'required' =>true])->label($userModel->getAttributeLabel('phone')) ?>
            </div>
            <div class="col-xs-5">
                <label class="control-label" for="user-phone"><?= $userModel->getAttributeLabel('phone_provider') ?></label>
                <div class='s-relative'>
                    <?= Html::activeDropDownList(
                        $userModel,
                        'phone_provider',
                        User::getPhoneProviders(),
                        ['class' => 'm-select']) ?>
                    <span class="fa fa-caret-down"></span>
                </div>
            </div>
        </div>
    </div>
</div>
