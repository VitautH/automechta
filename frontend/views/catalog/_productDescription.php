<?php
use yii\helpers\Html;
//var_dump($product->year);
?>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= Yii::t('app', 'Year') ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"> <?= $product->year ?></p>
    </div>
</div>
<?php foreach ($product->spec as $spec): ?>
    <div class="row">
        <div class="col-xs-6">
            <h4 class="b-detail__main-aside-desc-title"><?= $spec->name ?></h4>
        </div>
        <div class="col-xs-6">
            <p class="b-detail__main-aside-desc-value"><?= Html::encode($spec->format) ?> <?= $spec->unit ?></p>
        </div>
    </div>
<?php endforeach; ?>