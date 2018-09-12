<?php

use common\models\Specification;
use common\models\Product;
use common\models\Page;
use common\models\Teaser;
use common\models\AppData;
use common\models\MainPage;
use common\models\ProductMake;
use yii\helpers\Html;
use common\helpers\Url;
use frontend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $sliders common\models\Slider[] */
/* @var $productModel common\models\Product */
/* @var $specModels common\models\Specification */

$this->registerMetaData();
$this->registerJs("require(['controllers/site/searchForm']);", \yii\web\View::POS_HEAD);
$this->registerJsFile("/js/modernizm.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('/js/search_main.js',  ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile("/build/controllers/site/searchForm.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/readmore.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/owl.carousel.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/owl.lazyload.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/owl.support.modernizr.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
 $(document).ready(function(){
 var ScreenWidth = screen.width;
if (ScreenWidth < 767){
 $('#b-makers__list__main').readmore({
    speed: 75,
    maxHeight: 300,
    moreLink: '<a href=\"#\" id=\"more_mark\">Показать все марки <i style=\"margin-left: 7px;\" class=\"fa fa-long-arrow-down\" aria-hidden=\"true\"></i></a>',
    lessLink: '<a href=\"#\" id=\"roll_up_mark_category\">Скрыть</a>',
});
}
});
", \yii\web\View::POS_HEAD);
AppAsset::register($this);

$latestNews = Page::find()->andWhere(['not', ['main_image' => null]])->active()->news()->limit(6)->orderBy('id desc')->all();

?>
<section class="b-search">
    <div class="container">
        <?= $this->render('_searchForm', $_params_) ?>
    </div>
</section><!--b-search-->
<div class="main_page">
    <?php
    // var_dump(Yii::$app->cache->exists('main_page'));
    if (Yii::$app->cache->exists('main_page')) {
        echo Yii::$app->cache->get('main_page');
    } else {
        ob_start();
        ?>
        <section class="b-slider">
            <div id="carousel" class="slide carousel carousel-fade">
                <div class="carousel-inner">
                    <?php foreach ($sliders as $key => $slider): ?>
                        <div class="item <?= $key === 0 ? 'active' : '' ?>">
                            <img style="max-height: 900px" src="<?= $slider->getTitleImageUrl(1920, 800) ?>"
                                 alt="sliderImg"/>

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
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control right" href="#carousel" data-slide="next">
                    <span class="fa fa-angle-right m-control-right"></span>
                </a>
                <a class="carousel-control left" href="#carousel" data-slide="prev">
                    <span class="fa fa-angle-left m-control-left"></span>
                </a>
            </div>
        </section>
        <!--b-slider-->
        <section class="b-makers" id="b-makers">
            <div class="container">
                <div class="row col-lg-12">
                    <span class="all_mark">Все марки</span>
                    <div class="b-makers__list b-makers__list__main" id="b-makers__list__main"
                         style="height: auto!important;">
                        <?php
                        $modelAuto = ProductMake::getMakesListWithId(2, true);
                        sort($modelAuto);
                        foreach ($modelAuto as $maker) {
                            ?>
                            <div class="b-makers__item">
                                <a href='<?= Url::UrlCategoryBrand(URL::CARS, $maker['name']) ?>'>
                                    <?php if ($maker['url_logo'] != null):
                                        ?>
                                        <span class="logo_makes" style="background-image: url('/theme/images/logoAutoMain/<?php echo $maker['url_logo'];?>');"></span>
                                    <?
                                    endif;
                                    ?>
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
                                <a href='<?= Url::UrlCategoryBrand(Url::MOTO, $maker['name']) ?>'>
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
                    <div class="container">
                        <h2 class="col-md-10 col-sm-10 col-xs-9 col-sm-10">
                            <a href="/cars/company">Автомобили компании</a>
                            <a href="/cars/company"
                               class="show-all visible-md visible-lg visible-xl"><?= Yii::t('app', 'Show all') ?> </a>

                        </h2>
                        <div class="owl-controls clickable js-featured-vehicles-caruosel-nav featured-vehicles-controls owl-buttons col-md-2 col-xs-3 col-sm-2 text-right">
                            <div class="owl-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
                            <div class="owl-next" style="margin-left: 0 !important;"><i class="fa fa-chevron-right"
                                                                                        aria-hidden="true"></i></div>
                        </div>
                    </div>

                </div>
                <div id="carousel-small" class="carousel-product js-featured-vehicles-caruosel" data-items="4"
                     data-navigation="true" data-auto-play="true" data-stop-on-hover="true" data-items-desktop="4"
                     data-items-desktop-small="3" data-items-tablet="2" data-items-tablet-small="1">
                    <?php foreach ($latestAutosCompany as $latestAuto): ?>
                        <div>
                            <div class="b-featured__item">
                                <a href="<?= Url::UrlShowProduct($latestAuto->id) ?>">
                                    <span class="m-premium"></span>
                                    <img class="hover-light-img"
                                         src="<?= $latestAuto->getTitleImageUrl(768, 453) ?>"
                                         alt="<?= Html::encode($latestAuto->getFullTitle()) ?>"/>
                                </a>
                                <div class="inner_container">
                                    <div class="h5">
                                        <a
                                                href="<?= Url::UrlShowProduct($latestAuto->id) ?>"><?= $latestAuto->getFullTitle() ?></a>
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
                    <?php
                    endforeach;
                    unset ($latestAutosCompany);
                    unset($latestAuto);
                    ?>
                </div>
            </div>
        </section>
        <!--b-featured-->
        <hr>
        <section class="b-featured b-featured-latest">
            <div class="container">
                <div class="top col-md-12">
                    <div class="container">
                        <h2 class="col-md-10 col-xs-9 col-sm-10">
                            <a href="/cars">Частные объявления</a>
                            <a href="/cars"
                               class="show-all visible-md visible-lg visible-xl"><?= Yii::t('app', 'Show all') ?></a>
                        </h2>
                        <div class="owl-controls clickable js-featured-vehicles-caruosel-nav-2 featured-vehicles-controls col-md-2 col-xs-3 col-sm-2 text-right">
                            <div class="owl-buttons">
                                <div class="owl-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
                                <div class="owl-next" style="margin-left: 0 !important;"><i class="fa fa-chevron-right"
                                                                                            aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="carousel-small-2" class="carousel-product  owl-carousel js-featured-vehicles-caruosel-2"
                     data-items="4"
                     data-navigation="true" data-auto-play="true" data-stop-on-hover="true" data-items-desktop="4"
                     data-items-desktop-small="4" data-items-tablet="3" data-items-tablet-small="2">
                    <?php foreach ($latestAutosPrivate as $latestAuto): ?>
                        <div>
                            <div class="b-featured__item">
                                <a href="<?= Url::UrlShowProduct($latestAuto->id) ?>">
                                    <img class="hover-light-img"
                                         src="<?= $latestAuto->getTitleImageUrl(267, 180) ?>"
                                         alt="<?= Html::encode($latestAuto->getFullTitle()) ?>"/>
                                    <span class="m-premium"></span>
                                </a>
                                <div class="inner_container">
                                    <div class="h5"><a
                                                href="<?= Url::UrlShowProduct($latestAuto->id) ?>"><?= $latestAuto->getFullTitle() ?></a>
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
                    <?php endforeach;
                    unset ($latestAutosPrivate);
                    unset($latestAuto);
                    ?>
                </div>
            </div>
        </section>
        <?php
        $content = ob_get_contents();
        Yii::$app->cache->set('main_page', $content);
        ob_end_flush();
    }
    ?>
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
                    <p class="visible-md visible-lg visible-xl">Расчет ежемесячного платежа </p>
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
                    <p class="visible-md visible-lg visible-xl">Заполните анкету и мы свяжемся с Вами</p>
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
        <div class="news_mobile_container container">
            <h2><a href="/news"><?= Yii::t('app', 'Auto news') ?></a></h2>
            <h6><?= Yii::t('app', 'Everything you need to know') ?></h6>
            <br/>
            <div class="row">
                <div class="visible-sm visible-md visible-lg visible-xl col-md-12">
                    <?php
                    foreach ($latestNews as $news):
                        ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="b-world__item">
                                <a href="<?= $news->getUrl() ?>">
                                    <div class="image_news"
                                         style=" background: url(<?= $news->getTitleImage(370, 200) ?>) center no-repeat;">
                                        <span class="title">  <?= $news->i18n()->header ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                    endforeach; ?>
                </div>
                <noindex>
                    <div class="news_block_mobile col-md-8 visible-xs">
                        <?php
                        $i = 0;
                        foreach ($latestNews as $news):
                            ?>

                            <? if ($i == 0) { ?>
                            <div class="main_news col-xs-12">
                                <div class="b-world__item">
                                    <a href="<?= $news->getUrl() ?>">
                                        <div class="image_news"
                                             style=" background: url(<?= $news->getTitleImage(370, 200) ?>) center no-repeat;">
                                            <span class="title">  <?= $news->i18n()->header ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="additional_news col-xs-12">
                                <div class="b-world__item">
                                    <a href="<?= $news->getUrl() ?>">
                                        <div class="image_news col-xs-4"
                                             style=" background: url(<?= $news->getTitleImage(370, 200) ?>) left no-repeat;">
                                        </div>
                                    </a>
                                    <div class="description col-xs-8">
                                        <span class="title">  <?= $news->i18n()->header ?></span>
                                        <span class="date">  <?= Yii::$app->formatter->asDate($news->created_at) ?> </span>
                                    </div>
                                </div>
                            </div>

                            <?php

                        }
                            $i++;
                        endforeach; ?>
                        <span class="visible-xs visible-sm"><a class="read_more_news"
                                                               href="/news">Показать все</a></span>
                    </div>
                </noindex>
            </div>
    </section>
</div>