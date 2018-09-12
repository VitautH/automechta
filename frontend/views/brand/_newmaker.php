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

/* @var $this yii\web\View */

/* @var $provider yii\data\ActiveDataProvider */

$this->registerJs("require(['controllers/catalog/bookmarks']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/modal']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/index']);", \yii\web\View::POS_HEAD);

$productModel = new Product();
$appData = AppData::getData();

switch ($type) {
    case ProductType::CARS:
        $typeName = "автомобилей";
        $typeNames = "автомобили";
        $shortTypeName = "авто";
        break;
    case ProductType::MOTO:
        $typeNames = "мотоциклы";
        $typeName = "мотоциклов";
        $shortTypeName = "мотоцикла";
        break;
    case ProductType::SCOOTER:
        $typeNames = "скутера";
        $typeName = "скутеров";
        $shortTypeName = "скутера";
        break;
    case ProductType::ATV:
        $typeNames = "квадроциклы";
        $typeName = "квадроциклов";
        $shortTypeName = "квадроцикла";
        break;
}

$this->title = 'Каталог ' . $typeName . ' с фото и ценой в Беларуси в кредит';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Большой выбор ' . $typeName . ' с фото и ценой в каталоге компании АвтоМечта',
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaData['keywords'],
]);
?>
<script src="/js/catalog.js"></script>
<script src="/build/controllers/brand/new-searchForm.js"></script>
<script src="/build/controllers/brand/bookmarks.js"></script>
<link type="text/css" rel="stylesheet" href="/css/catalog-style.css">
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="ml-lg-2"><a href="<?
            echo Url::UrlBaseCategory($type); ?>">Каталог <?php echo $typeName; ?><i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></span></li>
            <li><span class="no-link ml-lg-2"><?php echo $make_name; ?></span></li>
        </ul>
    </div>
</div>
<main>
    <div class="container">
        <div class="row">
            <div class="title-block col-12">
    <h1>Продажа <? echo $typeName; ?>  <? echo $make_name; ?> в Беларуси в кредит</h1>
                <span class="count-ads"><?= Yii::t('app', 'Your search returned {n,plural,=0{# result} =1{# result} one{# results} other{# results}} ', ['n' => $_params_['count']]) ?>
</span>
            </div>
        </div>
    <div class="all-brands">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="brands brands-catalog">
                        <?php
                        $modelAutos = ProductMake::getModelsListWithId($make_id, $type, true);
                        sort($modelAutos);
                        foreach ($modelAutos as $modelAuto) {
                            ?>
                            <div class="brand-item">
                                <a href='<?= Url::UrlCategoryModel($type, $make_name, $modelAuto['id']) ?>'>
                                    <?php echo $modelAuto['name']; ?>
                                    <span class="brand-amount"> <?php echo Product::find()->where(['AND', ['model' => $modelAuto['name']], ['type' => $type], ['status' => 1]])->count(); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-3 hidden-mobile">
                    <div class="online-request hidden-mobile">
                        <h2>ONLINE-заявка на кредит</h2>
                        <p>Заполните анкету в удобное для Вас время, мы примем ее и свяжемся с Вами</p>
                        <a href="/tools/credit-application" class="custom-button"><i
                                    class="fas fa-search mr-2"></i>Заполнить анкету</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel-cars catalog-cars">
        <div class="container">
            <ul class="nav nav-tabs row justify-content-between" id="myTab" role="tablist">
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" href="<?= Url::to(['/cars/company']); ?>">Авто компании</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link <?php if ($type == ProductType::CARS) {
                        echo 'active';
                    }; ?>" href="<?= Url::to(['/cars']); ?>">Частные авто</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link <?php if ($type == ProductType::MOTO) {
                        echo 'active';
                    }; ?>" href="<?= Url::to(['/motos']); ?>">Мототехника</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link <?php if ($type == ProductType::BOAT) {
                        echo 'active';
                    }; ?>" href="<?= Url::to(['/boat']); ?>">Водный транспорт </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <button class="custom-button filter-button hidden-desktop" type="button" id="open-filter">
                                <i class="fas fa-search"></i>ФИЛЬТР
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-9">
                            <div class="sorter">
                                <span>Сортировать по:</span>
                                <?= LinkSorter::widget([
                                    'sort' => $sort,
                                    'attributes' => [
                                        'price',
                                        'created_at',
                                        'year'
                                    ]
                                ]);

                                ?>
                            </div>
                            <div class="catalog-cars-container">

                                <?php
                                foreach ($products as $i => $product):
                                    $product = json_decode($product);
                                    $product->price_byn = Yii::$app->currency->getCurrencyToByn(145)->convertCurrencyToByn($product->price_usd);

                                    /*
                                    * Credit payment
                                    */
                                    $i = ($appData['prior_bank'] / 12)/100;
                                    $n1= $i * pow((1+$i),60);
                                    $n2 = pow ((1+ $i), 60)-1;
                                    $k = $n1/$n2;
                                    $sum = ($k *  $product->price_byn);
                                    $sumMonth =  floor($sum);
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
                                            <?php if (($product->exchange) || ($product->auction)): ?>
                                                <div class="description-header hidden-desktop">
                                                    <?php if ($product->auction): ?>
                                                        <span>Торг</span>
                                                    <?php
                                                    endif;
                                                    ?>
                                                    <?php if ($product->exchange): ?>
                                                        <span>Обмен</span>
                                                    <?php
                                                    endif;
                                                    ?>
                                                </div>
                                            <?php
                                            endif;
                                            ?>
                                            <div class="description-text">
                                                <p>
                                                    <a href="<?= Url::UrlShowProduct($product->id) ?>">
                                                        <?= StringHelper::truncate($product->seller_comments, 161, '...'); ?>
                                                    </a>
                                                </p>
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
                                                    <span class="auction hidden-mobile">Торг</span>
                                                <?php
                                                endif;
                                                ?>
                                                <?php if ($product->exchange): ?>
                                                    <span class="exchange hidden-mobile">Обмен</span>
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
                                <nav class="pagination">
                                    <?php if ($currentPage != 1): ?>
                                        <a rel="canonical" data-page="<? echo $currentPage - 1; ?>" class="prev-button"
                                           href="<?= Url::current(['page' => $currentPage - 1]) ?>">Предыдущая</a>
                                    <?php
                                    endif;
                                    ?>
                                    <?php
                                    echo ChildPagination::widget([
                                        'pagination' => $pages,
                                        'maxButtonCount' => 4,
                                        'options' => ['class' => 'b-items__pagination-main'],
                                        'prevPageCssClass' => 'd-none',
                                        'activePageCssClass' => 'page-link active',
                                        'pageCssClass' => 'page-link',
                                        'disabledPageCssClass' => 'd-none',
                                    ]);
                                    ?>
                                    <?php if ($currentPage < $lastPage): ?>
                                        <a rel="canonical" data-page="<?php echo $currentPage + 1; ?>" class="next-button"
                                           href="<?= Url::current(['page' => $currentPage + 1]) ?>">Следующая </a>
                                    <?php
                                    endif;
                                    ?>
                                </nav>
                                <?php
                                echo $this->render('_company-services');
                                ?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4 pr-lg-5">
                            <div id="filter">
                                <i class="fas fa-times hidden-desktop" id="close-filter"></i>
                                <?php
                                echo $this->render('_newSearchFormMaker', $_params_);
                                ?>
                            </div>
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
