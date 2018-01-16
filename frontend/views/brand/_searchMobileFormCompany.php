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

$productModel = new Product();
$searchForm = new ProductSearchForm();
$searchForm->type = 2;

?>
<form class="js-catalog-search-form js-catalog-search-form-mobile">
       <input type="hidden"  name="ProductSearchForm[type]" value="2">
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
            <label class="two_blocks"><?= Yii::t('app', 'YEAR RANGE') ?>: </label>
            <div class="two_blocks" style="margin-left: 3px;">
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
        <div class="item">
            <label class="two_blocks"><?= Yii::t('app', 'PRICE') ?> USD: </label>
            <div class="two_blocks" style="margin-left: 23px;">
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
                    ['class' => 'm-select', 'prompt' => 'За период']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
            <div class="item">
                <div>
                    <?= Html::dropDownList(
                        'ProductSearchForm[region]',
                        $searchForm->region,
                        Region::getRegions(),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'Регион')]) ?>
                    <span class="fa fa-caret-down"></span>
                </div>
            </div>
            <div class="item">
                <div>
                    <?= Html::dropDownList(
                        'ProductSearchForm[city_id]',
                        $searchForm->city_id,
                        ArrayHelper::map(City::find()->where(['region' => $searchForm->region])->asArray()->orderBy('id')->all(), 'id', 'city_name'),
                        ['class' => 'm-select', 'prompt' => Yii::t('app', 'Город')]) ?>
                    <span class="fa fa-caret-down"></span>
                </div>
            </div>
     <footer class="b-items__aside-main-footer">
         <a class="btn m-btn"  id="search_mobile">Найдено: <span id="result_mobile"><?= $_params_['count'];?></span></a>
     </footer>
</form>