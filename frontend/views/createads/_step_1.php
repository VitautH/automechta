<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $formWidget = ActiveForm::begin([
        'id' => 'create_product_form',
        'action' =>'create-ads/save?id='.$model->id,
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['create-ads/validate']),
        'method' =>  'post',
        'options' => ['class' => 'create_ads clearfix','data-pjax' => true]
    ]); ?>
    <div class="col-md-12">
        <?= Html::activeHiddenInput($model, 'type') ?>
    </div>
    <div class="col-md-12">
        <div class="wow zoomInUp field-user-last_name required" data-wow-delay="0.5s">
            <label class="control-label" for="product-make"><?= $model->getAttributeLabel('make') ?> <span
                    class="text-danger">*</span></label>
            <div class='s-relative'>
                <?= Html::activeDropDownList(
                    $model,
                    'make',
                    ProductMake::getMakesList($model->type),
                    ['class' => 'm-select required-field', 'prompt' => 'Выбрать', 'required' => true]) ?>
                <span class="fa fa-caret-down"></span>
                <div class="hint-block">
                    Нет нужной марки или модели?<br>Обратитесь в техподдержку и мы оперативно ее добавим
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="wow zoomInUp field-user-last_name required" data-wow-delay="0.5s">
            <label class="control-label" for="product-model"><?= $model->getAttributeLabel('model') ?> <span
                    class="text-danger">*</span></label>
            <div class='s-relative'>
                <?= Html::activeDropDownList(
                    $model,
                    'model',
                    ProductMake::getModelsList($model->model),
                    ['class' => 'm-select required-field', 'prompt' => 'Выбрать', 'required' => true]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <?= $formWidget->field($model->i18n(), "[" . Yii::$app->language . "]title", ['options' => ['class' => 'input wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->textInput(['maxlength' => true, 'class' => '']) ?>
    </div>
    <div class="col-md-12 price-block">
        <div class="first-block">
            <?= $formWidget->field($model, "price", ['options' => ['class' => 'input  wow zoomInUp', 'data-wow-delay' => '0.5s', 'required' => true]])
                ->textInput(['maxlength' => true, 'class' => 'required-field', 'required' => true])->label($model->getAttributeLabel('price') . ' <span class="text-danger">*</span>') ?>
        </div>
        <div class="two-block">
            <?= Html::activeDropDownList(
                $model,
                'currency',
                Product::getCurrencies(),
                ['class' => 'm-select required-field', 'required' => true]) ?>
            <span class="fa fa-caret-down"></span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="wow zoomInUp field-user-last_name required" data-wow-delay="0.5s">
            <label class="control-label" for="product-year"><?= $model->getAttributeLabel('year') ?> <span
                    class="text-danger">*</span></label>
            <div class='s-relative'>
                <?= Html::activeDropDownList(
                    $model,
                    'year',
                    Product::getYearsList(),
                    ['class' => 'm-select required-field', 'prompt' => 'Выбрать', 'required' => true]) ?>
                <span class="fa fa-caret-down"></span>
            </div>
        </div>
    </div>

    <?php foreach ($productSpecificationsMainCols[0] as $productSpecification): ?>
        <?php
        $specification = $productSpecification->getSpecification()->one();
        ?>
        <div class="col-md-12">
            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
        </div>
    <?php endforeach ?>
    <?php foreach ($productSpecificationsMainCols[1] as $productSpecification): ?>
        <?php
        $specification = $productSpecification->getSpecification()->one();
        ?>
        <div class="col-md-12">
            <?= SpecificationForm::getControl($specification, $productSpecification, $formWidget) ?>
        </div>
    <?php endforeach ?>
    <div class="col-md-12">
        <?= $formWidget->field($model->i18n(), "[" . Yii::$app->language . "]seller_comments", ['options' => ['class' => ' wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->textarea(['row' => 4, 'class' => '']) ?>
    </div>
    <header class="col-xs-12 s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h4 class=""><?= Yii::t('app', 'Additional specifications') ?></h4>
    </header>
    <div class="col-md-12 main-element-checkbox">
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
    <div class="col-md-12 col-xs-6 col-sm-7">
        <div class="wow zoomInUp field-user-last_name" data-wow-delay="0.5s">
            <label class="control-label" for="product-exchange"><?= $model->getAttributeLabel('exchange') ?> <span
                    class="text-danger">*</span></label>
            <div id="product-exchange">
                <input type="radio" name="Product[exchange]" value="0" id="product-exchange_yes" checked=""> <label
                    for="product-exchange_yes"><span>Нет</span></label>
                <input type="radio" name="Product[exchange]" value="1" id="product-exchange_no"> <label
                    for="product-exchange_no"><span>Да</span></label>
            </div>

        </div>
    </div>
    <div class="col-md-12 col-xs-6 col-sm-7">
        <div class="wow zoomInUp field-user-last_name" data-wow-delay="0.5s">
            <label class="control-label" for="product-auction"><?= $model->getAttributeLabel('auction') ?> <span
                    class="text-danger">*</span></label>
            <div id="product-exchange">
                <input type="radio" name="Product[auction]" value="0" id="product-auction_yes" checked=""> <label
                    for="product-auction_yes"><span>Нет</span></label>
                <input type="radio" name="Product[auction]" value="1" id="product-auction_no"> <label
                    for="product-auction_no"><span>Да</span></label>
            </div>

        </div>
    </div>