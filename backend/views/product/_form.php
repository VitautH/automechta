<?php
/* @var $this yii\web\view */
/* @var $model common\models\Product */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;
use common\models\ProductType;
use common\models\Product;
use common\models\ProductMake;
use common\models\User;
use backend\widgets\MetaDataWidget;
use yii\widgets\MaskedInput;
if (!$model->isNewRecord) {
    $user = User::find()->where('id=' . $model->created_by)->one();
} else {
    $user = null;
}
$this->registerCss("input#product-phone {font-weight: bolder; font-size: 16px;}");
?>

<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'id' => 'product-form',
    'validationUrl' => Url::to(['product/validate', 'id' => $model->id]),
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
        <div class="mdl-tabs__tab-bar <?php if (count(\Yii::$app->params['i18n']) === 1): ?>hidden<?php endif; ?>">
            <?php foreach (\Yii::$app->params['i18n'] as $key => $language): ?>
                <a href="#i18n-panel-<?= $key ?>"
                   class="mdl-tabs__tab <?php if ($key === \Yii::$app->language): ?>is-active<?php endif; ?>">
                    <?= $language['label'] ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php foreach (\Yii::$app->params['i18n'] as $key => $language): ?>
            <div class="mdl-tabs__panel <?php if ($key === \Yii::$app->language): ?>is-active<?php endif; ?>"
                 id="i18n-panel-<?= $key ?>">
                <?= $form->field($model->i18n($key), "[{$key}]title")->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->i18n($key), "[{$key}]seller_comments")->textarea(['rows' => 8]) ?>
                <?= MetaDataWidget::widget(['model' => $model, 'language' => $key]); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--4-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?php if ($user !== null): ?>
        <div class="mdl-textfield mdl-textfield--full-width mdl-js-textfield">
            <label>Логин пользователя: </label> <b><?= $user->username ?></b><br>
            <label>Email: </label> <b><?= $user->email ?></b><br>
            <label>Телефон:   </label><b> <b><?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+375 (99) 999-99-99',
            ])->label(false); ?>
            </b>

        </div>
    <?php endif; ?>
    <?= $form->field($model, 'id')->textInput(['name' => 'id', 'disabled' => 'disabled']) ?>
    <?= Html::activeHiddenInput($model, 'type') ?>
    <?= $form->field($model, 'status')->dropDownList($model::getStatuses(), []) ?>
    <?= $form->field($model, "make")->dropDownList(ProductMake::getMakesList($model->type)) ?>
    <?= $form->field($model, "model")->dropDownList(ProductMake::getModelsList($model->make)) ?>
    <?= $form->field($model, "price")->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, "year")->dropDownList(Product::getYearsList()) ?>
    <?= $form->field($model, "priority")->dropDownList(Product::getPriorities()) ?>
    <?= $form->field($model, "exchange")->checkbox([
        'class' => 'mdl-checkbox__input',
        'labelOptions' => [
            'class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect',
        ]
    ]) ?>
    <?= $form->field($model, "auction")->checkbox([
        'class' => 'mdl-checkbox__input',
        'labelOptions' => [
            'class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect',
        ]
    ]) ?>
    <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
        <label class="mdl-textfield__label"><?= Yii::t('app', 'Title image') ?></label>
        <div class="js-dropzone"
             data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <h3><?= Yii::t('app', 'Specifications') ?></h3>
    <div class="js-specifications-form">
        <?= $this->render('specificationsForm', ['productSpecifications' => $productSpecifications, 'form' => $form]) ?>
    </div>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update')
    ])
?>
<?php ActiveForm::end(); ?>
