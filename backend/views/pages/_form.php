<?php
/* @var $this yii\web\view */
/* @var $model common\models\Page */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\MetaDataWidget;

?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'id' => 'page-form',
    'validationUrl' => Url::to(['pages/validate', 'id' => $model->id]),
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
<div class="mdl-cell mdl-cell--padding mdl-cell--8-col mdl-cell--12-col-tablet mdl-shadow--2dp">
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
                <?= $form->field($model->i18n($key), "[{$key}]header")->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->i18n($key), "[{$key}]description")->textarea(['rows' => 6]) ?>
                <?= $form->field($model->i18n($key), "[{$key}]content")->textarea(['rows' => 8, 'class'=>'js-wysiwyg wysiwyg']) ?>
                <?= MetaDataWidget::widget(['model' => $model, 'language' => $key]); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--4-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?= $form->field($model, 'id')->textInput(['name' => 'id', 'disabled' => 'disabled']) ?>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    <p style="margin-top:0;"><b>Url: </b><span class="js-alias"></span></p>
    <?= $form->field($model, 'status')->dropDownList($model::getStatuses(), []) ?>
    <?= $form->field($model, 'in_aside')->checkbox([
        'class' => 'mdl-checkbox__input',
        'labelOptions' => [
            'class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect',
        ]
    ]) ?>

    <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
        <label class="mdl-textfield__label"><?= Yii::t('app', 'Files') ?></label>
        <div class="js-dropzone" data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' => $model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update')
    ])
?>
<?php ActiveForm::end(); ?>
