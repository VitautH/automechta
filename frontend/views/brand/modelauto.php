<?php
use common\models\ProductMake;
use common\models\ProductType;
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

$productMake = ProductMake::find()->where(['id'=>$model->id])->one();
$product = Product::find()->where(['model'=>$productMake->name])->one();
$make = ProductMake::find()->where(['id'=>$product->make])->one()->name;

$product_type_name = ProductType::getTypesAsArray()[$model->product_type];

$h1 = $make . ' ' . $model->name; 

$this->title = 'Купить '.$h1.' в Беларуси в кредит - цены, характеристики, фото. Продажа '. $h1 .' в автосалоне "АвтоМечта"';
$this->registerMetaTag([
            'name' => 'description',
            'content' => 'Большой выбор '.$h1.' с пробегом в Минске. У нас можно купить авто в кредит всего за 1 час, продажа бу '.$h1.' в Минске и Беларуси. Оформление машины в кредит проходит на месте.'
        ]);


$this->registerJs("require(['controllers/brand/searchForm']);", \yii\web\View::POS_HEAD);

$_params_['type'] = $model->product_type;

//var_dump($model);
?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= $h1 ?></h1>
    </div>
</section><!--b-pageHeader-->

<div class="b-breadCumbs s-shadow">
    <?php 
        $product_type = $product_type_name;
    ?>
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'url' =>'..',
                'label' => $product_type_name
            ],
            [
                'url' =>'./',
                'label' => $make
            ],
            $model->name
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->

<div class="b-items b-makers-items m-listingsTwo">
    <div class="container">
        <div class="row">
            <div class="js-product-list col-lg-9 col-sm-8 col-xs-12">
               <?php 
$tableView = 0;
$provider = new ActiveDataProvider([
    'query' => Product::find()->where(['AND',['model'=>$model->name],['product.status'=>1]])->orderBy('product.updated_at DESC'),
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

ListView::end();
               ?>
            </div>
            <div class="col-lg-3 col-sm-4 col-xs-12">
                <aside class="b-items__aside">
                    <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'REFINE YOUR SEARCH') ?></h2>
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
                                    <a href="/tools/credit-application" class="btn m-btn"><?= Yii::t('app', 'Fill application') ?><span class="fa fa-angle-right"></span></a>
                                </div>
                            </div>
                        </div>
                    <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s">Популярные статьи</h2>
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
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div><!--b-items-->

