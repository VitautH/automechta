<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\AppData;

$this->title = Yii::t('app', 'Your email has been confirmed');
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Регистрация подтверждена</span></li>
        </ul>
    </div>
</div>

<div class="aftersingup">
    <div class="container">
        <div class="row">
            <div class="mt-4 col-12 col-lg-4 offset-lg-4">
                <div class="b-contacts__form">
                    <header class="b-contacts__form-header">
                        <h2 class="s-titleDet"><?= Yii::t('app', 'Confirmed') ?></h2>
                    </header>
                    <p>

                        <?= Yii::t('app', 'Thanks for signing up')?>.<br>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

