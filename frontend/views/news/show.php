<?php
use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this frontend\components\View */
/* @var $model Page */
/* @var $provider yii\data\ActiveDataProvider */


$appData = AppData::getData();
$popularNews = Page::find()->active()->news()->orderBy('views DESC')->limit(2)->all();
$metaData = MetaData::getModels($model);
$this->title= $model->i18n()->header;
$this->title = $model->i18n()->header;
?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= Yii::t('app', 'News') ?></h1>
    </div>
</section><!--b-pageHeader-->

<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => Yii::t('app', 'News'),
                'url' => '/news',
            ],
            $model->i18n()->header,
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<section class="b-article">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-xs-12">
                <div class="b-article__main">
                    <div class="b-blog__posts-one">
                        <div class="row m-noBlockPadding">
                                <div class="b-blog__posts-one-body">
                                    <header class="b-blog__posts-one-body-head wow zoomInUp" data-wow-delay="0.5s">
                                        <h2 class="s-titleDet s-title"><?= $model->i18n()->header ?></h2>
                                        <div class="b-blog__posts-one-body-head-notes">
                                            <span class="b-blog__posts-one-body-head-notes-note"><span
                                                        class="fa fa-calendar-o"></span><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                                            <span class="b-blog__posts-one-body-head-notes-note"><span
                                                        class="fa fa-eye"></span><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>
                                        </div>
                                    </header>
                                    <div class="b-blog__posts-one-body-main wow zoomInUp" data-wow-delay="0.5s">
                                        <?php
                                        if ($model->i18n->main_image !== null):
                                            ?>
                                            <div class="b-blog__posts-one-body-main-img">
                                                <img class="img-responsive"
                                                     src="<?= $model->getTitleImageUrl(750, 300) ?>"
                                                     alt="<?= $model->i18n()->header ?>"/>
                                            </div>
                                            <?php
                                        endif;
                                        ?>
                                    </div>
                                    <div class="b-blog__posts-one-body-why wow zoomInUp" data-wow-delay="0.5s">
                                        <p>
                                            <?= $model->i18n()->content ?>
                                        </p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <aside class="b-blog__aside">
                    <div class="b-blog__aside-popular wow zoomInUp" data-wow-delay="0.5s">
                        <header class="s-lineDownLeft">
                            <h2 class="s-titleDet"><?= Yii::t('app', 'POPULAR POSTS') ?></h2>
                        </header>
                        <div class="b-blog__aside-popular-posts">
                            <?php foreach ($popularNews as $popularNewsModel): ?>
                                <div class="b-blog__aside-popular-posts-one">
                                    <a href="<?= $popularNewsModel->getUrl() ?>">
                                        <img class="img-responsive"
                                             src="<?= $popularNewsModel->getTitleImageUrl(270, 150) ?>"
                                             alt="<?= $popularNewsModel->i18n()->header ?>"/>
                                    </a>
                                    <h4>
                                        <a href="<?= $popularNewsModel->getUrl() ?>"><?= $popularNewsModel->i18n()->header ?></a>
                                    </h4>
                                    <div class="b-blog__aside-popular-posts-one-date"><span
                                                class="fa fa-calendar-o"></span><?= Yii::$app->formatter->asDate($popularNewsModel->created_at) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section><!--b-article-->