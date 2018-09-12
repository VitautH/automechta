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
$searchForm->type = 2;

?>
<form class="search-form form-filter">
    <h2>Фильтр</h2>
    <div class="form-block">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12 col-9">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[make]',
                        $searchForm->make,
                        ProductMake::getMakesList($searchForm->type),
                        ['class' => 'm-select', 'prompt' => 'Марка']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="disabled select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[model]',
                        $searchForm->model,
                        ProductMake::getModelsList($searchForm->make),
                        ['class' => 'm-select', 'disabled'=>true, 'prompt' => 'Модель']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <label>Год выпуска</label>
            <div class="col-lg-6 pr-lg-0 col-4 pl-0 pr-0">
                <div class="first-block  select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[yearFrom]',
                        $searchForm->yearFrom,
                        Product::getYearsList(),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'От')]) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-lg-6 pl-lg-0 col-4 pr-0 pl-0">
                <div class="second-block select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[yearTo]',
                        $searchForm->yearTo,
                        Product::getYearsList(),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'До')]) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <label>Цена, USD</label>
            <div class="col-lg-6 pr-lg-0 col-4 pl-0 pr-0">
                <div class="first-block select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[priceFrom]',
                        $searchForm->priceFrom,
                        ProductSearchForm::getPricesList(),
                        ['class' => 'm-select', 'prompt' => 'От']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-lg-6 pl-lg-0 col-4 pr-0 pl-0">
                <div class="second-block select-search-block">
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
                    <div class="col-lg-12 col-9">
                        <div class="select-search-block">
                            <?= $searchForm->getSpecInput($specification) ?>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                <?php
                endif;
                $i++;
            endforeach; ?>
            <div class="col-lg-12 col-9">
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

    <div class="search-submit text-center">
        <button class="col-9 col-lg-12 custom-button" id="search" type="submit"><i class="fas fa-search mr-2"></i>
            Показать:   <span id="result"><?= $_params_["count"]; ?></span>
        </button>
    </div>

</form>
