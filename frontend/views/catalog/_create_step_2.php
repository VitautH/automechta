<?php
/* @var $formWidget yii\widgets\ActiveForm */
/* @var $model common\models\Product */
/* @var $productSpecifications common\models\ProductSpecification[] */

use yii\helpers\Html;
use common\models\ProductMake;
use common\models\Product;
use common\models\Specification;
use frontend\models\SpecificationForm;

$productSpecificationsMainCols = [];
$productSpecificationsAdditionalCols = [];

$productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
    $specification = $productSpec->getSpecification()->one();
    return $specification->type != Specification::TYPE_BOOLEAN;
});
$productSpecificationsMain = array_values($productSpecificationsMain);


$productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
    $specification = $productSpec->getSpecification()->one();
    return $specification->type == Specification::TYPE_BOOLEAN;
});
$productSpecificationsAdditional = array_values($productSpecificationsAdditional);

$productSpecificationsAdditionalCols[0] = [];
$productSpecificationsAdditionalCols[1] = [];

foreach ($productSpecificationsMain as $key => $productSpecification) {
    $productSpecificationsMainCols[$key % 2][] = $productSpecification;
}
foreach ($productSpecificationsAdditional as $key => $productSpecification) {
    $productSpecificationsAdditionalCols[$key % 2][] = $productSpecification;
}

if(!isset($productSpecificationsMainCols[0])) {
    $productSpecificationsMainCols[0] = [];
}
if(!isset($productSpecificationsMainCols[1])) {
    $productSpecificationsMainCols[1] = [];
}

?>


<div class="row">
    <header class="s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h2 class=""><?= Yii::t('app', 'Add Your Vehicle Details') ?></h2>
    </header>
    <div class="col-xs-12">
        <div class="hint-block">Уважаемый пользователь, обращаем ваше внимание, если вы декларируете стоимость своего товара на сайте automechta.by в денежных единицах как доллар, его цена будет отображаться в белорусских рублях с привязкой к текущему курсу НБ РБ.</div>
    </div>
    <br>
    <br>
    <br>
    <div class="col-md-6 col-xs-12">
        <?= Html::activeHiddenInput($model, 'type') ?>
        <?= Html::activeHiddenInput($form, 'step', ['value' => '3'])?>
        <?= $formWidget->field($model, "make", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
        ->dropDownList(ProductMake::getMakesList($model->type), ['class' => 'm-select', 'prompt' => '---', 'required' =>true])->label($model->getAttributeLabel('make') . ' <span class="text-danger">*</span>')?>
    </div>
    <div class="col-md-6 col-xs-12">
        <?= $formWidget->field($model, "model", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->dropDownList(ProductMake::getModelsList($model->model), ['class' => 'm-select', 'prompt' => '---', 'required' =>true])->label($model->getAttributeLabel('model') . ' <span class="text-danger">*</span>')?>
    </div>
    <div class="col-md-12 col-xs-12">
        <?= $formWidget->field($model->i18n(), "[" . Yii::$app->language . "]title", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->textInput(['maxlength' => true, 'class' => '']) ?>
    </div>
    <div class="col-md-6 col-xs-12 price-col">
        <?= $formWidget->field($model, "price", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s', 'required' =>true]])
            ->textInput(['maxlength' => true, 'class' => '', 'required' =>true])->label($model->getAttributeLabel('price') . ' <span class="text-danger">*</span>') ?>
        <?= $formWidget->field($model, "currency", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s', 'required' =>true]])
            ->dropDownList(Product::getCurrencies(), ['class' => 'm-select', 'required' =>true])->label($model->getAttributeLabel('currency') . ' <span class="text-danger">*</span>') ?>
    </div>
    <div class="col-md-6 col-xs-12">
        <?= $formWidget->field($model, "year", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s', 'required' =>true]])
            ->dropDownList(Product::getYearsList(), ['class' => 'm-select', 'prompt' => '---', 'required' =>true])->label($model->getAttributeLabel('year') . ' <span class="text-danger">*</span>') ?>
    </div>
    <div class="col-md-6 col-xs-12">
        <?php foreach ($productSpecificationsMainCols[0] as $productSpecification): ?>
            <?php
            $specification = $productSpecification->getSpecification()->one();
            ?>
            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
        <?php endforeach ?>
    </div>
    <div class="col-md-6 col-xs-12">
        <?php foreach ($productSpecificationsMainCols[1] as $productSpecification): ?>
            <?php
            $specification = $productSpecification->getSpecification()->one();
            ?>
            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
        <?php endforeach ?>
    </div>
    <header class="col-xs-12 s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h4 class=""><?= Yii::t('app', 'Additional specifications') ?></h4>
    </header>
    <div class="col-md-6 col-xs-12">
        <?php foreach ($productSpecificationsAdditionalCols[0] as $productSpecification): ?>
            <?php
            $specification = $productSpecification->getSpecification()->one();
            ?>
            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
        <?php endforeach ?>
    </div>
    <div class="col-md-6 col-xs-12">
        <?php foreach ($productSpecificationsAdditionalCols[1] as $productSpecification): ?>
            <?php
            $specification = $productSpecification->getSpecification()->one();
            ?>
            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
        <?php endforeach ?>
    </div>
    <div class="col-md-12 col-xs-12">
        <?= $formWidget->field($model->i18n(), "[" . Yii::$app->language . "]seller_comments", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->textarea(['row' => 4, 'class'=>'']) ?>
    </div>
    <div class="col-md-12 col-xs-12">
        <?=
        $formWidget->field($model, "exchange", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->dropDownList([
                0 => Yii::t('app', 'No'),
                1 => Yii::t('app', 'Yes'),
            ], ['class' => 'm-select']) ?>
    </div>
    <div class="col-md-12 col-xs-12">
        <?=
        $formWidget->field($model, "auction", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->dropDownList([
                0 => Yii::t('app', 'No'),
                1 => Yii::t('app', 'Yes'),
            ], ['class' => 'm-select']) ?>
    </div>
</div>
