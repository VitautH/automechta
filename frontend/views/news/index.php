<?php
use yii\widgets\ListView;
use common\models\AppData;
use common\models\Page;
use yii\widgets\Breadcrumbs;

/* @var $this frontend\components\View */
/* @var $provider yii\data\ActiveDataProvider */

$appData = AppData::getData();
$popularNews = Page::find()->active()->news()->orderBy('views DESC')->limit(2)->all();
$latestNews = Page::find()->active()->news()->orderBy('id DESC')->limit(3)->all();
$this->registerMetaData();
?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= Yii::t('app', 'News') ?></h1>
    </div>
</section><!--b-pageHeader-->

<?php
?>
<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            Yii::t('app', 'News')
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<div class="b-blog s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <aside class="b-blog__aside">
                    <div class="b-blog__aside-popular wow zoomInUp" data-wow-delay="0.3s">
                        <header class="s-lineDownLeft">
                            <h2 class="s-titleDet"><?= Yii::t('app', 'POPULAR POSTS') ?></h2>
                        </header>
                            <div class="b-blog__aside-popular-posts">
                            <?php foreach($popularNews as $popularNewsModel): ?>
                                <a href="<?= $popularNewsModel->getUrl() ?>" class="b-blog__aside-popular-posts-one">
                                    <img class="img-responsive" src="<?= $popularNewsModel->getTitleImageUrl(270, 150) ?>" alt="<?= $popularNewsModel->i18n()->header ?>" />
                                    <h4><?= $popularNewsModel->i18n()->header ?></h4>
                                    <div class="b-blog__aside-popular-posts-one-date"><span class="fa fa-calendar-o"></span><?= Yii::$app->formatter->asDate($popularNewsModel->created_at) ?></div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="b-detail__main-aside-about-call" style="margin-bottom: 55px;">
                        <span class="fa fa-phone"></span>
                        <p>Задайте вопрос по кредитованию</p>
                        <div style="font-size: 18px;"><?= $appData['phone'] ?></div>
                        <!--<p><?= Yii::t('app', 'Call the seller 24/7 and they would help you.') ?></p>-->
                        <p>Пн-Вс : 10:00 - 18:00 Без выходных</p>
                    </div>
                    <div class="b-blog__aside-reviews wow zoomInUp" data-wow-delay="0.3s">
                        <header class="s-lineDownLeft">
                            <h2 class="s-titleDet"><?= Yii::t('app', 'Latest news') ?></h2>
                        </header>
                        <div class="b-blog__aside-reviews-posts">
                            <?php foreach ($latestNews as $latestNewsModel): ?>
                            <a href="<?= $latestNewsModel->getUrl() ?>" class="b-blog__aside-reviews-posts-one">
                                <div class="row m-smallPadding">
                                    <div class="col-xs-5">
                                        <img src="<?= $latestNewsModel->getTitleImageUrl(100, 80) ?>" alt="audi" class="img-responsive pull-right" />
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="b-blog__aside-reviews-posts-one-info">
                                            <p><?= $latestNewsModel->i18n()->header ?></p>
                                            <div class="b-blog__aside-popular-posts-one-date">
                                                <?= Yii::$app->formatter->asDate($latestNewsModel->created_at) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="b-blog__posts">
                    <?php
                    echo ListView::widget([
                        'options' => ['class' => 'b-blog__posts'],
                        'dataProvider' => $provider,
                        'layout' => "{items}\n{pager}",
                        'itemOptions' => ['class' => 'b-blog__posts-one wow zoomInUp', 'data-wow-delay' => '0.3s'],
                        'pager' => [
                            'class' => 'frontend\widgets\CustomPager',
                            'options' => ['class' => 'b-items__pagination-main'],
                            'prevPageCssClass' => 'm-left',
                            'nextPageCssClass' => 'm-right',
                            'activePageCssClass' => 'm-active',
                            'wrapperOptions' => ['class' => 'b-items__pagination wow zoomInUp', 'data-wow-delay' => '0.5s']
                        ],
                        'itemView' => '_news',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div><!--b-blog-->