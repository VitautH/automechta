<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductMake;
use frontend\models\ProductSearchForm;

$productModel = new Product();
$searchForm = new ProductSearchForm();

?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'action' => Url::to(['brand/search']),
    'method' => 'get',
    'options' => ['class' => 'b-search__main'],
    'id' => 'search_form_main',
    'errorCssClass' => 'is-invalid',
    'fieldConfig' => [
        'template' => "{input}\n{label}\n{error}",
        'options' => ['class' => 'mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label'],
        'labelOptions' => ['class' => 'mdl-textfield__label'],
        'errorOptions' => ['class' => 'mdl-textfield__error'],
        'inputOptions' => ['class' => 'mdl-textfield__input'],
    ]
]);


?>
    <div class="b-search__main-title wow zoomInUp" data-wow-delay="0.3s">
        <h2><?= mb_strtoupper(Yii::t('app', 'Search')) ?></h2>
    </div>
    <div class="b-search__main-form wow zoomInUp" data-wow-delay="0.3s">
        <div class="row">
            <div class="col-xs-12 col-md-2">
                <div>
                    <div class="b-search__main-form__select">
                        <?= Html::dropDownList(
                            'ProductSearchForm[type]',
                            $searchForm->type,
                            ProductType::getTypesAsArray()
                        ) ?>
                        <span class="fa fa-caret-down"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div>
                    <div class="b-search__main-form__select">
                        <?= Html::dropDownList(
                            'ProductSearchForm[make]',
                           $searchForm->make,
                            ProductMake::getMakesList(),
                            ['prompt' => Yii::t('app', 'Make')]
                        ) ?>
                        <span class="fa fa-caret-down"></span>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-md-3">
                <div>
                    <div class="b-search__main-form__select">
                        <?= Html::dropDownList(
                            'ProductSearchForm[model]',
                            $searchForm->model,
                            ProductMake::getMakesList(),
                            ['prompt' => Yii::t('app', 'SELECT A MODEL')]) ?>
                        <span class="fa fa-caret-down"></span>
                    </div>
                </div>

            </div>
            <div class="col-md-2 col-xs-12 ">
                <div>
                    <div class="dropdown" id="year">
                        Год выпуска:
                        <span class="fa fa-caret-down"></span>
                    </div>
                    <div class="ui flowing download basic popup  center transition" id="year_form" style="">
                        <div class="ui divided equal width relaxed center aligned choice grid" style="">
                            <div class="column">
                                <?= Html::dropDownList(
                                                                  'ProductSearchForm[yearFrom]',
                                                                  $searchForm->yearFrom,
                                                                  Product::getYearsList(),
                                                                  ['prompt' => 'От']) ?>
                                                              <span class="fa fa-caret-down"></span>
                            </div>
                            <div class="column">
                                <?= Html::dropDownList(
                                                                    'ProductSearchForm[yearTo]',
                                                                    $searchForm->yearTo,
                                                                    Product::getYearsList(),
                                                                    ['prompt' => "До"]) ?>
                                                                <span class="fa fa-caret-down"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 ">

                <div>
                    <div class="dropdown" id="price">
                        Цена:
                        <span class="fa fa-caret-down"></span>
                    </div>
                    <div class="ui flowing download basic popup  center transition" id="price_form"  style="">
                        <div class="ui divided equal width relaxed center aligned choice grid" style="">
                            <div class="column">
                                <?= Html::dropDownList(
                                    'ProductSearchForm[priceFrom]',
                                    $searchForm->priceFrom,
                                    ProductSearchForm::getPricesList(),
                                    ['prompt' => 'От']) ?>
                                <span class="fa fa-caret-down"></span>
                            </div>
                            <div class="column">
                                <?= Html::dropDownList(
                                    'ProductSearchForm[priceTo]',
                                    $searchForm->priceTo,
                                    ProductSearchForm::getPricesList(),
                                    ['prompt' => "До"]) ?>
                                <span class="fa fa-caret-down"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="b-search__main-form-submit">
                    <!--<a href="/catalog/index"><?= Yii::t('app', 'Advanced search') ?></a>-->
                    <button type="submit" class="btn m-btn">Найти <span class="js-main_search_prod_type"></span><span class="fa fa-angle-right"></span></button>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
