<?php
/* @var $this yii\web\view */
/* @var $model common\models\ProductMake */

/* @var $currentSpecifications array */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\ProductType;
use zxbodya\yii2\tinymce\TinyMce;
use common\models\ProductMake;

$this->registerJs("require(['controllers/productmake/moveModels']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/productmake/changePriority']);", \yii\web\View::POS_HEAD);
if (!$model->isNewRecord):
    $productModels = ProductMake::getModelsList($model->id);


    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Модели <?= $model->name; ?></h3>
                </div>
                <div class="box-body">
                    <form id="form_add_model">
                        <input id="form-token" type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                               value="<?= Yii::$app->request->csrfToken ?>"/>
                        <input type="text" name="ProductMake[name]" required>
                        <input type="hidden" name="ProductMake[product_type]"
                               value="<?php echo $model->product_type; ?>">
                        <input type="hidden" name="ProductMake[parentId]" value="<?php echo $model->id; ?>">
                        <input type="submit" id="add_model" value="Добавить модель">
                    </form>
                    <?php
                    if (!empty($productModels)):
                        ?>
                        <ul id="models_list">
                            <?php
                            foreach ($productModels as $productModel):
                                ?>
                                <li><?php
                                    echo $productModel;
                                    ?></li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    <?php
                    endif;
                    ?>
                </div>
                <div class="box-footer">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Приоритет
                        <span class="priority"> <?php if ($model->priority == ProductMake::HIGH_PRIORITY) {
                                echo 'Высокий';
                            } else {
                                echo 'Низкий';
                            }
                            ?>
                           </span>
                    </h3>
                </div>
                <div class="box-body">
                    <form id="form_change_priority">
                        <input id="form_change_priority-token" type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                               value="<?= Yii::$app->request->csrfToken ?>"/>
                        <input type="hidden" name="ProductMake[product_type]"
                               value="<?php echo $model->product_type; ?>">
                        <input type="hidden" name="ProductMake[parentId]" value="<?php echo $model->id; ?>">
                        <div class="form-group">
                            <select name="ProductMake[priority]" class="form-control">
                                <option value="<?php echo ProductMake::LOW_PRIORITY; ?>">Низкий приоритет</option>
                                <option value="<?php echo ProductMake::HIGH_PRIORITY; ?>">Высокий приоритет</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit">Изменить приоритет</button>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                </div>
            </div>
        </div>
    </div>
<?php
endif;
?>
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'id' => 'productmake-form',
    'validationUrl' => Url::to(['productmake/validate', 'id' => $model->id]),
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
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--8-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?= $form->field($model, 'description')->textarea(['rows' => 8, 'class' => 'js-wysiwyg wysiwyg']) ?>
</div>
<div class="mdl-cell mdl-cell--padding mdl-cell--4-col mdl-cell--12-col-tablet mdl-shadow--2dp">
    <?= $form->field($model, 'id')->textInput(['name' => 'id', 'disabled' => 'disabled']) ?>
    <?= $form->field($model, "product_type")->dropDownList(ProductType::getTypesAsArray()) ?>
</div>
<?= Html::submitButton(
    '<i class="material-icons">done</i>',
    [
        'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
        'title' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update')
    ])
?>
<?php ActiveForm::end(); ?>
