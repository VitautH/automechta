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
$total = Product::find()->where(['type' => ProductType::MOTO])->andWhere('[[product.status]]=1')->count();

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
        <div class="row">
            <div class="col-lg-12">
                <ul role="tablist" class="tabslist">
                    <li class="tabsitem">
                        <a role="tab" class="product-type" aria-controls="bike" data-productType="<?php echo ProductType::MOTO;?>" href="#moto" title="Мотоциклы" tabindex="0" aria-selected="true">
                            <span class="category-img moto"></span>
                        </a>
                    </li>
                    <li class="tabsitem">
                        <a role="tab" class="product-type" aria-controls="atv" data-productType="<?php echo ProductType::ATV;?>" href="#atv" title="Квадроциклы" tabindex="0" aria-selected="false">
                            <span class="category-img kv-cycle"></span>
                        </a>
                    </li>
                    <li class="tabsitem">
                        <a role="tab" class="product-type" aria-controls="scooter" data-productType="<?php echo ProductType::SCOOTER;?>" href="#scooter" title="Скутеры" tabindex="0" aria-selected="false">
                            <span class="category-img scooter"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<input type="hidden" name="ProductSearchForm[type]" value="<?php echo ProductType::MOTO;?>">
    <div class="form-block">
        <div class="row">
            <div class="col-12 col-md-6 pr-md-1 mb-2">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'ProductSearchForm[make]',
                        $searchForm->make,
                        ProductMake::getMakesList(ProductType::MOTO),
                        ['prompt' => "Марка мотоцикла"]
                    ) ?>
                    <i class="fa fa-chevron-down"></i>
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
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="form-block">
        <div class="row">
            <div class="col-12 col-md-6 pr-md-1 mb-2">
                <div  class="select-search-block">
                    <p  id="year" class="dropdown-custom-toggle">Год</p>
                    <div id="year_form" class="dropdown-custom">
                        <div class="select-search-block left-select-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[yearFrom]',
                                $searchForm->yearFrom,
                                Product::getYearsList(),
                                ['prompt' => 'От']) ?>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="select-search-block right-select-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[yearTo]',
                                $searchForm->yearTo,
                                Product::getYearsList(),
                                ['prompt' => "До"]) ?>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-12 col-md-6 pl-md-1 mb-2">
                <div  class="select-search-block">
                    <p id="price" class="dropdown-custom-toggle">Цена</p>
                    <div id="price_form" class="dropdown-custom">
                        <div class="select-search-block left-select-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[priceFrom]',
                                $searchForm->priceFrom,
                                ProductSearchForm::getPricesList(),
                                ['prompt' => 'От']) ?>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="select-search-block right-select-block">
                            <?= Html::dropDownList(
                                'ProductSearchForm[priceTo]',
                                $searchForm->priceTo,
                                ProductSearchForm::getPricesList(),
                                ['prompt' => "До"]) ?>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
    <p class="count-search text-center"><span id="count"><?= $total ?></span> обявлений</p>
    <div class="search-submit text-center">
        <button class="custom-button w-100" type="submit"  id="search-motos"><i class="fa fa-search mr-2"></i>Найти</button>
    </div>
<?php ActiveForm::end(); ?>
