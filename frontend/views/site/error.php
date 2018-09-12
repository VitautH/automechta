<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$this->title = $name;
?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Ошибка</span></li>
        </ul>
    </div>
</div>
<section class="b-error">
    <div class="container">
        <div class="row">
            <div class="col-3 col-lg-4">
                <div class="icon-error"></div>
            </div>
        <div class="col-9 col-lg-7">
            <div class="text-block">
                <h3>Произошла ошибка</h3>
            <h2><?= nl2br(Html::encode($message)) ?></h2>
            </div>
        </div>
        </div>
    </div>
</section><!--b-error-->
