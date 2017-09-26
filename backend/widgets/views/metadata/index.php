<?php
use yii\helpers\Html;
use common\models\MetaData;
/* @var $model yii\db\ActiveRecord */
/* @var $metadataModels common\models\MetaData[] */

$types = MetaData::getTypes();
?>

<h4 class="mdl-typography--title">
    <?= Yii::t('app', 'Meta data') ?>
</h4>
    <div class="mdl-textfield__error"></div>
<div>
    <?= Html::activeHiddenInput(current($metadataModels), 'linked_table', []) ?>
    <?= Html::activeHiddenInput(current($metadataModels), 'linked_id', []) ?>
    <?php foreach($metadataModels as $metadataModel): ?>
    <div class="mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label">
        <?= Html::activeTextInput($metadataModel->i18n($language), '[' . $metadataModel->type . ']['. $language . ']value', ['class' => 'mdl-textfield__input']) ?>
        <label class="mdl-textfield__label" for="page-alias"><?= $types[$metadataModel->type] ?></label>
    </div>
    <?php endforeach; ?>
</div>