<?php
/* @var $this yii\web\view */
/* @var $model common\models\Specification */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Specification;

?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'id' => 'specification-form',
    'validationUrl' => Url::to(['specification/validate', 'id' => $model->id]),
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
                <?= $form->field($model->i18n($key), "[{$key}]name")->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->i18n($key), "[{$key}]unit")->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->i18n($key), "[{$key}]example")->textarea(['row' => 5]) ?>
                <?= $form->field($model->i18n($key), "[{$key}]comment")->textarea(['row' => 5]) ?>
                <div class="specification-values js-specification-values">
                    <?= Html::dropDownList(
                        "SpecificationI18n-{$key}-values",
                        $model->i18n($key)->getValuesArray(),
                        array_combine($model->i18n($key)->getValuesArray(), $model->i18n($key)->getValuesArray()),
                        ['class' => "js-select2-input select2-input", 'multiple' => 'multiple', 'options' => ['selected' => 'selected'] ])
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--4-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?= Html::activeHiddenInput($model, 'depth', ['value' => '1']) ?>
    <?= $form->field($model, 'id')->textInput(['name' => 'id', 'disabled' => 'disabled']) ?>
    <?= $form->field($model, 'type')->dropDownList(Specification::getTypes()) ?>
    <?= $form->field($model, "priority")->dropDownList(Specification::getPriorities()) ?>
    <?= $form->field($model, "max_length")->textInput() ?>
    <?= $form->field($model, 'required')->checkbox([
        'class' => 'mdl-checkbox__input',
        'labelOptions' => [
            'class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect',
        ]
    ]) ?>
    <?= $form->field($model, 'in_search')->checkbox([
        'class' => 'mdl-checkbox__input',
        'labelOptions' => [
            'class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect',
        ]
    ]) ?>
    <?= $form->field($model, 'in_meta')->checkbox([
        'class' => 'mdl-checkbox__input',
        'labelOptions' => [
            'class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect',
        ]
    ]) ?>
    <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
        <label class="mdl-textfield__label"><?= Yii::t('app', 'Title file') ?></label>
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
