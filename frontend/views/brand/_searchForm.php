<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductMake;
use frontend\models\ProductSearchForm;
use common\models\User;
use common\models\Specification;
$productModel = new Product();
$searchForm = new ProductSearchForm();
$specification = new Specification();
if($_params_['ProductSearchForm']['type'] == null){
    $searchForm->type = $_params_['type'];
}
else {
    $searchForm->type = $_params_['ProductSearchForm']['type'];
}
if($_params_['ProductSearchForm']['make'] !== null) {
    $searchForm->make = $_params_['ProductSearchForm']['make'];
}
if($_params_['ProductSearchForm']['model'] !== null) {
    $searchForm->model = $_params_['ProductSearchForm']['model'];
}
if($_params_['ProductSearchForm']['yearFrom'] !== null) {
    $searchForm->yearFrom = $_params_['ProductSearchForm']['yearFrom'];
}
if($_params_['ProductSearchForm']['yearTo'] !== null) {
    $searchForm->yearTo = $_params_['ProductSearchForm']['yearTo'];
}
if($_params_['ProductSearchForm']['priceFrom'] !== null) {
    $searchForm->priceFrom = $_params_['ProductSearchForm']['priceFrom'];
}
if($_params_['ProductSearchForm']['priceTo'] !== null) {
    $searchForm->priceTo = $_params_['ProductSearchForm']['priceTo'];
}
if($_params_['ProductSearchForm']['region'] !== null){
    $searchForm->region=$_params_['ProductSearchForm']['region'];
}
if($_params_['ProductSearchForm']['published'] !== null){
    $searchForm->published=$_params_['ProductSearchForm']['published'];
}

/* Cars additional specs */
if($_params_['ProductSearchForm']['specs'][13] !==null){
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_13 option[value=".$_params_['ProductSearchForm']['specs'][13]."]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if($_params_['ProductSearchForm']['specs'][12] !==null){
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_12 option[value=".$_params_['ProductSearchForm']['specs'][12]."]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if($_params_['ProductSearchForm']['specs'][10] !==null){
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_10 option[value=".$_params_['ProductSearchForm']['specs'][10]."]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}

/* Moto additional specs */
if($_params_['ProductSearchForm']['specs'][70] !==null){
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_70 option[value=".$_params_['ProductSearchForm']['specs'][70]."]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if($_params_['ProductSearchForm']['specs'][71] !==null){
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_71 option[value=".$_params_['ProductSearchForm']['specs'][71]."]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if($_params_['ProductSearchForm']['specs'][72] !==null){
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_72 option[value=".$_params_['ProductSearchForm']['specs'][72]."]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if($_params_['ProductSearchForm']['specs'][73] !==null){
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_73 option[value=".$_params_['ProductSearchForm']['specs'][73]."]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
?>
<form class="js-catalog-search-form">
    <input type="hidden"  name="ProductSearchForm[type]" value="<?= $searchForm->type?>">
        <div class="item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[make]',
                    $searchForm->make,
                    ProductMake::getMakesList($searchForm->type),
                    ['class' => 'm-select', 'prompt' => 'Марка']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[model]',
                    $searchForm->model,
                    ProductMake::getModelsList($searchForm->make),
                    ['class' => 'm-select', 'prompt' => 'Модель']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="item">
            <label class="two_blocks"><?= Yii::t('app', 'YEAR RANGE') ?>:</label>
            <div class="two_blocks">
                <?= Html::dropDownList(
                    'ProductSearchForm[yearFrom]',
                    $searchForm->yearFrom,
                    Product::getYearsList(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'От')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
            <div class="two_blocks">
                <?= Html::dropDownList(
                    'ProductSearchForm[yearTo]',
                    $searchForm->yearTo,
                    Product::getYearsList(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'До')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="item" style="float: left;">
            <label class="two_blocks"><?= Yii::t('app', 'PRICE') ?> USD:</label>
            <div class="two_blocks" style="margin-left: 8%;">
                <?= Html::dropDownList(
                    'ProductSearchForm[priceFrom]',
                    $searchForm->priceFrom,
                    ProductSearchForm::getPricesList(),
                    ['class' => 'm-select', 'prompt' => 'От']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
            <div class="two_blocks">
                <?= Html::dropDownList(
                    'ProductSearchForm[priceTo]',
                    $searchForm->priceTo,
                    ProductSearchForm::getPricesList(),
                    ['class' => 'm-select', 'prompt' => 'До']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="item js-vehicle-type-specs">
            <?php foreach($searchForm->getSpecificationModels() as $specification): ?>
                <div class="item">
                    <?= $searchForm->getSpecInput($specification) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[published]',
                    $searchForm->published,
                    ProductSearchForm::getPublishedPeriods(),
                    ['class' => 'm-select',
                        'prompt' =>'За период',
                        ]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[region]',
                    $searchForm->region,
                    User::getRegions(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Регион')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
    <footer class="b-items__aside-main-footer">
        <a class="btn m-btn"  id="search">Найдено: <span id="result"><?= $_params_["count"];?></span></a>
    </footer>
</form>