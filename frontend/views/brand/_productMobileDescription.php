<?php
use yii\helpers\Html;
?>
<?= $model->year ?>,
<?php foreach ($productSpecificationsMain as $productSpec): ?>
    <?php $spec = $productSpec->getSpecification()->one(); ?>
 <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>,
<?php endforeach; ?>