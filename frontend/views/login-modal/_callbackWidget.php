<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<script src="/js/callback.js"></script>
<div class="modal-login">
<div class="modal-login-bookmarks">
    <div class="head row justify-content-between">
        <div class="col-10">
            <h2 class="modal-title">Обратный звонок</h2>
        </div>
        <div class="col-2">
            <button type="button" class="modal-close">
                <i class="fas fa-close"></i></button>
        </div>
    </div>
    <div class="body">
        <div class="call-back">
            <?= Html::beginForm(['/tools/callback'], 'post', ['class' => 'callback-form']); ?>
            <?= Html::textInput('Callback[name]', '', ['placeholder' => 'Имя', 'class' => 'callback-name-field', 'required' => 'required']); ?>
            <?= Html::textInput('Callback[phone]', '', ['placeholder' => 'Телефон', 'class' => 'callback-phone-field', 'required' => 'required']); ?>
            <?= Html::submitButton('Отправить <i class="fas fa-arrow-right"></i>', ['class' => 'custom-button icon-right-btn']) ?>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>
</div>