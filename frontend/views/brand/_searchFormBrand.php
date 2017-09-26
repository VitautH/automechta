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
$searchForm->type = $_params_['type'];
?>
<form class="js-catalog-search-form">
    <div class="b-items__aside-main-body">
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'VEHICLE TYPE') ?></label>
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[type]',
                    $searchForm->type,
                    ProductType::getTypeAsArray($searchForm->type),
                    ['class' => 'm-select'])
                ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'SELECT A MAKE') ?></label>
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[make]',
                    $searchForm->make,
                    ProductMake::getMakesList($searchForm->type),
                    ['class' => 'm-select', 'prompt' => 'Любая']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'SELECT A MODEL') ?></label>
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[model]',
                    $searchForm->model,
                    ProductMake::getModelsList($searchForm->make),
                    ['class' => 'm-select', 'prompt' => 'Любая']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'YEAR RANGE') ?></label>
            <label style="float:left; margin-top: 15px;"><?= Yii::t('app', 'From') ?>:</label>
            <div style="margin-left: 40px;">
                <?= Html::dropDownList(
                    'ProductSearchForm[yearFrom]',
                    $searchForm->yearFrom,
                    Product::getYearsList(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Any')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label style="float:left; margin-top: 15px;"><?= Yii::t('app', 'To') ?>:</label>
            <div style="margin-left: 40px;">
                <?= Html::dropDownList(
                    'ProductSearchForm[yearTo]',
                    $searchForm->yearTo,
                    Product::getYearsList(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Any')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'PRICE') ?></label>
            <label style="float:left; margin-top: 15px;"><?= Yii::t('app', 'From') ?>:</label>
            <div style="margin-left: 40px;">
                <?= Html::dropDownList(
                    'ProductSearchForm[priceFrom]',
                    $searchForm->priceFrom,
                    ProductSearchForm::getPricesList(),
                    ['class' => 'm-select', 'prompt' => 'Любая']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label style="float:left; margin-top: 15px;"><?= Yii::t('app', 'To') ?>:</label>
            <div style="margin-left: 40px;">
                <?= Html::dropDownList(
                    'ProductSearchForm[priceTo]',
                    $searchForm->priceTo,
                    ProductSearchForm::getPricesList(),
                    ['class' => 'm-select', 'prompt' => 'Любая']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item js-vehicle-type-specs">
            <?php foreach($searchForm->getSpecificationModels() as $specification): ?>
                <div class="b-items__aside-main-body-item">
                    <?= $searchForm->getSpecInput($specification) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'Published last') ?></label>
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[published]',
                    $searchForm->published,
                    ProductSearchForm::getPublishedPeriods(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Any')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
        <div class="b-items__aside-main-body-item">
            <label><?= Yii::t('app', 'Region') ?></label>
            <div>
                <?= Html::dropDownList(
                    'ProductSearchForm[region]',
                    $searchForm->region,
                    User::getRegions(),
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Any')]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
    </div>
     <footer class="b-items__aside-main-footer">
        <!--<a href="/catalog/index"><?= Yii::t('app', 'Advanced search') ?></a>-->
        <button type="submit" class="btn m-btn">Найти <span class="js-main_search_prod_type"></span><span class="fa fa-angle-right"></span></button>
    </footer>
</form>
