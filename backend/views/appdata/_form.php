<?php
/* @var $this yii\web\view */
/* @var $models common\models\AppData[] */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\AppData;

$languageDependentModels = array_filter($models, function ($val) {
    return AppData::$fields[$val->data_key]['i18n'];
});
$languageIndependentModels = array_filter($models, function ($val) {
    return !AppData::$fields[$val->data_key]['i18n'];
});
?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'id' => 'appdata-form',
    'validationUrl' => Url::to(['appdata/validate']),
    'options' => ['class' => "mdl-grid mdl-form"],
    'errorCssClass' => 'is-invalid',
    'fieldConfig' => [
        'template' => "{input}\n{label}\n{error}",
        'options' => ['class' => 'mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label'],
        'labelOptions' => ['class' => 'mdl-textfield__label'],
        'errorOptions' => ['class' => 'mdl-textfield__error'],
        'inputOptions' => ['class' => 'mdl-textfield__input']
    ]
]);
?>
<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect js-i18n-tabs">
        <div class="mdl-tabs__tab-bar <?php if(count(\Yii::$app->params['i18n']) === 1): ?>hidden<?php endif; ?>">
            <?php foreach(\Yii::$app->params['i18n'] as $key => $language): ?>
                <a href="#i18n-panel-<?= $key ?>" class="mdl-tabs__tab <?php if($key === \Yii::$app->language): ?>is-active<?php endif; ?>">
                    <?= $language['label'] ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php foreach(\Yii::$app->params['i18n'] as $key => $language): ?>
            <div class="mdl-tabs__panel <?php if($key === \Yii::$app->language): ?>is-active<?php endif; ?>" id="i18n-panel-<?= $key ?>">
                <?php foreach($languageDependentModels as $languageModel): ?>
                    <?php
                        $filedConf = AppData::$fields[$languageModel->data_key];
                        $options = isset($filedConf['options']) ? $filedConf['options'] : [];
                    ?>
                    <?php if ($filedConf['widget'] === 'input'): ?>
                        <?= $form->field($languageModel->i18n($key), "[{$languageModel->data_key}][{$key}]data_val")->textInput($options)
                            ->label(Yii::t('app', $filedConf['label'])) ?>
                    <?php elseif ($filedConf['widget'] === 'textarea'): ?>
                        <?= $form->field($languageModel->i18n($key), "[{$languageModel->data_key}][{$key}]data_val")->textarea($options)
                            ->label(Yii::t('app', $filedConf['label'])) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?php foreach($languageIndependentModels as $model): ?>
        <?php $filedConf = AppData::$fields[$model->data_key]; ?>
        <?php if ($filedConf['widget'] === 'input'): ?>
            <?= $form->field($model, "[{$model->data_key}]data_val")->textInput()
                ->label(Yii::t('app', $filedConf['label'])) ?>
        <?php elseif ($filedConf['widget'] === 'textarea'): ?>
            <?= $form->field($model, "[{$model->data_key}]data_val")->textarea([])
                ->label(Yii::t('app', $filedConf['label'])) ?>
        <?php elseif ($filedConf['widget'] === 'upload' && isset($filedConf['upload_id'])): ?>
            <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
                <label class="mdl-textfield__label"><?= Yii::t('app', $filedConf['label']) ?></label>
                <div class="js-dropzone" data-upload-id="<?= $filedConf['upload_id'] ?>" data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsData('app_data', $filedConf['upload_id'])), ENT_QUOTES, 'UTF-8') ?>"></div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' => $model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update')
    ])
?>
<?php ActiveForm::end(); ?>
