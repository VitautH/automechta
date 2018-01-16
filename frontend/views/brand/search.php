<?php
use yii\widgets\ListView;
use common\models\Product;
use common\models\AppData;
use common\models\ProductMake;
use common\models\Page;
use frontend\models\ProductSearchForm;
use yii\widgets\Breadcrumbs;
use common\helpers\Url;
use yii\widgets\LinkSorter;
use frontend\widgets\CustomPager;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use common\models\User;
use common\models\City;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */

$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);
$this->registerJsFile("@web/js/readmore.js");

$this->registerJs("require(['controllers/catalog/index']);", \yii\web\View::POS_HEAD);
$this->registerJs("    
 $(document).ready(function(){
 var ScreenWidth = screen.width; 
if (ScreenWidth < 767){
 $('#b-makers__list__main').readmore({
    speed: 75,
    maxHeight: 300,
    moreLink: '<a href=\"#\" id=\"more_mark\">Показать все марки <i style=\"margin-left: 7px;\" class=\"fa fa-long-arrow-down\" aria-hidden=\"true\"></i></a>',
    lessLink: '<a href=\"#\" id=\"roll_up_mark_category\">Скрыть</a>',
});
}
});
", \yii\web\View::POS_HEAD);

$productModel = new Product();
$appData = AppData::getData();
switch ($type) {
    case 2:
        $typeName = "автомобилей";
        $typeNames = "автомобили";
        $shortTypeName = "авто";
        break;
    case 3:
        $typeNames = "мотоциклы";
        $typeName = "мотоциклов";
        $shortTypeName = "мотоцикла";
        break;
}
$this->title = 'Каталог '.$typeName . ' с фото и ценой в Беларуси в кредит';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Большой выбор ' . $typeName . ' с фото и ценой в каталоге компании АвтоМечта',
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaData['keywords'],
]);

if ($tableView) {
    $itemOptions = ['class' => 'col-lg-4 col-md-6 col-xs-12'];
} else {
    $itemOptions = ['class' => 'b-items__cars-one'];
}



$asidePages = Page::find()->active()->aside()->orderBy('views DESC')->limit(3)->all();

