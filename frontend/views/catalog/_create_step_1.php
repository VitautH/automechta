<?php
use yii\helpers\Html;
use common\models\ProductType;
?>

<div class="row">
    <header class="s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h2 class=""><?= Yii::t('app', 'Select Your Vehicle Type') ?></h2>
    </header>
    <div class="col-md-6 col-xs-12">
        <div class="b-submit__main-element wow zoomInUp" data-wow-delay="0.5s">
            <label><?= Yii::t('app', 'Type') ?></label>
            <div class='s-relative'>
                <?= Html::dropDownList(
                    'Product[type]',
                    $model->type,
                    ProductType::getTypesAsArray(),
                    ['class' => 'm-select']) ?>
                <span class="fa fa-caret-down"></span>
            </div>
            <?= Html::activeHiddenInput($form, 'step', ['value' => '2'])?>
        </div>
    </div>
</div>
