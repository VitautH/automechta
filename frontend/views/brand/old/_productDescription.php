<?php
use yii\helpers\Html;
?>

<h2 class="s-titleDet"><?= Yii::t('app', 'Description') ?></h2>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= Yii::t('app', 'Make') ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= $model->getMake0()->one()->name ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= Yii::t('app', 'Model') ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= $model->model ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= $model->i18n()->getAttributeLabel('title') ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= $model->i18n()->title ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= Yii::t('app', 'Year') ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"> <?= $model->year ?></p>
    </div>
</div>
<?php foreach ($productSpecificationsMain as $productSpec): ?>
    <?php $spec = $productSpec->getSpecification()->one(); ?>
    <div class="row">
        <div class="col-xs-6">
            <h4 class="b-detail__main-aside-desc-title"><?= $spec->i18n()->name ?></h4>
        </div>
        <div class="col-xs-6">
            <p class="b-detail__main-aside-desc-value"><?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?></p>
        </div>
    </div>
<?php endforeach; ?>