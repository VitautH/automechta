<?php
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= Yii::t('app', 'Year') ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"> <?= $product->year ?></p>
    </div>
</div>
    <div class="row">
        <div class="col-xs-6">
            <h4 class="b-detail__main-aside-desc-title"><?= $product->spec[0]->name ?></h4>
        </div>
        <div class="col-xs-6">
            <p class="b-detail__main-aside-desc-value"><?= Html::encode($product->spec[0]->format) ?> <?= $product->spec[0]->unit ?></p>
        </div>
    </div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= $product->spec[2]->name ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= Html::encode($product->spec[2]->format) ?> <?= $product->spec[2]->unit ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= $product->spec[4]->name ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= Html::encode($product->spec[4]->format) ?> <?= $product->spec[4]->unit ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= $product->spec[6]->name ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= Html::encode($product->spec[6]->format) ?> <?= $product->spec[6]->unit ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= $product->spec[1]->name ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= Html::encode($product->spec[1]->format) ?> <?= $product->spec[1]->unit ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= $product->spec[3]->name ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= Html::encode($product->spec[3]->format) ?> <?= $product->spec[3]->unit ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <h4 class="b-detail__main-aside-desc-title"><?= $product->spec[5]->name ?></h4>
    </div>
    <div class="col-xs-6">
        <p class="b-detail__main-aside-desc-value"><?= Html::encode($product->spec[5]->format) ?> <?= $product->spec[5]->unit ?></p>
    </div>
</div>

