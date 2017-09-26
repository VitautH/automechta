<?php
/* @var $this yii\web\View */
/* @var $types array */

use yii\helpers\Html;

?>
<div>
    <form class="mdl-grid mdl-form" action="/product/create" method="get">
        <div class="mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label field-product-type">
            <?= Html::dropDownList('Product[type]', null, $types, [
                'class' => 'mdl-textfield__input'
            ]) ?>
            <label class="mdl-textfield__label" for="product-type"><?= Yii::t('app', 'Type') ?></label>
        </div>
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            <?= Yii::t('app', 'Create') ?>
        </button>
    </form>
</div>
