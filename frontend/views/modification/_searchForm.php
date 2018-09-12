<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AutoMakes;
use common\models\AutoRegions;
use common\models\AutoModels;
use common\models\AutoSearch;

$autoMakes = new AutoMakes();
$searchForm = new AutoSearch();

if ($_params_['AutoSearch']['region'] !== null) {
    $searchForm->region = $_params_['AutoSearch']['region'];
}
if ($_params_['AutoSearch']['make'] !== null) {
    $searchForm->make = $_params_['AutoSearch']['make'];
}
if ($_params_['AutoSearch']['model'] !== null) {
    $searchForm->model = $_params_['AutoSearch']['model'];
}
if ($_params_['AutoSearch']['yearFrom'] !== null) {
    $searchForm->yearFrom = $_params_['AutoSearch']['yearFrom'];
}
if ($_params_['AutoSearch']['yearTo'] !== null) {
    $searchForm->yearTo = $_params_['AutoSearch']['yearTo'];
}

$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'method' => 'get',
    'options' => ['class' => 'search-form form-filter'],
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

    <h2>Фильтр</h2>
    <div class="form-block">
        <div class="row">
            <div class="col-12">
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'AutoSearch[make]',
                        $searchForm->make,
                        AutoSearch::getMakes(),
                     ['prompt' => 'Марка']
                    ) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="select-search-block">
                    <?= Html::dropDownList(
                        'AutoSearch[model]',
                        $searchForm->model,
                        AutoSearch::getModels($searchForm->make),
                        ['prompt' => 'Модель']
                    ) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            <label>Год выпуска</label>
                <div class="row">
            <div class="col-6 pr-1">
                <div class="select-search-block">
                            <?= Html::dropDownList(
                                'AutoSearch[yearFrom]',
                                $searchForm->yearFrom,
                                AutoSearch::getYears()) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="select-search-block">
                            <?= Html::dropDownList(
                                'AutoSearch[yearTo]',
                                $searchForm->yearTo,
                                array_reverse(AutoSearch::getYears())) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
                </div>
            <div class="search-submit text-center">
                <button class="custom-button" id="search" type="submit"><i class="fas fa-search mr-2"></i>Найти
                </button>
            </div>
            <footer class="b-items__aside-main-footer">
                <span id="search-result"> <span id="result"><?= $_params_["total"]; ?></span> модификаций</span>
            </footer>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
