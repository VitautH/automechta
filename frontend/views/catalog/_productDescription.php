<?php
use yii\helpers\Html;
?>
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