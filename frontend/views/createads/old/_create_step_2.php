<?php
/* @var $formWidget yii\widgets\ActiveForm */
/* @var $model common\models\Product */

/* @var $productSpecifications common\models\ProductSpecification[] */

use yii\helpers\Html;
use common\models\ProductMake;
use common\models\Product;
use common\models\Specification;
use frontend\models\SpecificationForm;
use common\models\User;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\Region;
use common\models\City;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

$productSpecificationsMainCols = [];
$productSpecificationsAdditionalCols = [];

$productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
    $specification = $productSpec->getSpecification()->one();
    return $specification->type != Specification::TYPE_BOOLEAN;
});
$productSpecificationsMain = array_values($productSpecificationsMain);


$productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
    $specification = $productSpec->getSpecification()->one();
    return $specification->type == Specification::TYPE_BOOLEAN;
});
$productSpecificationsAdditional = array_values($productSpecificationsAdditional);

$productSpecificationsAdditionalCols[0] = [];
$productSpecificationsAdditionalCols[1] = [];

foreach ($productSpecificationsMain as $key => $productSpecification) {
    $productSpecificationsMainCols[$key % 2][] = $productSpecification;
}
foreach ($productSpecificationsAdditional as $key => $productSpecification) {
    $productSpecificationsAdditionalCols[$key % 2][] = $productSpecification;
}

if (!isset($productSpecificationsMainCols[0])) {
    $productSpecificationsMainCols[0] = [];
}
if (!isset($productSpecificationsMainCols[1])) {
    $productSpecificationsMainCols[1] = [];
}

$this->registerJs("require(['controllers/catalog/create']);", \yii\web\View::POS_HEAD);
$this->registerCssFile("/css/create-ads-main.css");
?>
<script>
    $(document).ready(function () {

        $('.s-submitCheckLabel').click(function () {
            $('#rules').change(function () {
                var checked = $("#rules").is(":checked");
                if (checked) {
                    $('#button_publish').attr("disabled", false);
                }
                else {
                    $('#button_publish').attr("disabled", true);
                }
            });
        })
    });
</script>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>
                    Новое объявление
                </h3>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-1 hidden-mobile">
<div class="nav">
<div id="nav-step-1" class="step active">
    <span>1</span>
</div>

    <div class="vertical-line">
    </div>
    <div id="nav-step-2" class="step active">
        <span>2</span>
    </div>

    <div class="vertical-line">
    </div>
    <div id="nav-step-3" class="step">
        <span>3</span>
    </div>

    <div class="vertical-line">
    </div>
    <div id="nav-step-4" class="step">
        <span>4</span>
    </div>