?>
<div class="catalog">
    <span style="display: none;" class="js-title"><?= $metaData['title'] ?></span>
    <section class="b-pageHeader"
             style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
        <div class="container">
            <h1 class="wow zoomInLeft" data-wow-delay="0.5s">Продажа <?= $typeName; ?> в Беларуси в кредит</h1>
            <div class="b-pageHeader__search wow zoomInRight" data-wow-delay="0.5s">
                <h3><?= Yii::t('app', 'Your search returned {n,plural,=0{# result} =1{# result} one{# results} other{# results}} ', ['n' => $_params_['count']]) ?></h3>
            </div>
        </div>
    </section><!--b-pageHeader-->
    <div class="b-breadCumbs s-shadow">
        <?= Breadcrumbs::widget([
            'links' => [
                'Все ' . $typeNames
            ],
            'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
            'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
            'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
        ]) ?>
    </div><!--b-breadCumbs-->
    <section class="b-makers">
        <div class="container">
            <div class="row col-lg-12">
                <div class="b-makers__list b-makers__list__main" id="b-makers__list__main">
                    <?php
                    $makerAuto = ProductMake::getMakesListWithId($type, true);
                    sort($makerAuto);
                    foreach ($makerAuto as $maker) {
                        ?>
                        <div class="b-makers__item">
                            <a href='<?= Url::UrlCategoryBrand($type, $maker['name']) ?>'>
                                <?php echo $maker['name']; ?>
                                <span class="b-makers__item-number"><?php echo Product::find()->where(['AND', ['make' => $maker['id']], ['status' => 1]])->count(); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <div class="b-infoBar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="b-infoBar__select wow zoomInUp" data-wow-delay="0.5s">
                        <form method="post" action="/">
                            <div class="b-infoBar__select-one js-sorter">
                                <span class="b-infoBar__select-one-title"><?= Yii::t('app', 'SORT BY') ?> :</span>
                                <?=  LinkSorter::widget([
                                    'sort' => $sort,
                                    'attributes' => [
                                        'price',
                                        'created_at',
                                        'year'
                                    ]
                                ]);

                                ?>
                            </div>
                        </form>
                        <div class="search_button_container col-xs-5 col-sm-5 visible-xs visible-sm">
                            <span id="search_button_mobile" class="search_button_mobile visible-xs visible-sm"
                                  data-wow-delay="0.5s">Поиск <i class="fa fa-search" aria-hidden="true"></i> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="search_block_mobile">
        <div class="search_block">
        <?= $this->render('_searchMobileForm', $_params_) ?>
        </div>
    </div>
    <!--b-infoBar-->
    <div class="b-items <?= $tableView ? 'm-listTableTwo' : 'm-listingsTwo' ?>">
        <div class="container" style="width:97%;">
            <div class="row">
                <div class="js-product-list col-lg-9 col-sm-8 col-xs-12">
                    <div id="w0" class="b-items__cars">
                        <?php
                        foreach ($products as $i=>$product):
                            $product = json_decode($product);
                            ?>
                            <div class="b-items__cars-one" data-key="<?=$product->id?>">
                                <a href="<?= Url::UrlShowProduct($product->id) ?>" class="b-items__cars-one-img">
                                    <img src="<?= $product->title_image ?>" alt="<?= Html::encode($product->title) ?>" class="hover-light-img"/>
                                    <?php if($product->priority == 1): ?>
                                        <span class="b-items__cars-one-img-type m-premium"></span>
                                    <?php endif; ?>
                                    <?php if($product->priority != 1): ?>
                                        <span class="b-items__cars-one-img-type m-premium"></span>
                                    <?php endif; ?>
                                </a>
                                <div class="b-items__cars-one-info">
                                    <div class="b-items__cars-one-info-header s-lineDownLeft">
                                        <h2><a href="<?= Url::UrlShowProduct($product->id) ?>"><?= Html::encode($product->title) ?></a></h2>
                                        <?php if($product->exchange): ?>
                                            <span class="b-items__cars-one-info-title b-items__cell-info-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                                        <?php endif; ?>
                                        <?php if($product->auction): ?>
                                            <span class="b-items__cars-one-info-title b-items__cell-info-auction"><?= Yii::t('app', 'Auction') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row s-noRightMargin">
                                        <div class="col-md-3 col-xs-12">
                                            <div class="b-items__cars-one-info-price">
                                                <div class="">
                                                    <div class="b-items__cars-one-info-price-div1">
                                                        <h4><?= Yii::$app->formatter->asDecimal($product->price_byn) ?> BYN</h4>
                                                        <span class="b-items__cell-info-price-usd"><?= Yii::$app->formatter->asDecimal($product->price_usd) ?> $ </span>
                                                    </div>
                                                    <div class="b-items__cars-one-info-price-div2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="m-width row m-smallPadding">
                                                <div class="col-xs-6">
                                                    <div class="row m-smallPadding">
                                                        <div class="col-xs-12">
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <span class="b-items__cars-one-info-title"><?= Yii::t('app', 'Year') ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="b-items__cars-one-info-value"><?= $product->year ?></span>
                                                                    </td>
                                                                </tr>
                                                                <?php foreach ($product->spec as $i=>$spec): ?>
                                                                    <?php
                                                                    if ($i<2):
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="b-items__cars-one-info-title"><?= $spec->name ?></span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="b-items__cars-one-info-value"><?= Html::encode($spec->format) ?> <?= $spec->unit ?></span>
                                                                            </td>
                                                                        </tr>
                                                                        <?
                                                                    endif;
                                                                    ?>
                                                                <?php endforeach; ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <table>
                                                        <?php foreach ($product->spec as $i=>$spec): ?>
                                                            <?php
                                                            if (($i>2) && ($i <=5)):
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <span class="b-items__cars-one-info-title"><?= $spec->name ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="b-items__cars-one-info-value"><?= Html::encode($spec->format) ?> <?= $spec->unit ?></span>
                                                                    </td>
                                                                </tr>
                                                                <?
                                                            endif;
                                                            ?>
                                                        <?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="seller_comment">
                                                <?= StringHelper::truncate($product->seller_comments, 161, '...'); ?>
                                            </p>
                                            <span><?= City::getCityName($product->city_id);?><?//= User::getRegions()[$product->region];?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php

                        endforeach;

                        ?>
                        <?php
                        echo CustomPager::widget([
                            'pagination' => $pages,
                            'options' => ['class' => 'b-items__pagination-main hidden-sm hidden-xs'],

                            'prevPageCssClass' => 'm-left',

                            'nextPageCssClass' => 'm-right',

                            'activePageCssClass' => 'm-active',

                            'wrapperOptions' => ['class' => 'hidden-sm hidden-xs b-items__pagination wow col-xs-12 zoomInUp', 'data-wow-delay' => '0.5s']

                        ]);

                        ?>
                        <div class="visible-xs visible-sm col-xs-12" data-wow-delay="0.5s">
                            <?php if ($currentPage != 1):?>
                                <a class="btn m-btn m-btn-dark"  href="<?=Url::current(['page' => $currentPage-1])?>" data-page="19"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                                <?php
                            endif;
                            ?>
                            <?=$currentPage;?> из <?=$lastPage-1;?>
                            <?php if ($currentPage < $lastPage-1):?>
                                <a class="btn m-btn m-btn-dark" href="<?=Url::current(['page' => $currentPage+1])?>">Следующая  <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 col-xs-12">
                    <aside class="b-items__aside">
                        <div class="b-detail__main-aside-about wow zoomInUp" data-wow-delay="0.5s">

                            <h3>Консультация по кредиту</h3>

                            <div class="b-detail__main-aside-about-call b-detail__main-aside-about-call--narrow">

                                <span class="fa fa-phone"></span>

                                <div><a href="tel:<?= $appData['phone'] ?>"><?= $appData['phone'] ?></a></div>

                                <p>Пн-Вс : 10:00 - 18:00 Без выходных</p>

                            </div>
                            <hr>

                            <div class="b-items__aside-sell wow zoomInUp" data-wow-delay="0.3s">

                                <h2><i class="fa fa-podcast" aria-hidden="true"></i> ONLINE ЗАЯВКА</h2>

                                <p>

                                    <?= Yii::t('app', 'You can fill out an application for a loan on our website. The application will be considered employees of the company in the shortest time.') ?>

                                </p>

                                <a href="/tools/credit-application"
                                   class="btn m-btn">Заполнить <i class="fa fa-angle-double-right"
                                                                  aria-hidden="true"></i></a>

                            </div>

                        </div>
                        <h2 class="s-title wow zoomInUp visible-md visible-lg"
                            data-wow-delay="0.5s">Поиск <?= $shortTypeName; ?></h2>
                        <div id="search_block_desktop" class="search_block  visible-md visible-lg">
                            <?= $this->render('_searchForm', $_params_) ?>
                        </div>
                        <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s">Услуги компании</h2>
                        <div class="b-blog__aside-popular-posts">
                            <?php foreach ($asidePages as $asidePage): ?>
                                <div class="b-blog__aside-popular-posts-one">
                                    <a href="/<?= $asidePage->getUrl() ?>">
                                        <img class="img-responsive" src="<?= $asidePage->getTitleImageUrl(270, 150) ?>"
                                             alt="<?= $asidePage->i18n()->header ?>"/>
                                    </a>
                                    <h4><a href="<?= $asidePage->getUrl() ?>"><?= $asidePage->i18n()->header ?></a></h4>
                                    <div class="b-blog__aside-popular-posts-one-date"><span
                                                class="fa fa-calendar-o"></span></div>
                                </div>
                            <?php endforeach; ?>
                            <!-- Yandex.RTB R-A-248508-1 -->
                            <div id="yandex_rtb_R-A-248508-1"></div>
                            <script type="text/javascript">
                                (function (w, d, n, s, t) {
                                    w[n] = w[n] || [];
                                    w[n].push(function () {
                                        Ya.Context.AdvManager.render({
                                            blockId: "R-A-248508-1",
                                            renderTo: "yandex_rtb_R-A-248508-1",
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
                    </aside>
                </div>
            </div>
        </div>
    </div><!--b-items-->
</div>