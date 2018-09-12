<?
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductMake;
use frontend\models\ProductSearchForm;

$productModel = new Product();
$searchForm = new ProductSearchForm();
$total = Product::find()->where(['type' => '2'])->andWhere('[[product.status]]=1')->count();

$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'method' => 'get',
    'options' => ['class' => 'search-form'],
    'id' => 'search_form_main',
    'errorCssClass' => 'is-invalid',
    'fieldConfig' => [
        'template' => "{input}\n{label}\n{error}",
    ]
]);

?>
    <div class="form-block">
        <div class="row mb-2">
            <div class="col-lg-12">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[type]',
                        $searchForm->type,
                        ProductType::getTypesAsArray(ProductType::BOAT)
                    ) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="form-block">
        <div class="row">
            <div class="col-12 col-md-6 pr-md-1 mb-2">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[make]',
                        $searchForm->make,
                        ProductMake::getMakesList(),
                        ['prompt' => "Марка"]
                    ) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-12 col-md-6 pl-md-1 mb-2">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[model]',
                        $searchForm->model,
                        ProductMake::getMakesList(),
                        ['prompt' => "Модель"]
                    ) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="form-block">
        <div class="row">
            <div class="col-12 col-md-6 pr-md-1 mb-2">
                <div class="select-search-block">
                    <p class="dropdown-custom-toggle">Год</p>
                    <div class="dropdown-custom">
                        <div class="select-search-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[yearFrom]',
                                $searchForm->yearFrom,
                                Product::getYearsList(),
                                ['prompt' => 'От']) ?>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="select-search-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[yearTo]',
                                $searchForm->yearTo,
                                Product::getYearsList(),
                                ['prompt' => "До"]) ?>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-12 col-md-6 pl-md-1 mb-2">
                <div class="select-search-block">
                    <p class="dropdown-custom-toggle">Цена</p>
                    <div class="dropdown-custom">
                        <div class="select-search-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[priceFrom]',
                                $searchForm->priceFrom,
                                ProductSearchForm::getPricesList(),
                                ['prompt' => 'От']) ?>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="select-search-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[priceTo]',
                                $searchForm->priceTo,
                                ProductSearchForm::getPricesList(),
                                ['prompt' => "До"]) ?>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
    <p class="count-search text-center"><span id="count"><?= $total ?></span> объявлений</p>
    <div class="search-submit text-center">
        <button class="custom-button" type="submit"  id="search"><i class="fas fa-search mr-2"></i>Найти</button>
    </div>
<?php ActiveForm::end(); ?>
