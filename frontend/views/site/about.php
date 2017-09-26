<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\models\Page;

$this->title = Yii::t('app', 'About Us');
$appData = AppData::getData();
$latestNews = Page::find()->active()->news()->limit(3)->orderBy('id desc')->all();

?>
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= $this->title ?></h1>
    </div>
</section><!--b-pageHeader-->

<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            $this->title
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->

<section class="b-best">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="b-best__info">
                    <header class="s-lineDownLeft b-best__info-head">
                        <h2 class="wow zoomInUp" data-wow-delay="0.5s"><?= $appData['aboutUsHeader'] ?></h2>
                    </header>
                    <p class="wow zoomInUp" data-wow-delay="0.5s"><?= $appData['aboutUs'] ?></p>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <?php if($appData['aboutUsPhoto']): ?>
                    <img class="img-responsive center-block wow zoomInUp" data-wow-delay="0.5s" alt="best" src="<?= $appData['aboutUsPhoto']->getThumbnail(555, 336, 'inset') ?>" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</section><!--b-best-->


<section class="b-what s-shadow m-home">
    <div class="container">
        <h3 class="s-titleBg wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'Everything you need to know') ?></h3><br />
        <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'Auto news') ?></h2>
        <div class="row">
            <?php foreach ($latestNews as $new): ?>
                <div class="col-sm-4 col-xs-12">
                    <div class="b-world__item wow zoomInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                        <a href="<?= $new->getUrl() ?>">
                            <img class="hover-light-img img-responsive" src="<?= $new->getTitleImageUrl(370, 200) ?>" alt="<?= $new->i18n()->header ?>" />
                        </a>
                        <div class="b-world__item-val">
                            <span class="b-world__item-val-title"><?= Yii::$app->formatter->asDate($new->created_at) ?></span>
                        </div>
                        <h2>
                            <a href="<?= $new->getUrl() ?>">
                                <?= $new->i18n()->header ?>
                            </a>
                        </h2>
                        <p><?= $new->i18n()->description ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section><!--b-what-->