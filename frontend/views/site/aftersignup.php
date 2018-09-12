<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\AppData;

$this->title = Yii::t('app', 'You have been registered');
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Вы зарегистрированы</span></li>
        </ul>
    </div>
</div>

<div class="aftersingup">
    <div class="container">
        <div class="row">
            <div class="mt-4 col-12 col-lg-4 offset-lg-4">
                <div class="b-contacts__form">
                    <header class="b-contacts__form-header">
                        <h2 class="s-titleDet"><?= Html::encode($this->title) ?></h2>
                    </header>
                    <p>
                        <?= Yii::t('app', 'Thank you for registering on our website')?>.<br>
                        <?= Yii::t('app', 'Please activate your registration by clicking on the link provided in your email')?>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

