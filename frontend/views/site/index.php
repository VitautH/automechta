<?php

use common\models\Specification;
use common\models\Product;
use common\models\Page;
use common\models\Teaser;
use common\models\AppData;
use common\models\MainPage;
use common\models\ProductMake;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $sliders common\models\Slider[] */
/* @var $productModel common\models\Product */
/* @var $specModels common\models\Specification */

$this->registerMetaData();
$this->registerJs("require(['controllers/site/index']);", \yii\web\View::POS_HEAD);
$highPriorityProducts = Product::find()->highPriority()->orderBy('product.id DESC')->active()->limit(10)->all();
$latestNews = Page::find()->active()->news()->limit(3)->orderBy('id desc')->all();
$teasers = Teaser::find()->active()->orderBy('lft')->all();
$appData = AppData::getData();
$topMakers = ProductMake::find()->top()->limit(8)->all();
$mainPageData = MainPage::getData();
?>
<?
if ($this->beginCache($id)) {
    ?>
    <section class="b-slider">
        <div id="carousel" class="slide carousel carousel-fade">
            <div class="carousel-inner">
                <?php foreach ($sliders as $key => $slider): ?>
                    <div class="item <?= $key === 0 ? 'active' : '' ?>">
                        <img style="max-height: 900px" src="<?= $slider->getTitleImageUrl(1920, 800) ?>"
                             alt="sliderImg"/>
                        <div class="container">
                            <div class="carousel-caption b-slider__info b-slider__info-text-position-<?= $slider->text_position ?>">
                                <div class="h3"><?= $slider->i18n()->title ?></div>
                                <h2><?= $slider->i18n()->header ?></h2>
                                <p><?= $slider->i18n()->caption ?></p>
                                <a class="btn m-btn" href="<?= $slider->link ?>"><?= $slider->i18n()->button_text ?>
                                    <span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control right" href="#carousel" data-slide="next">
                <span class="fa fa-angle-right m-control-right"></span>
            </a>
            <a class="carousel-control left" href="#carousel" data-slide="prev">
                <span class="fa fa-angle-left m-control-left"></span>
            </a>
        </div>
    </section><!--b-slider-->

    <section class="b-search">
        <div class="container">
            <?= $this->render('_searchForm', $_params_) ?>
        </div>
    </section><!--b-search-->
    <section class="b-makers">
        <div class="container">
            <div class="row col-lg-12">
                <div class="b-makers__list">
                    <?php
                    $modelAuto = ProductMake::getMakesListWithId(2, true);
                    sort($modelAuto);
                    foreach ($modelAuto as $maker) {
                        ?>
                        <div class="b-makers__item">
                            <a href='<?php echo '/brand/2/' . $maker['name']; ?>'>
                                <?php echo $maker['name']; ?>
                                <span class="b-makers__item-number"><?php echo Product::find()->where(['AND', ['make' => $maker['id']], ['status' => 1]])->count(); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    unset($modelAuto);
                    ?>
                    <?php
                    $modelMotorbike= ProductMake::getMakesListWithId(3, true);
                    sort($modelMotorbike);
                    foreach ($modelMotorbike as $maker) {
                        ?>
                        <div class="b-makers__item">
                            <a href='<?php echo '/brand/3/' . $maker['name']; ?>'>
                                <?php echo $maker['name']; ?>
                                <span class="b-makers__item-number"><?php echo Product::find()->where(['AND', ['make' => $maker['id']], ['status' => 1]])->count(); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    unset($modelMotorbike);
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="b-featured">
        <div class="container">
            <h2 class="s-title wow zoomInUp" data-wow-delay="0.3s">
                <a href="/catalog"><?= Yii::t('app', 'Featured Vehicles') ?></a>
            </h2>
            <div id="carousel-small" class="owl-carousel js-featured-vehicles-caruosel" data-items="4"
                 data-navigation="true" data-auto-play="true" data-stop-on-hover="true" data-items-desktop="4"
                 data-items-desktop-small="4" data-items-tablet="3" data-items-tablet-small="2">
                <?php foreach ($highPriorityProducts as $highPriorityProduct): ?>
                    <div>
                        <div class="b-featured__item wow rotateIn" data-wow-delay="0.3s" data-wow-offset="150">
                            <a href="<?= $highPriorityProduct->getUrl() ?>">
                                <img class="hover-light-img"
                                     src="<?= $highPriorityProduct->getTitleImageUrl(210, 113) ?>"
                                     alt="<?= Html::encode($highPriorityProduct->getFullTitle()) ?>"/>
                                <span class="m-premium"><?= Yii::t('app', 'On credit') ?></span>
                            </a>
                            <div class="h5"><a
                                        href="<?= $highPriorityProduct->getUrl() ?>"><?= $highPriorityProduct->getFullTitle() ?></a>
                            </div>
                            <div class="b-featured__item-price">
                                <?= Yii::$app->formatter->asDecimal($highPriorityProduct->getByrPrice()) ?> BYN
                            </div>
                            <div class="b-featured__item-price-usd">
                                <?= Yii::$app->formatter->asDecimal($highPriorityProduct->getUsdPrice()) ?>
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($highPriorityProduct->getSpecifications(Specification::PRIORITY_HIGHEST) as $productSpec): ?>
                                <?php $spec = $productSpec->getSpecification()->one(); ?>
                                <div class="b-featured__item-count" title="<?= $spec->i18n()->name ?>">
                                    <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>"/>
                                    <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                </div>
                            <?php endforeach; ?>
                            <div class="b-featured__item-links">
                                <?php foreach ($highPriorityProduct->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                    <?php $spec = $productSpec->getSpecification()->one(); ?>
                                    <a href="#"
                                       title="<?= $spec->i18n()->name ?>"><?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="owl-controls clickable js-featured-vehicles-caruosel-nav featured-vehicles-controls">
                <div class="owl-buttons">
                    <div class="owl-prev"></div>
                    <a href="/catalog" class=""><?= Yii::t('app', 'Show all') ?></a>
                    <div class="owl-next" style="margin-left: 0 !important;"></div>
                </div>
            </div>
        </div>
    </section><!--b-featured-->
    <section class="b-featured b-featured-latest">
        <div class="container">
            <h2 class="s-title wow zoomInUp" data-wow-delay="0.3s">
                <a href="/brand/2">Частные объявления</a>
            </h2>
            <div id="carousel-small-2" class="owl-carousel js-featured-vehicles-caruosel-2" data-items="4"
                 data-navigation="true" data-auto-play="true" data-stop-on-hover="true" data-items-desktop="4"
                 data-items-desktop-small="4" data-items-tablet="3" data-items-tablet-small="2">
                <?php $latestAutos = Product::find()->active()->orderBy('id DESC')->limit(10)->all(); ?>
                <?php foreach ($latestAutos as $latestAuto): ?>
                    <div>
                        <div class="b-featured__item wow rotateIn" data-wow-delay="0.3s" data-wow-offset="150">
                            <a href="<?= $latestAuto->getUrl() ?>">
                                <img class="hover-light-img" src="<?= $latestAuto->getTitleImageUrl(210, 113) ?>"
                                     alt="<?= Html::encode($latestAuto->getFullTitle()) ?>"/>
                                <span class="m-premium"><?= Yii::t('app', 'On credit') ?></span>
                            </a>
                            <div class="h5"><a
                                        href="<?= $latestAuto->getUrl() ?>"><?= $latestAuto->getFullTitle() ?></a></div>
                            <div class="b-featured__item-price">
                                <?= Yii::$app->formatter->asDecimal($latestAuto->getByrPrice()) ?> BYN
                            </div>
                            <div class="b-featured__item-price-usd">
                                <?= Yii::$app->formatter->asDecimal($latestAuto->getUsdPrice()) ?>
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($latestAuto->getSpecifications(Specification::PRIORITY_HIGHEST) as $productSpec): ?>
                                <?php $spec = $productSpec->getSpecification()->one(); ?>
                                <div class="b-featured__item-count" title="<?= $spec->i18n()->name ?>">
                                    <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>"/>
                                    <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                </div>
                            <?php endforeach; ?>
                            <div class="b-featured__item-links">
                                <?php foreach ($latestAuto->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                    <?php $spec = $productSpec->getSpecification()->one(); ?>
                                    <a href="#"
                                       title="<?= $spec->i18n()->name ?>"><?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="owl-controls clickable js-featured-vehicles-caruosel-nav-2 featured-vehicles-controls">
                <div class="owl-buttons">
                    <div class="owl-prev"></div>
                    <a href="/brand/search" class=""><?= Yii::t('app', 'Show all') ?></a>
                    <div class="owl-next" style="margin-left: 0 !important;"></div>
                </div>
            </div>
        </div>
    </section><!--b-featured b-featured-latest-->

    <section class="b-asks">
        <div class="container">
            <div class="row">
                <?php foreach ($teasers as $teaser): ?>
                    <div class="col-md-6 col-sm-10 col-sm-offset-1 col-md-offset-0 col-xs-12">
                        <a href="<?= $teaser->link ?>" class="b-asks__first wow zoomInLeft" data-wow-delay="0.3s"
                           data-wow-offset="100">
                            <div class="b-asks__first-circle">
                                <?php if ($teaser->hasTitleImage()): ?>
                                    <img class="hover-light-img img-responsive"
                                         src="<?= $teaser->getTitleImageUrl(32, 32) ?>"
                                         alt="<?= $teaser->i18n()->header ?>"/>
                                <?php endif; ?>
                            </div>
                            <div class="b-asks__first-info">
                                <h2><?= $teaser->i18n()->header ?></h2>
                                <p><?= $teaser->i18n()->caption ?></p>
                            </div>
                            <div class="b-asks__first-arrow">
                                <span class="fa fa-angle-right"></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section><!--b-asks-->

    <section class="b-welcome">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-2 col-sm-6 col-xs-12">
                    <div class="b-welcome__text wow fadeInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                        <h2><?= $mainPageData["mainPageTeaserTitle"] ?></h2>
                        <div class="h3"><?= $mainPageData["mainPageTeaserHeader"] ?></div>
                        <p>
                            <?= $mainPageData["mainPageTeaserCaption"] ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <div class="b-welcome__services wow fadeInRight" data-wow-delay="0.3s" data-wow-offset="100">
                        <div class="row">
                            <?php for ($teaserNum = 1; $teaserNum <= 4; $teaserNum++): ?>
                                <a href="<?= $mainPageData["mainPageTeaser{$teaserNum}url"] ?>"
                                   class="col-xs-6 m-padding">
                                    <div class="b-welcome__services-auto">
                                        <div class="b-welcome__services-img m-auto">
                                            <?= Html::img(Yii::$app->uploads->getThumbnail($mainPageData["mainPageTeaser{$teaserNum}image"]->hash, 50, 50)) ?>
                                        </div>
                                        <div class="h3"><?= $mainPageData["mainPageTeaser{$teaserNum}title"] ?></div>
                                    </div>
                                </a>
                                <?php if ($teaserNum == 2): ?>
                                    <div class="col-xs-12 text-center">
                                        <span class="b-welcome__services-circle"></span>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--b-welcome-->

    <section class="b-world">
        <div class="container">
            <h6 class="wow zoomInLeft" data-wow-delay="0.3s"
                data-wow-offset="100"><?= Yii::t('app', 'Everything you need to know') ?></h6><br/>
            <h2 class="s-title wow zoomInRight" data-wow-delay="0.3s" data-wow-offset="100"><a
                        href="/news"><?= Yii::t('app', 'Auto news') ?></a></h2>
            <div class="row">
                <?php foreach ($latestNews as $new): ?>
                    <div class="col-sm-4 col-xs-12">
                        <div class="b-world__item wow zoomInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                            <a href="<?= $new->getUrl() ?>">
                                <img class="hover-light-img img-responsive"
                                     src="<?= $new->getTitleImageUrl(370, 200) ?>" alt="<?= $new->i18n()->header ?>"/>
                            </a>
                            <div class="b-world__item-val">
                                <span class="b-world__item-val-title"><?= Yii::$app->formatter->asDate($new->created_at) ?></span>
                            </div>
                            <div class="h2"><?= $new->i18n()->header ?></div>
                            <p><?= $new->i18n()->description ?></p>
                            <a href="<?= $new->getUrl() ?>" class="btn m-btn"><?= Yii::t('app', 'Read more') ?><span
                                        class="fa fa-angle-right"></span></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section><!--b-world-->

    <section class="b-asks">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p class="b-asks__call wow zoomInUp" data-wow-delay="0.3s"
                       data-wow-offset="100"><?= Yii::t('app', 'QUESTIONS? CALL US') ?> : <span><a
                                    href="tel:<?= $appData['phone'] ?>"
                                    class="inheritColor"><?= $appData['phone'] ?></a></span></p>
                </div>
            </div>
        </div>
    </section><!--b-asks-->

    <?//= $this->render('_productList', $_params_) ?>
    <?php
$this->endCache();
}
?>
