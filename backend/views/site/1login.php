<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$this->title = 'Login';
?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <?= Alert::widget() ?>
        <h2><?= Html::encode(Yii::t('app', $this->title)) ?></h2>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-shadow--2dp mdl-cell--6-col">
        <p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'errorCssClass' => 'is-invalid',
            'fieldConfig' => [
                'template' => "{input}\n{label}\n{error}",
                'options' => ['class' => 'mdl-textfield mdl-textfield--full-width mdl-js-textfield'],
                'labelOptions' => ['class' => 'mdl-textfield__label'],
                'errorOptions' => ['class' => 'mdl-textfield__error'],
                'inputOptions' => ['class' => 'mdl-textfield__input']
            ]
        ]); ?>
        <?= $form->field($model, 'email')->textInput([])?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <div class="mdl-textfield mdl-textfield--full-width">
            <?= $form->field($model, 'rememberMe', ['class' => 'common\widgets\MdlActiveField'])->toggle(); ?>
        </div>
        <?=
        Html::submitButton(
            '<i class="material-icons">done</i> ' . Yii::t('app', 'Login'),
            ['class' => 'mdl-button mdl-js-button mdl-button--colored mdl-button--raised mdl-js-ripple-effect'])
        ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>