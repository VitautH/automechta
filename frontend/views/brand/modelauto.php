<?php
use yii\widgets\ListView;
use common\models\Product;
use common\models\AppData;
use common\models\ProductMake;
use common\models\Page;
use frontend\models\ProductSearchForm;
use yii\widgets\Breadcrumbs;
use common\models\ProductType;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */

$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);
$this->registerJs("require(['controllers/catalog/index']);", \yii\web\View::POS_HEAD);
$productModel = new Product();
$appData = AppData::getData();

$this->title = $metaData['title'];

$this->registerMetaTag([
    'name' => 'description',
    'content' => $metaData['description'],
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

$listView = ListView::begin([
    'options' => ['class' => $tableView ? 'row m-border' : 'b-items__cars'],
    'dataProvider' => $provider,
    'layout' => "{items}\n{pager}",
    'itemOptions' => $itemOptions,
    'sorter' => [
        'attributes' => [
            'price',
            'created_at',
            'year'
        ]
    ],
    'pager' => [
        'class' => 'frontend\widgets\CustomPager',
        'options' => ['class' => 'b-items__pagination-main'],
        'prevPageCssClass' => 'm-left',
        'nextPageCssClass' => 'm-right',
        'activePageCssClass' => 'm-active',
        'wrapperOptions' => ['class' => 'b-items__pagination wow col-xs-12 zoomInUp', 'data-wow-delay' => '0.5s']
    ],
    'itemView' => $tableView ? '_productsTable' : '_productsList',
]);

$asidePages = Page::find()->active()->aside()->orderBy('views DESC')->limit(3)->all();
?>


<div class="catalog">
    <span style="display: none;" class="js-title"><?= $metaData['title'] ?></span>

    <section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
        <div class="container">
            <div class="col-md-4">
                <h1><?=$model->name.' '.$_params_['model_name']?></h1>
            </div>
            <h1 class="wow zoomInLeft" data-wow-delay="0.5s"></h1>
            <div class="b-pageHeader__search wow zoomInRight" data-wow-delay="0.5s">
                <h3><?= Yii::t('app', 'Your search returned {n,plural,=0{# result} =1{# result} one{# results} other{# results}} ', ['n'=>$provider->getTotalCount()]) ?></h3>
            </div>
        </div>
    </section><!--b-pageHeader-->
    <div class="b-breadCumbs s-shadow">
        <?= Breadcrumbs::widget([
            'links' => [
                [
                    'label' => ProductType::getTypesAsArray()[$model->product_type],
                    'url' => '/brand/' . $model->product_type
                ],
                [
                    'label' => $model->name,
                    'url' => '/brand/' . $model->product_type . '/' . $model->name
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
                    <div class="b-infoBar__select wow zoomInUp" data-wow-delay="0.5s">
                        <form method="post" action="/">
                            <div class="b-infoBar__select-one js-sorter">
                                <span class="b-infoBar__select-one-title"><?= Yii::t('app', 'SORT BY') ?> :</span>
                                <?= $listView->renderSorter() ?>
                            </div>
                            <div class="b-infoBar__select-one">
                                <span class="b-infoBar__select-one-title"><?= Yii::t('app', 'SELECT VIEW') ?></span>
                                <a href="#" data-view="list" class="js-change-view m-list <?php if (!$tableView): ?>m-active<?php endif; ?>"><span class="fa fa-list"></span></a>
                                <a href="#" data-view="table" class="js-change-view m-table <?php if ($tableView): ?>m-active<?php endif; ?>"><span class="fa fa-table"></span></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--b-infoBar-->
    <div class="b-items <?= $tableView ? 'm-listTableTwo' : 'm-listingsTwo' ?>">
        <div class="container" style="width:97%;">
            <div class="row">
                <div class="js-product-list col-lg-9 col-sm-8 col-xs-12">
                    <?php
                    ListView::end();
                    ?>
                </div>
                <div class="col-lg-3 col-sm-4 col-xs-12">
                    <aside class="b-items__aside">
                        <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'REFINE YOUR SEARCH') ?></h2>
                        <div class="b-items__aside-main wow zoomInUp" data-wow-delay="0.5s">
                            <?= $this->render('_searchFormMaker', $_params_) ?>
                        </div>
                        <div class="b-detail__main-aside-about wow zoomInUp" data-wow-delay="0.5s">
                            <h2 class="s-titleDet"><?= Yii::t('app', 'ASK A QUESTION ABOUT THIS VEHICLE') ?></h2>
                            <div class="b-detail__main-aside-about-call b-detail__main-aside-about-call--narrow">
                                <span class="fa fa-phone"></span>
                                <div><a href="tel:<?= $appData['phone'] ?>"><?= $appData['phone'] ?></a></div>
                                <p>Пн-Вс : 10:00 - 18:00 Без выходных</p>
                            </div>
                            <div class="b-items__aside-sell wow zoomInUp" data-wow-delay="0.3s">
                                <div class="b-items__aside-sell-img">
                                    <h3><?= Yii::t('app', 'Online credit application') ?></h3>
                                </div>
                                <div class="b-items__aside-sell-info">
                                    <p>
                                        <?= Yii::t('app', 'You can fill out an application for a loan on our website. The application will be considered employees of the company in the shortest time.') ?>
                                    </p>
                                    <a href="/tools/credit-application" class="btn m-btn"><?= Yii::t('app', 'Fill application') ?><span class="fa fa-angle-right"></span></a>
                                </div>
                            </div>
                        </div>
                        <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s">Услуги компании</h2>
                        <div class="b-blog__aside-popular-posts">
                            <?php foreach($asidePages as $asidePage): ?>
                                <div class="b-blog__aside-popular-posts-one">
                                    <a href="/page/<?= $asidePage->getUrl() ?>">
                                        <img class="img-responsive" src="<?= $asidePage->getTitleImageUrl(270, 150) ?>" alt="<?= $asidePage->i18n()->header ?>" />
                                    </a>
                                    <h4><a href="<?= $asidePage->getUrl() ?>"><?= $asidePage->i18n()->header ?></a></h4>
                                    <div class="b-blog__aside-popular-posts-one-date"><span class="fa fa-calendar-o"></span></div>
                                </div>
                            <?php endforeach; ?>
                            <!-- Yandex.RTB R-A-248508-1 -->
                            <div id="yandex_rtb_R-A-248508-1"></div>
                            <script type="text/javascript">
                                (function(w, d, n, s, t) {
                                    w[n] = w[n] || [];
                                    w[n].push(function() {
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