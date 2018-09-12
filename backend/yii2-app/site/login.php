<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableClientValidation' => false,
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

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe', ['class' => 'common\widgets\MdlActiveField'])->toggle(); ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?=
                Html::submitButton(
                    '<i class="material-icons">done</i> ' . Yii::t('app', 'Login'),
                    ['class' => 'mdl-button mdl-js-button mdl-button--colored mdl-button--raised mdl-js-ripple-effect'])
                ?>            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div>
        <!-- /.social-auth-links -->

        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
