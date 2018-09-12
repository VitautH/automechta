<?php
use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Page */
/* @var $provider yii\data\ActiveDataProvider */


$appData = AppData::getData();
$asidePages = Page::find()->active()->aside()->andWhere('id<>' . $model->id)->orderBy('views DESC')->limit(3)->all();
$metaData = MetaData::getModels($model);
$this->title = $metaData[MetaData::TYPE_TITLE]->i18n()->value;
\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $metaData[MetaData::TYPE_DESCRIPTION]->i18n()->value
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaData[MetaData::TYPE_KEYWORDS]->i18n()->value
]);
?>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2"><?= $model->i18n()->header ?></span></li>
        </ul>
    </div>
</div>
<section class="b-article">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="b-article__main">
                    <div class="b-blog__posts-one">
                        <div class="row m-noBlockPadding">
                            <div class="col-sm-11 col-xs-12">
                                <div class="b-blog__posts-one-body">
                                    <header class="b-blog__posts-one-body-head">
                                        <h2 class="s-titleDet"><?= $model->i18n()->header ?></h2>
                                        <div class="b-blog__posts-one-body-head-notes">
                                        </div>
                                        <h4 class="wow zoomInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomInUp;"><?= $model->i18n()->description ?></h4>
                                    </header>
                                    <?php
                                    if (count($model->getUploads()) > 0): ?>
                                    <div class="b-blog__posts-one-body-main">
                                        <div class="b-blog__posts-one-body-main-img">
                                            <img class="img-responsive" src="<?= $model->getTitleImageUrl(750, 300) ?>" alt="<?= $model->i18n()->header ?>"/>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="b-blog__posts-one-body-why">
                                        <p>
                                            <?= $model->i18n()->content ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!--b-article-->
