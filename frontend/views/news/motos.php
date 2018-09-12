<?php

use common\models\Product;
use common\models\AppData;
use common\models\ProductMake;
use frontend\models\ProductSearchForm;
use yii\widgets\LinkSorter;
use common\helpers\Url;
use frontend\widgets\ChildPagination;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use frontend\models\Bookmarks;
use common\models\ProductType;
use common\models\User;
use common\models\City;
use common\models\CreditApplication;


/* @var $this yii\web\View */

/* @var $provider yii\data\ActiveDataProvider */

$this->registerJs("require(['controllers/catalog/bookmarks']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/modal']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/index']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/motos-searchForm.js']);", \yii\web\View::POS_HEAD);
$productModel = new Product();
$appData = AppData::getData();


$this->title = 'Мототехнка с фото и ценой в Беларуси в кредит.';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Большой выбор мотоциклов, скутеров, квадроциклов с фото и ценой в каталоге компании АвтоМечта',
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaData['keywords'],
]);
?>
<script src="/js/catalog.js"></script>
<script src="/build/controllers/brand/motos-searchForm.js"></script>
<script src="/build/controllers/brand/bookmarks.js"></script>
<link type="text/css" rel="stylesheet" href="/css/catalog-style.css">
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Каталог мототехники</span></li>
        </ul>
    </div>
