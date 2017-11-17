<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductMake;
use frontend\models\ProductSearchForm;
use common\models\User;

$productModel = new Product();
$searchForm = new ProductSearchForm();
$searchForm->type = 2;

?>
<form class="js-catalog-search-form">
    <div class="b-items__aside-main-body">
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'VEHICLE TYPE') ?>:</label>
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[type]',
                    $searchForm->type,
                    ProductType::getTypesAsArray(),
                    ['class' => 'm-select'])
                ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[make]',
                    $searchForm->make,
                    ProductMake::getMakesList($searchForm->type),
                    ['class' => 'm-select', 'prompt' => 'Марка']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[model]',
                    $searchForm->model,
                    ProductMake::getModelsList($searchForm->make),
                    ['class' => 'm-select', 'prompt' => 'Модель']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'YEAR RANGE') ?>: </label>
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
        <div class="b-items__aside-main-body-item" style="float: left;">
            <label><?= Yii::t('app', 'PRICE') ?>: </label>
            <div class="two_blocks">
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
        <div class="b-items__aside-main-body-item js-vehicle-type-specs">
            <div class="b-items__aside-main-body-item js-vehicle-type-specs">
                <?php foreach($searchForm->getSpecificationModels() as $specification): ?>
                    <div class="b-items__aside-main-body-item">
                        <?= $searchForm->getSpecInput($specification) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <div class="b-items__aside-main-body-item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[published]',
                    $searchForm->published,
                    ProductSearchForm::getPublishedPeriods(),
                    ['class' => 'm-select', 'prompt' => 'За период']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[region]',
                    $searchForm->region,
                    User::getRegions(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Регион')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
    </div>
     <footer class="b-items__aside-main-footer">
        <button type="submit" class="btn m-btn">Найти <span class="js-main_search_prod_type"></span><span class="fa fa-angle-right"></span></button>
    </footer>
</form>
