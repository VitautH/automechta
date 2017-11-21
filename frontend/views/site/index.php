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
$this->registerJsFile("@web/js/readmore.js");
$this->registerJs("require(['controllers/site/index']);", \yii\web\View::POS_HEAD);
$this->registerJs("    
 $(document).ready(function(){
 var ScreenWidth = screen.width; 
if (ScreenWidth < 767){
 $('#b-makers__list__main').readmore({
    speed: 75,
    maxHeight: 300,
    moreLink: '<a href=\"#\" id=\"more_mark\">Показать все марки <i style=\"margin-left: 7px;\" class=\"fa fa-long-arrow-down\" aria-hidden=\"true\"></i></a>',
    lessLink: '<a href=\"#\" id=\"roll_up_mark\">Скрыть</a>',
});
}
});
", \yii\web\View::POS_HEAD);
$highPriorityProducts = Product::find()->highPriority()->orderBy('product.id DESC')->active()->limit(10)->all();
$latestNews = Page::find()->active()->news()->limit(5)->orderBy('id desc')->all();
$mainNews = $latestNews[0];
$teasers = Teaser::find()->active()->orderBy('lft')->all();
$appData = AppData::getData();
$topMakers = ProductMake::find()->top()->limit(8)->all();
$mainPageData = MainPage::getData();

if ($this->beginCache($id)) {
    ?>
    <section class="b-search">
        <div class="container">
            <?= $this->render('_searchForm', $_params_) ?>
        </div>
    </section><!--b-search-->
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
                                <h2>
                                    <?= $slider->i18n()->header ?> <a href="<?= $slider->link ?>" class="btn m-btn">
                                        <?= $slider->i18n()->button_text ?>
                                        <i class="fa fa-angle-double-right" aria-hidden="true"
                                           style="margin-left: 10px; font-size: 18px;"></i>
                                    </a>
                                </h2>
                                <p><?= $slider->i18n()->caption ?> </p>
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
    <section class="b-makers" id="b-makers">
        <div class="container">
            <div class="row col-lg-12">
                <div class="b-makers__list b-makers__list__main" id="b-makers__list__main">
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
                    $modelMotorbike = ProductMake::getMakesListWithId(3, true);
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
            <div class="top col-md-12 col-xs-12 col-sm-12">
                <h2 class="col-md-4 col-sm-12 col-xs-12 col-sm-12" data-wow-delay="0.3s">
                    <a href="/catalog">АВТОМОБИЛИ КОМПАНИИ</a>
                </h2>
                <div class="owl-controls clickable js-featured-vehicles-caruosel-nav featured-vehicles-controls owl-buttons col-md-2 col-md-offset-6 col-xs-3 col-sm-3 col-xs-offset-0">

                    <div class="owl-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
                    <div class="owl-next" style="margin-left: 0 !important;"><i class="fa fa-chevron-right"
                                                                                aria-hidden="true"></i></div>
                </div>
            </div>
            <div id="carousel-small" class="owl-carousel js-featured-vehicles-caruosel" data-items="4"
                 data-navigation="true" data-auto-play="true" data-stop-on-hover="true" data-items-desktop="4"
                 data-items-desktop-small="4" data-items-tablet="3" data-items-tablet-small="2">
                <?php foreach ($highPriorityProducts as $highPriorityProduct): ?>
                    <div>
                        <div class="b-featured__item wow rotateIn" data-wow-delay="0.3s" data-wow-offset="150">
                            <a href="<?= $highPriorityProduct->getUrl() ?>">
                                <span class="m-premium"><?= Yii::t('app', 'On credit') ?></span>
                                <img class="hover-light-img" width="170" height="170"
                                     src="<?= $highPriorityProduct->getTitleImageUrl(640, 480) ?>"
                                     alt="<?= Html::encode($highPriorityProduct->getFullTitle()) ?>"/>
                            </a>
                            <div class="inner_container">
                                <div class="h5">
                                    <a
                                            href="<?= $highPriorityProduct->getUrl() ?>"><?= $highPriorityProduct->getFullTitle() ?></a>
                                </div>
                                <div class="b-featured__item-price">
                                    <?= Yii::$app->formatter->asDecimal($highPriorityProduct->getByrPrice()) ?> BYN
                                </div>
                                <div class="b-featured__item-price-usd">
                                    <?= Yii::$app->formatter->asDecimal($highPriorityProduct->getUsdPrice()) ?> $
                                </div>
                                <div class="clearfix"></div>
                                <?php foreach ($highPriorityProduct->getSpecifications(Specification::PRIORITY_HIGHEST) as $productSpec): ?>
                                    <?php $spec = $productSpec->getSpecification()->one(); ?>
                                    <div class="b-featured__item-count" title="<?= $spec->i18n()->name ?>">
                                        <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>"/>
                                        Пробег: <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                    </div>
                                <?php endforeach; ?>
                                <ul class="b-featured__item-links">
                                    <?php foreach ($highPriorityProduct->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                        <?php $spec = $productSpec->getSpecification()->one(); ?>
                                        <li>
                                            <i class="fa fa-square" aria-hidden="true"></i>
                                            <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="/catalog" class="btn"><?= Yii::t('app', 'Show all') ?> <i class="fa fa-angle-double-right"
                                                                               aria-hidden="true" style="margin-left: 10px;
    font-size: 18px;"></i></a>
        </div>
    </section>
    <!--b-featured-->
    <section class="b-featured b-featured-latest">
        <div class="container">
            <div class="top col-md-12">
                <h2 class="col-md-4 col-xs-12 col-sm-12" data-wow-delay="0.3s">
                    <a href="/brand/2">Частные объявления</a>
                </h2>
                <div class="owl-controls clickable js-featured-vehicles-caruosel-nav-2 featured-vehicles-controls col-md-2 col-md-offset-6 col-xs-offset-0 col-xs-offset-0 col-xs-3 col-sm-3">
                    <div class="owl-buttons">
                        <div class="owl-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
                        <div class="owl-next" style="margin-left: 0 !important;"><i class="fa fa-chevron-right"
                                                                                    aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
            <div id="carousel-small-2" class="owl-carousel js-featured-vehicles-caruosel-2" data-items="4"
                 data-navigation="true" data-auto-play="true" data-stop-on-hover="true" data-items-desktop="4"
                 data-items-desktop-small="4" data-items-tablet="3" data-items-tablet-small="2">
                <?php $latestAutos = Product::find()->active()->orderBy('id DESC')->limit(10)->all(); ?>
                <?php foreach ($latestAutos as $latestAuto): ?>
                    <div>
                        <div class="b-featured__item wow rotateIn" data-wow-delay="0.3s" data-wow-offset="150">
                            <a href="<?= $latestAuto->getUrl() ?>">
                                <img class="hover-light-img" width="170" height="170"
                                     src="<?= $latestAuto->getTitleImageUrl(640, 480) ?>"
                                     alt="<?= Html::encode($latestAuto->getFullTitle()) ?>"/>
                                <span class="m-premium"><?= Yii::t('app', 'On credit') ?></span>
                            </a>
                            <div class="inner_container">
                                <div class="h5"><a
                                            href="<?= $latestAuto->getUrl() ?>"><?= $latestAuto->getFullTitle() ?></a>
                                </div>
                                <div class="b-featured__item-price">
                                    <?= Yii::$app->formatter->asDecimal($latestAuto->getByrPrice()) ?> BYN
                                </div>
                                <div class="b-featured__item-price-usd">
                                    <?= Yii::$app->formatter->asDecimal($latestAuto->getUsdPrice()) ?> $
                                </div>
                                <div class="clearfix"></div>
                                <?php foreach ($latestAuto->getSpecifications(Specification::PRIORITY_HIGHEST) as $productSpec): ?>
                                    <?php $spec = $productSpec->getSpecification()->one(); ?>
                                    <div class="b-featured__item-count" title="<?= $spec->i18n()->name ?>">
                                        <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>"/>
                                        Пробег: <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                    </div>
                                <?php endforeach; ?>
                                <ul class="b-featured__item-links">
                                    <?php foreach ($latestAuto->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                        <li>
                                            <i class="fa fa-square" aria-hidden="true"></i>
                                            <?php $spec = $productSpec->getSpecification()->one(); ?>
                                            <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="/brand/2" class="btn"><?= Yii::t('app', 'Show all') ?> <i class="fa fa-angle-double-right"
                                                                               aria-hidden="true" style="margin-left: 10px;
    font-size: 18px;"></i></a>
        </div>
    </section>
    <!--b-featured b-featured-latest-->
    <section class="b-asks">
        <div class="block_1">
            <div class="inner_container col-md-10 col-sm-10 col-sm-offset-1 col-md-offset-1 col-xs-12">
                <div class="b-asks__first-circle">
                    <i class="fa fa-calculator" aria-hidden="true"></i>
                </div>
                <div class="b-asks__first-info">
                    <h2>Кредитный калькулятор</h2>
                    <p></p>
                    <p>Расчет ежемесячного платежа </p>
                    <p></p>
                    <br>
                    <a href="/tools/calculator" class="btn" data-wow-delay="0.3s" data-wow-offset="100">
                        РАССЧИТАТЬ <i class="fa fa-angle-double-right"
                                      aria-hidden="true" style="margin-left: 10px;
    font-size: 18px;"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="block_2">
            <div class="inner_container col-md-10 col-sm-10 col-sm-offset-1 col-md-offset-1 col-xs-12">
                <div class="b-asks__first-circle">
                    <i class="fa fa-university" aria-hidden="true"></i>
                </div>
                <div class="b-asks__first-info">
                    <h2>онлайн заявка на кредит</h2>
                    <p></p>
                    <p>Заполните анкету и мы свяжемся с Вами</p>
                    <p></p>
                    <br>
                    <a href="/tools/credit-application" class="btn" data-wow-delay="0.3s" data-wow-offset="100">
                        ЗАПОЛНИТЬ
                        <i class="fa fa-angle-double-right"
                           aria-hidden="true" style="margin-left: 10px;
    font-size: 18px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--b-asks-->
    <section class="b-world">
        <div class="container">
            <h2 class="" data-wow-delay="0.3s" data-wow-offset="100"><a
                        href="/news"><?= Yii::t('app', 'Auto news') ?></a></h2>
            <h6 class="" data-wow-delay="0.3s"
                data-wow-offset="100"><?= Yii::t('app', 'Everything you need to know') ?></h6><br/>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4 col-xs-12 hidden-xs hidden-sm">
                        <div class="b-world__item wow zoomInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                            <div class="b-world__item wow zoomInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                                <a href="<?= $mainNews->getUrl() ?>">
                                    <div class="main_image_news"
                                         style=" background: url(<?= $mainNews->getTitleImageUrl(380, 400) ?>) center no-repeat;">
                                        <span class="title">  <?= $mainNews->i18n()->header ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <?php
                        $i = 1;
                        foreach ($latestNews as $news): ?>
                            <? if ($i !== 1): ?>
                                <div class="col-md-6 col-xs-12">
                                    <div class="b-world__item wow zoomInLeft" data-wow-delay="0.3s"
                                         data-wow-offset="100">
                                        <a href="<?= $news->getUrl() ?>">
                                            <div class="image_news"
                                                 style=" background: url(<?= $news->getTitleImageUrl(370, 200) ?>) center no-repeat;">
                                                <span class="title">  <?= $news->i18n()->header ?></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            endif;
                            $i++;
                        endforeach; ?>
                        <span class="visible-xs visible-sm"><a class="read_more_news" href="/news">Показать все</a></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--b-world-->
    <?php
    $this->endCache();
}
?>