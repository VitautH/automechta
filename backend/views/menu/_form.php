<?php
/* @var $this yii\web\view */
/* @var $model common\models\Menu */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\MetaDataWidget;

?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'id' => 'menu-form',
    'validationUrl' => Url::to(['menu/validate', 'id' => $model->id]),
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
            <?= $form->field($model->i18n($key), "[{$key}]name")->textInput(['maxlength' => true]) ?>
            <?= MetaDataWidget::widget(['model' => $model, 'language' => $key]); ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--6-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' =>  $model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update')
    ])
?>
<?php ActiveForm::end(); ?>