</div>
<main class="motos">
        <div class="banner">
        <div class="container">
            <div class="row">
                <div class="title col-lg-4">
                    <span>Мототехника с пробегом в кредит в Беларуси</span>
                </div>
                <div class="col-12 col-lg-4 offset-lg-4 offset-0">
                    <?= $this->render('_new-searchForm', $_params_) ?>
                </div>
            </div>
        </div>
        </div>
    <div class="carousel-cars catalog-cars">
        <div class="container">
            <div class="row">
            <ul class="col-12 nav nav-tabs row" id="myTab" role="tablist">
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link active" href="<?= Url::to(['/moto']); ?>">Мотоциклы</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" href="<?= Url::to(['/scooter']); ?>">Скутеры</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" href="<?= Url::to(['/atv']); ?>">Квадроциклы</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active">
                    <div class="row">
                        <div class="col-12 col-lg-9">
                            <div class="catalog-cars-container">
                                <?php
                                foreach ($products as $i => $product):
                                    $product = json_decode($product);
                                    $product->price_byn = Product::getByrPriceProduct($product->id);
                                    $product->price_usd = Product::getUsdPriceProduct($product->id);
                                    $sumMonth =  CreditApplication::getMonthPayment($product->price_byn);
                                    ?>
                                    <div class="catalog-item b-items__cars-one" data-key="<?= $product->id ?>">
                                        <div class="catalog-item-img">
                                            <a href="<?= Url::UrlShowProduct($product->id) ?>">
                                                <img src="<?= $product->title_image ?>"
                                                     alt="<?= Html::encode($product->title) ?>"/>
                                            </a>
                                        </div>
                                        <div class="catalog-item-description">
                                            <div class="description-header">
                                                <h2>
                                                    <a href="<?= Url::UrlShowProduct($product->id) ?>"><?= Html::encode($product->title) ?></a>
                                                </h2>
                                            </div>
                                            <div class="description-text">
                                                    <div class="spec-mobile hidden-desktop">
                                                        <a href="<?= Url::UrlShowProduct($product->id) ?>">
                                                            <?php echo $product->spec[2]->format; ?> см<sup>3</sup>,
                                                            <?php echo $product->spec[4]->format; ?>,
                                                            <?php echo $product->spec[6]->format; ?>,
                                                            <?php echo $product->spec[1]->format; ?>
                                                        </a>
                                                    </div>
                                                <?php
                                                if ($product->seller_comments !== null):
                                                    ?>
                                                    <p>
                                                        <a href="<?= Url::UrlShowProduct($product->id) ?>">
                                                            <?= StringHelper::truncate($product->seller_comments, 161, '...'); ?>
                                                        </a>
                                                    </p>
                                                <?php
                                                endif;
                                                ?>
                                            </div>
                                            <div class="description-params hidden-mobile">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <?php
                                                        foreach ($product->spec as $i => $spec): ?>
                                                            <?php
                                                            if ($i == 1):
                                                                ?>
                                                                <p>Привод:
                                                                    <strong><?= Html::encode($spec->format) ?> <?= $spec->unit ?></strong>
                                                                </p>
                                                            <?
                                                            endif;
                                                            ?>
                                                            <?php
                                                            if ($i == 6):
                                                                ?>
                                                                <p>Трансмиссия:
                                                                    <strong><?= Html::encode($spec->format) ?> <?= $spec->unit ?></strong>
                                                                </p>
                                                            <?
                                                            endif;
                                                            ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php foreach ($product->spec as $i => $spec): ?>
                                                            <?php
                                                            if ($i == 4):
                                                                ?>
                                                                <p>Двигатель:
                                                                    <strong><?= Html::encode($spec->format) ?> <?= $spec->unit ?></strong>
                                                                </p>
                                                            <?
                                                            endif;
                                                            ?>
                                                            <?php
                                                            if ($i == 2):
                                                                ?>
                                                                <p>Объем: <strong><?= Html::encode($spec->format) ?>
                                                                        см<sup>3</sup></strong></p>
                                                            <?
                                                            endif;
                                                            ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="description-price">
                                                <span class="price-rb"><?= Yii::$app->formatter->asDecimal($product->price_byn) ?>
                                                    BYN</span><span
                                                        class="price-dol"><?= Yii::$app->formatter->asDecimal($product->price_usd) ?>
                                                    $</span>
                                                <?php if ($product->auction): ?>
                                                    <span class="auction">Торг</span>
                                                <?php
                                                endif;
                                                ?>
                                                <?php if ($product->exchange): ?>
                                                    <span class="exchange">Обмен</span>
                                                <?php
                                                endif;
                                                ?>
                                                <span class="city"><i class="fas fa-map-marker-alt"></i> <?= City::getCityName($product->city_id); ?></span>
                                            </div>
                                        </div>
                                        <div class="favorite">
                                            <?php
                                            if (Yii::$app->user->isGuest):
                                                ?>
                                                <a href="#" class="unregister show-modal-login star add-to-favorite">
                                                    <i class="far fa-star"></i>
                                                    <span class="add-tooltip">В избранное</span>
                                                </a>
                                            <?php
                                            else:
                                                ?>
                                                <?php
                                                if (Bookmarks::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['product_id' => $product->id])->exists()):
                                                    ?>
                                                    <a href="#" title="Удалить из закладок"
                                                       data-product="<?= $product->id; ?>" id="delete-bookmarks"
                                                       class="bookmarks star in-favorite">
                                                        <i class="far fa-star"></i>
                                                        <span class="add-tooltip">Убрать</span>
                                                    </a>
                                                <?php
                                                else:
                                                    ?>
                                                    <a href="#" data-product="<?= $product->id; ?>" id="add-bookmarks"
                                                       class="bookmarks star add-to-favorite">
                                                        <i class="far fa-star"></i>
                                                        <span class="add-tooltip">В избранное</span>
                                                    </a>
                                                <?php
                                                endif;
                                                ?>
                                            <?php
                                            endif;
                                            ?>

                                            <a href="#" class="dollar add-to-favorite">
                                                <i class="fas fa-dollar-sign"></i>
                                                <span class="add-tooltip"><?php echo $sumMonth;?> руб. в месяц</span>
                                            </a>
                                        </div>
                                    </div>

                                <?php

                                endforeach;

                                ?>
                                <div class="col-12">
                                    <a href="/moto" class="show-all">Показать все <i class="fas fa-chevron-right ml-2"></i></a>
                                </div>
                                <?php
                                echo $this->render('_company-services');
                                ?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4 pr-lg-5">
                            <div class="online-request hidden-mobile">
                                <h2>ONLINE-заявка на кредит</h2>
                                <p>Заполните анкету в удобное для Вас время, мы примем ее и свяжемся с Вами</p>
                                <a href="/tools/credit-application" class="custom-button"><i
                                            class="fas fa-search mr-2"></i>Заполнить анкету</a>
                            </div>
                            <a href="/documents/spravka-2018.doc" class="download-income hidden-mobile"><i
                                        class="fas fa-download mr-2"></i>Справка о доходах</a>
                            <!--                                <div class="adv"></div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>