<?php

use yii\helpers\Html;
use common\models\ProductType;

?>
    <link type="text/css" rel="stylesheet" href="/css/create-ads-page-1.css">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
                <li><span class="no-link ml-lg-2">Подать объявление</span></li>
            </ul>
        </div>
    </div>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>
                        Новое объявление
                    </h3>
                </div>
                <div class="rules col-12">
                    <i class="fas fa-info-circle"></i>
                    <p>
                        Перед подачей объявления, обязательно ознакомьтесь с <a class="color-red" href="/oferta">правилами
                            подачи объявлений</a>.<br>
                        Объявления, несоотвествующие правилам ресурса, будут удалены модератором.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 hidden-mobile">
                    <div class="nav">
                        <div class="step active">
                            <span>1</span>
                        </div>

                        <div class="vertical-line">
                        </div>
                        <div class="step">
                            <span>2</span>
                        </div>

                        <div class="vertical-line">
                        </div>
                        <div class="step">
                            <span>3</span>
                        </div>

                        <div class="vertical-line">
                        </div>
                        <div class="step">
                            <span>4</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 col-12">
                    <h3 class="hidden-mobile">Выберите тип вашего транспортного средства</h3>
                    <div class="row type-transport">
                        <div class="item col-lg-3 col-6">
                            <a href="/create-ads?Product%5Btype%5D=2&ProductForm%5Bstep%5D=2"
                               data-title-profile="Автомобиль" data-limit-profile="" class="add-item-link ">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="images car">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p class="title">
                                            Легковой автомобиль
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="item item-moto   col-lg-3 col-6">
                            <a href="/create-ads?Product%5Btype%5D=3&ProductForm%5Bstep%5D=2"
                               data-title-profile="Мотоцикл"
                               data-limit-profile="" class="add-item-link ">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="images moto">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p class="title">
                                            Мотоцикл
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="item item-scooter  col-lg-3 col-6">
                            <a href="/create-ads?Product%5Btype%5D=4&ProductForm%5Bstep%5D=2"
                               data-title-profile="Скутер"
                               data-limit-profile="" class="add-item-link ">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="images scooter">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p class="title">
                                            Скутеры
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="item item-atv  col-lg-3 col-6">
                            <a href="/create-ads?Product%5Btype%5D=5&ProductForm%5Bstep%5D=2"
                               data-title-profile="Квадроцикл" data-limit-profile="" class="add-item-link ">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="images atv">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p class="title">
                                            Квадроцикл
                                        </p>
                                    </div>
                                </div>
                            </a>

                        </div>
                        <div class="item col-lg-3 col-6">
                            <a href="/create-ads/boat" data-title-profile="Водный транспорт" data-limit-profile=""
                               class="add-item-link ">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="images boat">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p class="title">
                                            Водный транспорт
                                        </p>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>