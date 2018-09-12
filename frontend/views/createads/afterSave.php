<?php

/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use common\models\AppData;
use frontend\assets\AppAsset;

$this->title = Yii::t('app', 'Your ad is saved');
$this->registerCssFile("/css/save-ads.css");
$this->registerCssFile("/css/style.css");
AppAsset::register($this);

$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="header">
                <div class="row"><div class="col-12 col-lg-6"><h3>Ваше объявление сохранено</h3></div><div class="col-12 col-lg-6">
                        <h4 style="">Перейти в</h4>
                        <a href="/cars" class="custom-button col-12 col-lg-5">
                            Каталог <i class="ml-2 fas fa-angle-right"></i>
                        </a>
                        <a href="/account" class="col-12 col-lg-5 custom-button">
                            Личный кабинет <i class="fas fa-angle-right"></i>
                        </a>
                    </div></div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-12 col-lg-6">
                <p>
                    Ваше объявление будет опубликовано после проверки администратором.<br>
                    Опубликованные объявления доступны для редактирования в вашем личном кабинете.<br>
                </p>
                <p>
                    Спасибо.<br>
                </p>
            </div>

        </div>
    </div>
</div>