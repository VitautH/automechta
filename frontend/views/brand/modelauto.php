<?php
use common\models\Product;
use common\models\AppData;
use common\models\ProductMake;
use common\models\Page;
use frontend\models\ProductSearchForm;
use yii\widgets\Breadcrumbs;
use common\models\ProductType;
use common\helpers\Url;
use yii\widgets\LinkSorter;
use frontend\widgets\CustomPager;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use common\models\User;
use common\models\City;
use frontend\models\Bookmarks;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */

$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);
$this->registerJs("require(['controllers/catalog/index']);
", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/bookmarks']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/modal']);", \yii\web\View::POS_HEAD);
$this->registerCssFile('@web/css/fontawesome-all.min.css');
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
$this->title = $metaData['title'] . ' в Беларуси в кредит';

$this->registerMetaTag([
    'name' => 'description',
    'content' => $metaData['description'],
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaData['keywords'],
]);


$asidePages = Page::find()->active()->aside()->orderBy('views DESC')->limit(3)->all();
?>


<div class="catalog">
    <span style="display: none;" class="js-title"><?= $metaData['title'] ?></span>

    <section class="b-pageHeader"
             style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
        <div class="container">
            <div class="col-md-7">
                <h1>Продажа <?= $make_name . ' ' . $_params_['model_name'] ?> в Беларуси в кредит</h1>
            </div>
            <h1 class="wow zoomInLeft" data-wow-delay="0.5s"></h1>
            <div class="b-pageHeader__search wow zoomInRight" data-wow-delay="0.5s">
                <h3><?= Yii::t('app', 'Your search returned {n,plural,=0{# result} =1{# result} one{# results} other{# results}} ', ['n' => $count]) ?></h3>
            </div>
        </div>
    </section><!--b-pageHeader-->
    <div class="b-breadCumbs s-shadow">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => ProductType::getTypesAsArray()[$type],
                    'url' => Url::UrlBaseCategory($type)
                ],
                [
                    'label' => $make_name,
                    'url' => Url::UrlCategoryBrand($type, $make_name)
                ],
                [
                    'label' => $_params_['model_name'],
                    'url' => '#'
                ],
            ],
            'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
            'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
            'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
        ]) ?>
    </div>
    <!--b-breadCumbs-->
    <div class="b-infoBar">

        <div class="container">

            <div class="row">

                <div class="col-lg-12 col-xs-12">

                    <div class="b-infoBar__select">

                        <form method="post" action="/">

                            <div class="b-infoBar__select-one js-sorter">

                                <span class="b-infoBar__select-one-title"><?= Yii::t('app', 'SORT BY') ?> :</span>
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
                        </form>
                        <div class="search_button_container visible-xs visible-sm">
                            <span id="search_button_mobile" class="search_button_mobile visible-xs visible-sm">Поиск <i class="fa fa-search" aria-hidden="true"></i> </span>
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

        <div class="container">

            <div class="row">

                <div class="js-product-list col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div id="w0" class="b-items__cars">
                        <?php
                        foreach ($products as $i => $product):
                            $product = json_decode($product);
                            ?>
                            <div class="b-items__cars-one" data-key="<?= $product->id ?>">
                                <div class="visible-xs  b-items__cars-one-info-header s-lineDownLeft">
                                    <h2>
                                        <a href="<?= Url::UrlShowProduct($product->id) ?>"><?= Html::encode($product->title) ?></a>
                                        <?php if ($product->exchange): ?>
                                            <span class="b-items__cars-one-info-title b-items__cell-info-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                                        <?php endif; ?>
                                    </h2>
                                </div>
                                <div class="photo_mobile_block  visible-xs col-xs-4">
                                    <a href="<?= Url::UrlShowProduct($product->id) ?>" class="b-items__cars-one-img">
                                        <img src="<?= $product->title_image ?>" alt="<?= Html::encode($product->title) ?>"
                                             class="hover-light-img"/>
                                        <?php if ($product->priority == 1): ?>
                                            <span class="b-items__cars-one-img-type m-premium"></span>
                                        <?php endif; ?>
                                        <?php if ($product->priority != 1): ?>
                                            <span class="b-items__cars-one-img-type m-premium"></span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-4 visible-sm visible-md visible-lg  visible-xl">
                                    <a href="<?= Url::UrlShowProduct($product->id) ?>" class="b-items__cars-one-img">
                                        <img src="<?= $product->title_image ?>" alt="<?= Html::encode($product->title) ?>"
                                             class="hover-light-img"/>
                                        <?php if ($product->priority == 1): ?>
                                            <span class="b-items__cars-one-img-type m-premium"></span>
                                        <?php endif; ?>
                                        <?php if ($product->priority != 1): ?>
                                            <span class="b-items__cars-one-img-type m-premium"></span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="spec_mobile_block col-xs-8   visible-xs">
                                    <div class="price_mobile_block">
                                        <h4 class="b-items__cell-info-price-byn"><?= Yii::$app->formatter->asDecimal($product->price_byn) ?>
                                            BYN</h4>
                                        <span class="b-items__cell-info-price-usd"><?= Yii::$app->formatter->asDecimal($product->price_usd) ?>
                                            $ </span>
                                        <?php if ($product->auction): ?>
                                            <span class="b-items__cars-one-info-title b-items__cell-info-auction"><?= Yii::t('app', 'Auction') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?= $product->year ?>
                                    <?php foreach ($product->spec as $i => $spec): ?>
                                        <?php
                                        if ($i <= 5):
                                            ?>
                                            ,  <?= Html::encode($spec->format) ?> <?= $spec->unit ?>

                                            <?
                                        endif;
                                        ?>
                                    <?php endforeach; ?>
                                    <br>
                                    <span class="city_block_mobile"><?= City::getCityName($product->city_id); ?></span>
                                </div>
                                <div class="visible-sm visible-md visible-lg visible-xl b-items__cars-one-info col-md-8 col-sm-8">
                                    <div class="b-items__cars-one-info-header s-lineDownLeft ">
                                        <h2>
                                            <a href="<?= Url::UrlShowProduct($product->id) ?>"><?= Html::encode($product->title) ?></a>
                                        </h2>
                                        <?php
                                        if (Yii::$app->user->isGuest):
                                            ?>
                                            <a href="#"  class="unregister" id="show-login-modal"> <span class="star-ico"> <i
                                                            class="far fa-star"></i></span></a>
                                            <div class="modal-login">
                                                <?= \shiyang\login\Login::widget(); ?>
                                            </div>
                                        <?php
                                        else:
                                            ?>
                                            <?php
                                            if (Bookmarks::find()->where(['user_id'=>Yii::$app->user->id])->andWhere(['product_id'=>$product->id])->exists()):
                                                ?>
                                                <a href="#" title="Удалить из закладок" id="delete-bookmarks" class="bookmarks active" data-product="<?= $product->id;?>">  <span class="star-ico"> <i class="far fa-star"></i></span></a>

                                            <?php
                                            else:
                                                ?>
                                                <a href="#" title="Добавить в закладки" id="add-bookmarks" class="bookmarks inactive" data-product="<?= $product->id;?>">  <span class="star-ico"> <i class="far fa-star"></i></span></a>
                                            <?php
                                            endif;
                                            ?>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                    <div class="s-noRightMargin row visible-sm visible-md visible-lg  visible-xl">
                                        <div class="col-md-3 col-sm-3">
                                            <div class="b-items__cars-one-info-price">
                                                <div class="">
                                                    <div class="b-items__cars-one-info-price-div1">
                                                        <h4><?= Yii::$app->formatter->asDecimal($product->price_byn) ?>
                                                            BYN</h4>
                                                        <span class="b-items__cell-info-price-usd"><?= Yii::$app->formatter->asDecimal($product->price_usd) ?>
                                                            $ </span>
                                                    </div>
                                                    <div class="b-items__cars-one-info-price-div2">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($product->exchange): ?>
                                                <span class="b-items__cars-one-info-title b-items__cell-info-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                                            <?php endif; ?>
                                            <?php if ($product->auction): ?>
                                                <span class="b-items__cars-one-info-title b-items__cell-info-auction"><?= Yii::t('app', 'Auction') ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="visible-xl visible-lg visible-md  visible-sm col-md-9 col-sm-9 col-xs-12">
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
                                                                <?php foreach ($product->spec as $i => $spec): ?>
                                                                    <?php
                                                                    if ($i < 2):
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
                                                        <?php foreach ($product->spec as $i => $spec): ?>
                                                            <?php
                                                            if (($i > 2) && ($i <= 5)):
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
                                        <div class="col-md-12 visible-sm visible-xl visible-lg visible-md">
                                            <p class="seller_comment">
                                                <?= StringHelper::truncate($product->seller_comments, 161, '...'); ?>
                                            </p>
                                            <span><?= City::getCityName($product->city_id); ?></span>
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
                        <div class="pagination_mobile visible-xs visible-sm col-xs-12">
                            <?php if ($currentPage != 1): ?>
                                <a class="prev_btn btn m-btn m-btn-dark"
                                   href="<?= Url::current(['page' => $currentPage - 1]) ?>"
                                   data-page="19"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                                <?php
                            endif;
                            ?>
                            <span class="count_pages"> <?= $currentPage; ?> из <?= $lastPage; ?></span>
                            <?php if ($currentPage < $lastPage): ?>
                                <a class="next_btn btn m-btn m-btn-dark"
                                   href="<?= Url::current(['page' => $currentPage + 1]) ?>">Следующая <i
                                            class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <?
                    if ($description != null):
                        ?>
                        <div class="description visible-md visible-lg">
                            <?= $description; ?>
                        </div>
                        <?
                    endif;
                    ?>
                </div>

                <div class="col-lg-3 col-md-3 col-xs-12">

                    <div class="b-items__aside">
                        <div class="b-detail__main-aside-about visible-md  visible-lg visible-xl">
                            <div class="b-detail__main-aside-about-call b-detail__main-aside-about-call--narrow">
                                <h3>Консультация по кредиту:</h3>
                                <div>
 <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[ $appData['phone_credit_provider_1']], ['style' => 'height:22px']) ?>
        </span>
                                    <a href="tel:<?= $appData['phone_credit_1'] ?>"><?= $appData['phone_credit_1']?></a>
                                    <br>
                                    <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[ $appData['phone_credit_provider_2']], ['style' => 'height:22px']) ?>
        </span>
                                    <a href="tel:<?= $appData['phone_credit_2'] ?>"><?= $appData['phone_credit_2'] ?></a>
                                    <br>
                                    <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[ $appData['phone_credit_provider_3']], ['style' => 'height:22px']) ?>
        </span>
                                    <a href="tel:<?= $appData['phone_credit_3'] ?>"><?= $appData['phone_credit_3'] ?></a>
                                </div>

                                <p>Пн-Вс : 10:00 - 18:00 <br> Без выходных</p>

                                <hr>

                                <div class="b-items__aside-sell">

                                    <h2><i class="fa fa-podcast" aria-hidden="true"></i>ЗАЯВКА НА КРЕДИТ</h2>

                                    <p>
                                        Заполните анкету и мы <br> свяжемся с Вами <br> в кратчайшие сроки
                                    </p>

                                    <a href="/tools/credit-application"
                                       class="btn m-btn">Заполнить <i class="fa fa-angle-double-right"
                                                                      aria-hidden="true"></i></a>

                                </div>

                            </div>
                        </div>
                        <div class="spravka-btn">
                            <a href="/documents/spravka-2018.doc">Справка о доходах</a>
                        </div>
                        <h2 class="s-title  visible-md visible-lg">Поиск <?php echo $shortTypeName; ?></h2>
                        <div id="search_block_desktop" class="visible-md visible-lg">
                            <div class="search_block">
                                <?= $this->render('_searchForm', $_params_) ?>
                            </div>
                        </div>
                        <h2 class="s-title   visible-md visible-lg">Услуги компании</h2>

                        <div class="b-blog__aside-popular-posts">

                            <?php foreach ($asidePages as $asidePage): ?>

                                <div class="b-blog__aside-popular-posts-one">

                                    <a href="/<?= $asidePage->getUrl() ?>">

                                        <img class="img-responsive" src="<?= $asidePage->getTitleImageUrl(270, 150) ?>"
                                             alt="<?= $asidePage->i18n()->header ?>"/>

                                    </a>

                                    <h4><a href="<?= $asidePage->getUrl() ?>"><?= $asidePage->i18n()->header ?></a></h4>


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
</div>