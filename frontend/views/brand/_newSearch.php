<?php

use common\models\Product;
use common\models\AppData;
use common\models\ProductMake;
use common\models\Page;
use yii\widgets\Breadcrumbs;
use common\helpers\Url;
use yii\widgets\LinkSorter;
use frontend\widgets\ChildPagination;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use frontend\models\Bookmarks;
use common\models\ProductType;
use common\models\City;
use common\models\CreditApplication;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */

$this->registerJs("require(['controllers/catalog/bookmarks']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/modal']);", \yii\web\View::POS_HEAD);
$this->registerJs("    
 $(document).ready(function(){


    $('#open-filter').click(function () {
        $('#filter').addClass('open-filter');
        $('html, body').css('overflow', 'visible');
    });

    $('#close-filter').click(function () {
        $('#filter').removeClass('open-filter');
        $('html, body').css('overflow', 'auto');
    });

    $(\"ul.sorter li\").each(function(){
  var sort = $(this).find('a').data('sort');
  var linksort = $(this).find('a');
  switch (sort){
      case '-price':
          $(linksort).append( \"<i class='fas fa-angle-down'></i>\" );
          break;
      case '-created_at':
          $(linksort).append( \"<i class='fas fa-angle-down'></i>\" );
          break;
      case '-year':
          $(linksort).append( \"<i class='fas fa-angle-down'></i>\" );
          break;
      case 'price':
          $(linksort).append( \"<i class='fas fa-angle-up'></i>\" );
          break;
      case 'created_at':
          $(linksort).append( \"<i class='fas fa-angle-up'></i>\" );
          break;
      case 'year':
          $(linksort).append( \"<i class='fas fa-angle-up'></i>\" );
          break;
  }
    });

    $('a.dollar').click(function (e) {
        e.preventDefault();
    });
});
", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/searchForm']);", \yii\web\View::POS_HEAD);
$this->registerCssFile('/css/catalog-style.css');
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

if(!empty($_params_['ProductSearchForm']['make']) || !empty($_params_['ProductSearchForm']['model'])){
    $makesModel = ProductMake::findOne($_params_['ProductSearchForm']['make'])->name.' '.$_params_['ProductSearchForm']['model'];
    $header =  'Продажа '.$makesModel.'  в Беларуси в кредит';
    $this->title = 'Купить ' .$makesModel. ' в Беларуси в кредит - цены, характеристики, фото. Продажа '.$makesModel.' в автосалоне АвтоМечта в Беларуси в кредит';
}
else {
    $header =  'Продажа '.$typeName.'  в Беларуси в кредит';
    $this->title = 'Каталог ' . $typeName . ' с фото и ценой в Беларуси в кредит';
}

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Большой выбор ' . $typeName . ' с фото и ценой в каталоге компании АвтоМечта',
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaData['keywords'],
]);

?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Поиск  <?php echo $typeName; ?></span></li>
        </ul>
    </div>
</div>
<main>
    <div class="carousel-cars catalog-cars">
        <div class="container">
            <ul class="nav nav-tabs row " id="myTab" role="tablist">
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" href="<?= Url::to(['/cars/company']); ?>">Авто компании</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" href="<?= Url::to(['/cars']); ?>">Частные авто</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" href="<?= Url::to(['/motos']); ?>">Мототехника</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" href="<?= Url::to(['/boat']); ?>">Водный транспорт</a>
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

                                                    <div class="spec-mobile hidden-desktop">
                                                        <a href="<?= Url::UrlShowProduct($product->id) ?>">
                                                            <?php echo $product->spec[2]->format; ?> см<sup>3</sup>,
                                                            <?php echo $product->spec[4]->format; ?>,
                                                            <?php echo $product->spec[6]->format; ?>,
                                                            <?php echo $product->spec[1]->format; ?>
                                                        </a>
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
                                            <div class="description-text">
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
                                <nav class="pagination">
                                    <?php if ($currentPage != 1): ?>
                                        <a rel="canonical" data-page="<? echo $currentPage - 1; ?>" class="hidden-mobile prev-button"
                                           href="<?= Url::current(['page' => $currentPage - 1]) ?>">Предыдущая</a>
                                        <a rel="canonical" data-page="<? echo $currentPage - 1; ?>" class="button-mobile-prev custom-button hidden-desktop prev-button"
                                           href="<?= Url::current(['page' => $currentPage - 1]) ?>"><i class="ml-1 fas fa-arrow-left"></i></a>
                                    <?php
                                    endif;
                                    ?>
                                    <div class="hidden-mobile">
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
                                    </div>
                                    <div class="hidden-desktop">
                                        <span class="count_pages"> <?= $currentPage; ?> из <?= $lastPage; ?></span>
                                    </div>
                                    <?php if ($currentPage < $lastPage): ?>
                                        <a rel="canonical" data-page="<?php echo $currentPage + 1; ?>" class="hidden-mobile next-button"
                                           href="<?= Url::current(['page' => $currentPage + 1]) ?>">Следующая страница <i class="ml-1 fas fa-arrow-right"></i></a>
                                        <a rel="canonical" data-page="<?php echo $currentPage + 1; ?>" class="button-mobile-next custom-button hidden-desktop next-button"
                                           href="<?= Url::current(['page' => $currentPage + 1]) ?>">Следующая страница <i class="ml-1 fas fa-arrow-right"></i></a>
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
                                        echo $this->render('_newSearchFormSearch', $_params_);
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
                                <div class="ads-block mt-1">
                                    <!-- Yandex.RTB R-A-288803-1 -->
                                    <div id="yandex_rtb_R-A-288803-1"></div>
                                    <script type="text/javascript">
                                        (function(w, d, n, s, t) {
                                            w[n] = w[n] || [];
                                            w[n].push(function() {
                                                Ya.Context.AdvManager.render({
                                                    blockId: "R-A-288803-1",
                                                    renderTo: "yandex_rtb_R-A-288803-1",
                                                    async: true
                                                });
                                            });
                                            t = d.getElementsByTagName("script")[0];
                                            s = d.createElement("script");
                                            s.type = "text/javascript";
                                            s.src = "//an.yandex.ru/system/context.js";
                                            s.async = true;
                                            t.parentNode.insertBefore(s, t);
                                        })(this, this.document, "yandexContextAsyncCallbacks");
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="hidden-desktop mt-1">
        <!-- Yandex.RTB R-A-288803-2 -->
        <div id="yandex_rtb_R-A-288803-2"></div>
        <script type="text/javascript">
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-288803-2",
                        renderTo: "yandex_rtb_R-A-288803-2",
                        async: true
                    });
                });
                t = d.getElementsByTagName("script")[0];
                s = d.createElement("script");
                s.type = "text/javascript";
                s.src = "//an.yandex.ru/system/context.js";
                s.async = true;
                t.parentNode.insertBefore(s, t);
            })(this, this.document, "yandexContextAsyncCallbacks");
        </script>
    </div>
</main>