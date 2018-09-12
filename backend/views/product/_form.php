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
$this->registerCss("input#product-phone,input#product-phone_2 {font-weight: bolder; font-size: 16px;}");
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
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Объявление</h3>
                    <?= Html::submitButton(
                        ' <i class="fa fa-save"></i>',
                        [
                            'class' => 'btn btn-app',
                            'title' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update')
                        ])
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
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
                            <div class="form-group">
                                <?= $form->field($model->i18n($key), "[{$key}]title")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model->i18n($key), "[{$key}]seller_comments")->textarea(['rows' => 8]) ?>
                                <?= MetaDataWidget::widget(['model' => $model, 'language' => $key]); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Фотографии</h3>
                </div>
                <div class="box-body">
                    <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
                        <label class="mdl-textfield__label"><?= Yii::t('app', 'Title image') ?></label>
                        <div class="js-dropzone"
                             data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>"></div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-info">
                <?php if ($user !== null): ?>
                    <div class="mdl-textfield mdl-textfield--full-width mdl-js-textfield">
                        <label>Логин пользователя: </label> <b><?= $user->username ?></b><br>
                        <label>Email: </label> <b><?= $user->email ?></b><br>
                        <label>Телефон: </label>
                        <b><?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '+375 (99) 999-99-99',
                            ])->label(false); ?>
                        </b>

                        <label>Доп.
                            телефон: </label><b><?= $form->field($model, 'phone_2')->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '+375 (99) 999-99-99',
                            ])->label(false); ?>
                        </b>
                        <label>Доп.
                            телефон: </label><b><?= $form->field($model, 'phone_3')->widget(\yii\widgets\MaskedInput::className(), [
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
                <?
                if ($model->currency == Product::USD) {
                    echo $form->field($model, "price")->textInput(['maxlength' => true])->label('USD');
                }
                if ($model->currency == Product::BYN) {
                    echo $form->field($model, "priceByn")->textInput(['maxlength' => true])->label('BYN');
                }

                ?>
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

                <h3><?= Yii::t('app', 'Specifications') ?></h3>
                <div class="js-specifications-form">
                    <?= $this->render('specificationsForm', ['productSpecifications' => $productSpecifications, 'form' => $form]) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>