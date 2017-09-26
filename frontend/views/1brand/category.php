<?php
use common\models\ProductMake;
use common\models\Page;
use yii\widgets\ListView;
use common\models\Product;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use frontend\models\ProductSearchForm;
use yii\data\ActiveDataProvider;


/* @var $this yii\web\View */
/* @var $model Page */
/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */

$appData = AppData::getData();
$asidePages = Page::find()->active()->aside()->orderBy('views DESC')->limit(3)->all();

$h1 = $model->name;

$rus_endings = array('2' => array('mult' => 'автомобили', 'mult_gen' => 'автомобилей'), '3' => array('mult' => 'мотоциклы', 'mult_gen' => 'мотоциклов'));

$this->title = 'Купить ' . $rus_endings[$model->product_type]['mult'] . ' бу в кредит в Минске - цены, характеристики, фото. Продажа ' . $rus_endings[$model->product_type]['mult_gen'] . ' в автосалоне "АвтоМечта"';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Большой выбор ' . $rus_endings[$model->product_type]['mult_gen'] . ' с пробегом в Минске. У нас можно купить авто в кредит всего за 1 час, продажа бу ' . $rus_endings[$model->product_type]['mult_gen'] . ' в Минске и Беларуси. Оформление машины в кредит проходит на месте.'
]);

$this->registerJs("require(['controllers/site/searchForm']);", \yii\web\View::POS_HEAD);

$_params_['type'] = $model->product_type;
$tableView = 0;


$provider = new ActiveDataProvider([
    'query' => Product::find()->join('INNER JOIN','product_make', 'product_make.id = product.make')->where(['AND',['product_make.product_type'=>$model->product_type],['product.status'=>1]])->orderBy('product.updated_at DESC'),
    'pagination' => [
        'pageSize' => 20,
    ],
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
    'itemView' => $tableView ? '../catalog/_productsTable' : '../catalog/_productsList',
]);

?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= $h1 ?></h1>
    </div>
</section><!--b-pageHeader-->

<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            $model->name
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<div class="b-infoBar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="b-infoBar__select wow zoomInUp" data-wow-delay="0.5s">
                    <form method="post" action="/">
                        <div class="b-infoBar__select-one js-sorter">
                            <span class="b-infoBar__select-one-title"><?= Yii::t('app', 'SORT BY') ?></span>
                            <?= $listView->renderSorter() ?>
                        </div>
                        <div class="b-infoBar__select-one">
                            <span class="b-infoBar__select-one-title"><?= Yii::t('app', 'SELECT VIEW') ?></span>
                            <a href="#" data-view="list"
                               class="js-change-view m-list <?php if (!$tableView): ?>m-active<?php endif; ?>"><span
                                        class="fa fa-list"></span></a>
                            <a href="#" data-view="table"
                               class="js-change-view m-table <?php if ($tableView): ?>m-active<?php endif; ?>"><span
                                        class="fa fa-table"></span></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!--b-infoBar-->
<section class="b-makers">
    <div class="container">
        <div class="row col-lg-12">
            <div class="b-makers__list">
                <?php
                foreach (ProductMake::getMakesListWithId(2, true) as $maker) {
                    ?>
                    <div class="b-makers__item">
                        <a href='<?php echo '/brand/2/' . $maker['name']; ?>'>
                            <?php echo $maker['name']; ?>
                            <span class="b-makers__item-number"><?php echo Product::find()->where(['AND', ['make' => $maker['id']], ['status' => 1]])->count(); ?></span>
                        </a>
                    </div>
                    <?php
                }
                ?>
                <?php
                foreach (ProductMake::getMakesListWithId(3, true) as $maker) {
                    ?>
                    <div class="b-makers__item">
                        <a href='<?php echo '/brand/3/' . $maker['name']; ?>'>
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
<div class="b-items b-makers-items m-listingsTwo">
    <div class="container">
        <div class="row">
            <div class="js-product-list col-lg-9 col-sm-8 col-xs-12">
                <?php
                ListView::end();
                ?>
            </div>
            <div class="col-lg-3 col-sm-4 col-xs-12">
                <aside class="b-items__aside">
                    <h2 class="s-title wow zoomInUp"
                        data-wow-delay="0.5s"><?= Yii::t('app', 'REFINE YOUR SEARCH') ?></h2>
                    <div class="b-items__aside-main wow zoomInUp" data-wow-delay="0.5s">
                        <?= $this->render('_searchForm', $_params_) ?>
                    </div>
                    <div class="b-detail__main-aside-about wow zoomInUp" data-wow-delay="0.5s">
                        <h2 class="s-titleDet"><?= Yii::t('app', 'ASK A QUESTION ABOUT THIS VEHICLE') ?></h2>
                        <div class="b-detail__main-aside-about-call b-detail__main-aside-about-call--narrow">
                            <span class="fa fa-phone"></span>
                            <div><?= $appData['phone'] ?></div>
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
                                <a href="/tools/credit-application"
                                   class="btn m-btn"><?= Yii::t('app', 'Fill application') ?><span
                                            class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                    <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s">Популярные статьи</h2>
                    <div class="b-blog__aside-popular-posts">
                        <?php foreach ($asidePages as $asidePage): ?>
                            <div class="b-blog__aside-popular-posts-one">
                                <a href="/page/<?= $asidePage->getUrl() ?>">
                                    <img class="img-responsive" src="<?= $asidePage->getTitleImageUrl(270, 150) ?>"
                                         alt="<?= $asidePage->i18n()->header ?>"/>
                                </a>
                                <h4><a href="<?= $asidePage->getUrl() ?>"><?= $asidePage->i18n()->header ?></a></h4>
                                <div class="b-blog__aside-popular-posts-one-date"><span class="fa fa-calendar-o"></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div><!--b-items-->