</div>
            </div>
            <div class="col-lg-11 col-12">

                <div class="step-1">
                    <?php Pjax::begin(['enablePushState' => false, 'id' => 'form_step-1']); ?>
                    <?php $formWidget = ActiveForm::begin([
                        'id' => 'create_product_form',
                        'action' => 'create-ads/step1?id=' . $model->id,
                        'enableAjaxValidation' => true,
                        'validationUrl' => Url::to(['create-ads/validate']),
                        'method' => 'post',
                        'options' => ['class' => '', 'data-pjax' => true]
                    ]); ?>
                    <div class="col-lg-12">
                        <?= Html::activeHiddenInput($model, 'type') ?>
                    </div>
                    <div class="col-lg-12">

                        <div class="form-field row required">
                            <div class="col-lg-2">
                                <label class="control-label" for="product-make"><?= $model->getAttributeLabel('make') ?>
                                    <span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-5">
                                    <?= Html::activeDropDownList(
                                        $model,
                                        'make',
                                        ProductMake::getMakesList($model->type),
                                        ['class' => 'm-select required-field', 'prompt' => 'Выбрать', 'required' => true]) ?>
                            </div>
                            <div class="col-lg-5 hint-block">
                                Нет нужной марки или модели?<br>Обратитесь в техподдержку и мы оперативно ее добавим
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-field row required">
                            <div class="col-lg-2">
                                <label class="control-label"
                                       for="product-model"><?= $model->getAttributeLabel('model') ?> <span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-5">
                                    <?= Html::activeDropDownList(
                                        $model,
                                        'model',
                                        ProductMake::getModelsList($model->model),
                                        ['class' => 'm-select required-field', 'prompt' => 'Выбрать', 'required' => true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-field row">
                            <div class="col-lg-2">
                                <label class="control-label">Версия/модификация</label>
                            </div>
                            <div class="col-lg-5">
                                <?= $formWidget->field($model->i18n(), "[" . Yii::$app->language . "]title", ['options' => ['class' => 'input wow zoomInUp', 'data-wow-delay' => '0.5s']])
                                    ->textInput(['maxlength' => true, 'class' => ''])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-field row">
                            <div class="col-lg-2">
                                <label class="control-label"
                                       for="product-model"><?= $model->getAttributeLabel('price') ?> <span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-3 col-8">
                                <?= $formWidget->field($model, "price", ['options' => ['class' => 'input', 'required' => true]])
                                    ->textInput(['maxlength' => true, 'class' => 'required-field', 'required' => true])->label(false) ?>
                            </div>
                            <div class="col-lg-2 col-4 no-padding-left">

                                    <?= Html::activeDropDownList(
                                        $model,
                                        'currency',
                                        Product::getCurrencies(),
                                        ['class' => 'm-select required-field', 'required' => true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-field row required">
                            <div class="col-lg-2">
                                <label class="control-label" for="product-year"><?= $model->getAttributeLabel('year') ?>
                                    <span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-5">
                                    <?= Html::activeDropDownList(
                                        $model,
                                        'year',
                                        Product::getYearsList(),
                                        ['class' => 'm-select required-field', 'prompt' => 'Выбрать', 'required' => true]) ?>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($productSpecificationsMainCols[0] as $productSpecification): ?>
                        <?php
                        $specification = $productSpecification->getSpecification()->one();
                        ?>
                        <div class="col-lg-12">
                            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
                        </div>
                    <?php endforeach ?>
                    <?php foreach ($productSpecificationsMainCols[1] as $productSpecification): ?>
                        <?php
                        $specification = $productSpecification->getSpecification()->one();
                        ?>
                        <div class="col-lg-12">
                            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
                        </div>
                    <?php endforeach ?>
                    <div class="col-lg-12">
                        <div class="form-field row">
                            <div class="col-lg-2">
                                <label class="control-label">
                                    Комментарий продавца
                                </label>
                            </div>
                            <div class="col-lg-5">
                                <?= $formWidget->field($model->i18n(), "[" . Yii::$app->language . "]seller_comments", ['options' => []])
                                    ->textarea(['row' => 4, 'class' => ''])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="header col-lg-12">
                        <h4 class=""><?= Yii::t('app', 'Additional specifications') ?></h4>
                    </div>
                    <div class="create_ads">
                        <div class="row">
                            <div class="col-lg-12 main-element-checkbox">
                                <?php foreach ($productSpecificationsAdditionalCols[0] as $productSpecification): ?>
                                    <?php
                                    $specification = $productSpecification->getSpecification()->one();
                                    ?>
                                    <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
                                <?php endforeach ?>
                                <?php foreach ($productSpecificationsAdditionalCols[1] as $productSpecification): ?>
                                    <?php
                                    $specification = $productSpecification->getSpecification()->one();
                                    ?>
                                    <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="row exchange-auction-row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="control-label"
                                               for="product-exchange"><?= $model->getAttributeLabel('exchange') ?> <span
                                                    class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row justify-content-center">
                                            <div id="product-exchange">
                                                <input type="radio" name="Product[exchange]" value="0"
                                                       id="product-exchange_yes" checked=""> <label
                                                        for="product-exchange_yes"><span>Нет</span></label>
                                                <input type="radio" name="Product[exchange]" value="1"
                                                       id="product-exchange_no"> <label
                                                        for="product-exchange_no"><span>Да</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row exchange-auction-row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="control-label"
                                               for="product-auction"><?= $model->getAttributeLabel('auction') ?> <span
                                                    class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row justify-content-center">
                                            <div id="product-exchange">
                                                <input type="radio" name="Product[auction]" value="0" id="product-auction_no" checked=""> <label for="product-auction_no"><span>Нет</span></label>
                                                <input type="radio" name="Product[auction]" value="1" id="product-auction_yes"> <label for="product-auction_yes"><span>Да</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-11">
                        <div class="form-proceed create_ads">
                            <div class="row justify-content-center">
                                <?= Html::submitButton('Продолжить <i class="ml-2 fas fa-arrow-down"></i>', ['class' => 'custom-button js-show-form-step', 'id' => 'to-step-2']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <?php Pjax::end(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="step-2">
        <?php Pjax::begin(['enablePushState' => false, 'id' => 'form_step-2']); ?>
        <?php $formWidget = ActiveForm::begin([
            'id' => 'create_product_form',
            'action' => 'create-ads/step2?id=' . $model->id,
            'enableAjaxValidation' => true,
            'validationUrl' => Url::to(['create-ads/validate']),
            'method' => 'post',
            'options' => ['class' => '', 'data-pjax' => true]
        ]); ?>
        <div class="photo-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-11 col-12 offset-md-1">
                        <div class="header s-headerSubmit s-headerSubmit s-lineDownLeft">
                            <h4 class="">Фотографии для объявления</h4>
                        </div>
                        <?= Html::activeHiddenInput($form, 'submitted', ['value' => '1']) ?>
                        <?= Html::activeHiddenInput($model, 'id') ?>
                        <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
                            <div class="js-dropzone"
                                 data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>">
                                <div class="dz-default dz-message">
                                    <div class="row">
                                        <span
                                            class="upload custom-button col-12 col-lg-3"> <i class="mr-2 fas fa-camera"></i> Выбрать фотографии</span>
                                    </div>
                                    <div class="row">
                                    <div class="hint-upload-photo">
                                        Допускается загрузка не более 20 фотографий в формате JPG и PNG размером не
                                        более 8
                                        МБ. <br>Фотография
                                        помеченная
                                        как "главная", будет отображенна первой. <br>Мы не рекомендуем Вам использовать
                                        фотошоп, рекламу и
                                        чужие
                                        фотографии.
                                    </div>
                                    <div
                                            class="drop"><span>или перетащите изображения для загрзуки сюда</span></div>
                                </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="offset-lg-1 col-lg-11 col-12">
                    <div class="header hint-video"><h4> Видеоролик с вашей техникой</h4></div>
                </div>
            </div>
                    <div class="row field-block">
                        <div class="col-lg-2 offset-lg-1">
                            <label class="control-label">
                                Ссылка  видео на YouTube
                            </label>
                        </div>
                        <div class="col-lg-5">
                            <?= $formWidget->field($model, "video", ['options' => ['class' => 'input']])
                                ->textInput(['maxlength' => true, 'class' => '', 'required' => false])->label(false) ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-12 offset-lg-1">
                    <div class="form-proceed create_ads">
                        <div class="row justify-content-center">
                            <?= Html::submitButton('Продолжить <i class="ml-2 fas fa-arrow-down"></i>', ['class' => 'custom-button js-show-form-step', 'id' => 'to-step-3']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <?php Pjax::end(); ?>
                    </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-12 offset-lg-1">
                <div class="step-3">
                    <?php
                    $formWidget = ActiveForm::begin([
                        'id' => 'create_product_form',
                        'action' => 'create-ads/save?id=' . $model->id,
                        'enableAjaxValidation' => true,
                        'validationUrl' => Url::to(['create-ads/validate']),
                        'method' => 'post',
                        'options' => ['class' => ''],
                    ]); ?>
                    <div class="header">
                        <h4 class=""><?= Yii::t('app', 'Contact details for ads') ?></h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-field row required">
                                <div class="col-lg-2">
                                    <label class="control-label">Имя <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-lg-5">
                                    <?= $formWidget->field($model, "first_name", ['options' => ['class' => 'input wow zoomInUp', 'data-wow-delay' => '0.5s']])
                                        ->textInput(['maxlength' => true, 'class' => 'input required', 'required' => true])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-field row required">
                                <div class="col-lg-2">
                                    <label class="control-label">Область <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-lg-5">
                                        <?= Html::activeDropDownList(
                                            $model,
                                            'region',
                                            Region::getRegions(),
                                            ['id' => 'region', 'class' => 'required', 'prompt' => 'Выбрать', 'required' => true]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-field row required">
                                <div class="col-lg-2">
                                    <label class="control-label"><?= $model->getAttributeLabel('city_id') ?> <span
                                                class="text-danger">*</span></label>
                                </div>
                                <div class="col-lg-5">

                                        <?= Html::activeDropDownList(
                                            $model,
                                            'city_id',
                                            ArrayHelper::map(City::find()->where(['region' => 1])->asArray()->orderBy('id')->all(), 'id', 'city_name'),
                                            ['id' => 'city', 'class' => 'required', 'prompt' => 'Выберите область', 'required' => true]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-field row required">
                                <div class="col-lg-2">
                                    <label class="control-label">
                                        <?php
                                        echo $model->getAttributeLabel('phone'); ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-3 col-8">
                                    <?= $formWidget->field($model, "phone", ['options' => ['class' => 'input b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                                        ->textInput(['maxlength' => true, 'class' => 'input required', 'required' => true])->label(false) ?>
                                </div>
                                <div class="col-lg-2 col-4 no-padding-left ">
                                        <?= Html::activeDropDownList(
                                            $model,
                                            'phone_provider',
                                            User::getPhoneProviders(),
                                            ['class' => 'required']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-field row">
                                <div class="col-lg-2">
                                    <label class="control-label">
                                        <?php
                                        echo $model->getAttributeLabel('phone_2'); ?>
                                    </label>
                                    <div class="hidden-mobile add_phone-block">Добавить ещё</div>
                                </div>
                                <div class="col-lg-3 col-8">
                                    <?= $formWidget->field($model, "phone_2", ['options' => ['class' => 'input b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                                        ->textInput(['maxlength' => true, 'class' => 'input'])->label(false) ?>
                                </div>
                                <div class="col-lg-2 col-4 no-padding-left">
                                        <?= Html::activeDropDownList(
                                            $model,
                                            'phone_provider_2',
                                            User::getPhoneProviders()) ?>
                                </div>
                                <div class="col-12 hidden-desktop add_phone-block">Добавить ещё</div>
                            </div>
                        </div>
                    </div>
                    <div id="contact-information-block-3" class="row">
                        <div class="col-lg-12">
                            <div class="form-field row">
                                <div class="col-lg-2">
                                    <label class="control-label">
                                        <?php
                                        echo $model->getAttributeLabel('phone_3'); ?>
                                    </label>
                                </div>
                                <div class="col-lg-3">
                                    <?= $formWidget->field($model, "phone_3", ['options' => ['class' => 'input b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                                        ->textInput(['maxlength' => true, 'class' => 'input '])->label(false) ?>
                                </div>
                                <div class="col-lg-2 col-4 no-padding-left">
                                        <?= Html::activeDropDownList(
                                            $model,
                                            'phone_provider_3',
                                            User::getPhoneProviders()) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="publishing create_ads">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-element-checkbox rules-checkbox">
                                    <div class="b-submit__main-element b-submit__main-element-checkbox  agree ">
                                        <input type="hidden" name="rules" value="0"><input type="checkbox"
                                                                                           id="rules" name="rules"
                                                                                           value="0"
                                                                                           aria-invalid="false"
                                                                                           required>
                                        <label class="s-submitCheckLabel" for="rules"><i
                                                    class="fas fa-check"></i></label>
                                        <div class="rules-link">Я согласен с <a class="color-red" href="/oferta">правилами</a>
                                            портала
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" id="button_publish" class="offset-lg-2 custom-button" disabled="disabled">
                                    Опубликовать <span class="ml-2 fas fa-angle-right"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
