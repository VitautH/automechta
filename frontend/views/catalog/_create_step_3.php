<?php
use yii\helpers\Html;
?>

<div class="row">
    <header class="s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h2 class=""><?= Yii::t('app', 'Upload Photos') ?></h2>
    </header>
    <?= Html::activeHiddenInput($form, 'submitted', ['value' => '1'])?>
    <?= Html::activeHiddenInput($model, 'id')?>
    <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
        <div class="js-dropzone" data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
</div>
