<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductMake;
use frontend\models\ProductSearchForm;
use common\models\City;
use common\models\Region;
use yii\helpers\ArrayHelper;
use common\models\Specification;

$productModel = new Product();
$searchForm = new ProductSearchForm();
$specification = new Specification();
if ($_params_['ProductSearchForm']['type'] == null) {
    $searchForm->type = $_params_['type'];
} else {
    $searchForm->type = $_params_['ProductSearchForm']['type'];
}
if ($_params_['ProductSearchForm']['make'] !== null) {
    $searchForm->make = $_params_['ProductSearchForm']['make'];
}
if ($_params_['ProductSearchForm']['model'] !== null) {
    $searchForm->model = $_params_['ProductSearchForm']['model'];
}
if ($_params_['ProductSearchForm']['yearFrom'] !== null) {
    $searchForm->yearFrom = $_params_['ProductSearchForm']['yearFrom'];
}
if ($_params_['ProductSearchForm']['yearTo'] !== null) {
    $searchForm->yearTo = $_params_['ProductSearchForm']['yearTo'];
}
if ($_params_['ProductSearchForm']['priceFrom'] !== null) {
    $searchForm->priceFrom = $_params_['ProductSearchForm']['priceFrom'];
}
if ($_params_['ProductSearchForm']['priceTo'] !== null) {
    $searchForm->priceTo = $_params_['ProductSearchForm']['priceTo'];
}
if ($_params_['ProductSearchForm']['region'] !== null) {
    $searchForm->region = $_params_['ProductSearchForm']['region'];
}
if ($_params_['ProductSearchForm']['city_id'] !== null) {
    $searchForm->city_id = $_params_['ProductSearchForm']['city_id'];
}
if ($_params_['ProductSearchForm']['published'] !== null) {
    $searchForm->published = $_params_['ProductSearchForm']['published'];
}

/* Cars additional specs */
if ($_params_['ProductSearchForm']['specs'][13] !== null) {
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_13 option[value=" . $_params_['ProductSearchForm']['specs'][13] . "]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if ($_params_['ProductSearchForm']['specs'][12] !== null) {
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_12 option[value=" . $_params_['ProductSearchForm']['specs'][12] . "]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if ($_params_['ProductSearchForm']['specs'][10] !== null) {
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_10 option[value=" . $_params_['ProductSearchForm']['specs'][10] . "]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}

/* Moto additional specs */
if ($_params_['ProductSearchForm']['specs'][70] !== null) {
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_70 option[value=" . $_params_['ProductSearchForm']['specs'][70] . "]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if ($_params_['ProductSearchForm']['specs'][71] !== null) {
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_71 option[value=" . $_params_['ProductSearchForm']['specs'][71] . "]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if ($_params_['ProductSearchForm']['specs'][72] !== null) {
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_72 option[value=" . $_params_['ProductSearchForm']['specs'][72] . "]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}
if ($_params_['ProductSearchForm']['specs'][73] !== null) {
    $this->registerJs("
$(document).ready(function(){
$('#productsearchform_spec_73 option[value=" . $_params_['ProductSearchForm']['specs'][73] . "]').attr('selected','selected');
});
", \yii\web\View::POS_HEAD);
}

if (!empty($_params_['ProductSearchForm']['makes'])) {
    $searchForm->make = $_params_['ProductSearchForm']['makes'];
}
if (!empty($_params_['ProductSearchForm']['model'])) {
    $searchForm->model = $_params_['ProductSearchForm']['model'];
}

if (!empty($_params_['model_name'])) {
    $searchForm->model = $_params_['model_name'];
}

?>
<form class="search-form form-filter">
    <h2>Фильтр</h2>
    <div class="form-block">
        <input type="hidden" name="ProductSearchForm[type]" value="<?= $searchForm->type ?>">
        <div class="row">
            <div class="col-12">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[make]',
                        $searchForm->make,
                        ProductMake::getMakesList($searchForm->type),
                        ['class' => 'm-select', 'prompt' => 'Марка']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[model]',
                        $searchForm->model,
                        ProductMake::getModelsList($searchForm->make),
                        ['class' => 'm-select', 'prompt' => 'Модель']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <label>Год выпуска</label>
            <div class="col-6 pr-1">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[yearFrom]',
                        $searchForm->yearFrom,
                        Product::getYearsList(),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'От')]) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[yearTo]',
                        $searchForm->yearTo,
                        Product::getYearsList(),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'До')]) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <label>Цена, USD</label>
            <div class="col-6 pr-1">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[priceFrom]',
                        $searchForm->priceFrom,
                        ProductSearchForm::getPricesList(),
                        ['class' => 'm-select', 'prompt' => 'От']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[priceTo]',
                        $searchForm->priceTo,
                        ProductSearchForm::getPricesList(),
                        ['class' => 'm-select', 'prompt' => 'До']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <?php
            $i = 0;
            foreach ($searchForm->getSpecificationModels() as $specification):
                if ($i != 0):
                    ?>
                    <div class="col-12">
                        <div class="select-search-block">
                            <?= $searchForm->getSpecInput($specification) ?>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                <?php
                endif;
                $i++;
            endforeach; ?>
            <div class="col-12">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[published]',
                        $searchForm->published,
                        ProductSearchForm::getPublishedPeriods(),
                        ['class' => 'm-select', 'prompt' => 'За период']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[region]',
                        $searchForm->region,
                        Region::getRegions(),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'Регион')]) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[city_id]',
                        $searchForm->city_id,
                        ArrayHelper::map(City::find()->where(['region' => $searchForm->region])->asArray()->orderBy('id')->all(), 'id', 'city_name'),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'Город')]) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

        </div>
    </div>

    <p class="clear-filter text-center"><input type="reset" value="Сбросить"></p>
    <div class="search-submit text-center">
        <button class="custom-button" id="search" type="submit"><i class="fas fa-search mr-2"></i>Найти
        </button>
    </div>
    <footer class="b-items__aside-main-footer">
        <span id="search-result">Найдено: <span id="result"><?= $_params_["count"]; ?></span></span>
    </footer>
</form>
