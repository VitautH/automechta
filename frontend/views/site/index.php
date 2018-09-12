<?

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
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $sliders common\models\Slider[] */
/* @var $productModel common\models\Product */
/* @var $specModels common\models\Specification */

$this->registerMetaData();
$this->registerJsFile('@web/build/controllers/site/modal-main.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/readmore.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/build/controllers/site/main-searchForm.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(" var ScreenWidth = screen.width;
        if (ScreenWidth < 3000) {
            $('.brands').readmore({
                speed: 75,
                maxHeight: 350,
                moreLink: '<a class=\"show-all\" href=\"#\">Показать все <i class=\"fas fa-chevron-right ml-2\"></i></a>',
                lessLink: '<a class=\"show-all\" href=\"#\">Скрыть <i class=\"fas fa-chevron-right ml-2\"></i></a>',
            });
        }
        $(document).ready(function(){
  $('#show-how-it-works').click(function (e){
            e.preventDefault();
            $('.how-it-works-hidden').show();
            $('#show-how-it-works').hide();
        }); });", \yii\web\View::POS_HEAD);


AppAsset::register($this);

?>
<main>
    <div class="banner text-center text-lg-left">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-4">
                    <h2>Помогаем выбрать авто в кредит в Беларуси</h2>
                    <a href="<?= Url::to(['/avto-v-kredit']); ?>" class="read-more-link">Читать <i
                                class="fas fa-chevron-right"></i></a>
                </div>
                <div class="col-12 col-md-8 col-lg-5 offset-lg-2 col-xl-4 offset-xl-3">
                    <?= $this->render('_new-searchForm', $_params_) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="categories">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <nav class="category-menu">
                        <ul>
                            <li>
                                <a href="<?= Url::to(['/cars/company']); ?>">
                                    <span class="category-img company"></span>
                                    <span class="category-name">Автомобили компании</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/cars']); ?>">
                                    <span class="category-img private"></span>
                                    <span class="category-name">Частные объявления</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/motos']); ?>">
                                    <span class="category-img moto"></span>
                                    <span class="category-name moto-title">Мототехника</span>
                                </a>
                            </li>
                            <li class="boat">
                                <a href="<?= Url::to(['/boat']); ?>">
                                    <span class="category-img boat"></span>
                                    <span class="category-name">Водный транспорт</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="all-brands">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-2 order-lg-1">
                    <div class="brands" id="b-makers">
                        <?php
                        $modelAuto = ProductMake::getMakesListHighPrirority(2, true);
                        sort($modelAuto);
                        foreach ($modelAuto as $maker) {
                            ?>
                            <div class="brand-item">
                                <a href='<?= Url::UrlCategoryBrand(URL::CARS, $maker['name']) ?>'>
                                    <?php if ($maker['url_logo'] != null):
                                        ?>
                                        <span class="brand-img "
                                              style="background-image: url('/theme/images/logoAutoMain/<?php echo $maker['url_logo']; ?>');"></span>
                                    <?
                                    endif;
                                    ?>
                                  <?php echo $maker['name']; ?>
                                    <span class="brand-amount"><?php echo Product::find()->where(['AND', ['make' => $maker['id']], ['status' => 1]])->count(); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        unset($modelAuto);
                        ?>
                        <?php
                        $modelMotorbike = ProductMake::getMakesListLowPrirority(2, true);
                        sort($modelMotorbike);
                        foreach ($modelMotorbike as $maker) {
                            ?>
                            <div class="brand-item">
                                <a href='<?= Url::UrlCategoryBrand(Url::CARS, $maker['name']) ?>'>
                                    <?php if ($maker['url_logo'] != null):
                                        ?>
                                        <span class="brand-img "
                                              style="background-image: url('/theme/images/logoAutoMain/<?php echo $maker['url_logo']; ?>');"></span>
                                    <?
                                    endif;
                                    ?>
                                    <?php echo $maker['name']; ?>
                                    <span class="brand-amount"><?php echo Product::find()->where(['AND', ['make' => $maker['id']], ['status' => 1]])->count(); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        unset($modelMotorbike);
                        ?>

                    </div>
                </div>
                <div class="hidden-mobile col-lg-3 order-1 order-lg-2">
                    <!-- Yandex.RTB R-A-288803-1 -->
                    <div id="yandex_rtb_R-A-288803-1"></div>
                    <script type="text/javascript">
                        (function(w, d, n, s, t) {
                            w[n] = w[n] || [];
                            w[n].push(function() {
                                Ya.Context.AdvManager.render({
                                    blockId: "R-A-288803-1",
                                    renderTo: "yandex_rtb_R-A-288803-1",
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
            </div>
        </div>
    </div>
    <?php
    if (Yii::$app->cache->exists('carousel')) {
        echo Yii::$app->cache->get('carousel');
    } else {
        ob_start();
        ?>
    <div class="carousel-cars">
        <div class="container">
            <ul class="nav nav-tabs row justify-content-between" id="myTab" role="tablist">
                <li class="nav-item col-lg-3 p-0">
                    <a class="nav-link active" id="company-cars-tab" data-toggle="tab"  href="#company-cars" role="tab"
                       aria-controls="company-cars" aria-selected="true">Авто компании</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" id="private-cars-tab" data-toggle="tab" href="#private-cars" role="tab"
                       aria-controls="private-cars" aria-selected="false">Частные авто</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" id="moto-tab" data-toggle="tab" href="#moto" role="tab" aria-controls="moto"
                       aria-selected="false">Мототехника</a>
                </li>
                <li class="nav-item col-lg-2 p-0">
                    <a class="nav-link" id="boat-tab" data-toggle="tab" href="#boat" role="tab" aria-controls="boat"
                       aria-selected="false">Водный транспорт</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" style="height: 425px" id="company-cars" role="tabpanel"
                     aria-labelledby="company-cars-tab">
                    <div class="loader"><i class="fas fa-spinner fa-spin"></i></div>
                    <div class="carousel slide hidden-mobile" data-ride="carousel" data-interval="false">
                        <div class="carousel-inner">
                            <div id="carousel-CompanyCars" class="row carousel-row">
                                <?php foreach ($carousels as $carousel):
                                    /*
                                    * Specification
                                    */
                                    $productSpecifications = $carousel->getSpecifications();
                                    $productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
                                        $specification = $productSpec->getSpecification()->one();
                                        return $specification->type != Specification::TYPE_BOOLEAN;
                                    });
                                    $productSpecificationsMain = array_values($productSpecificationsMain);
                                    $productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
                                        $specification = $productSpec->getSpecification()->one();
                                        return $specification->type == Specification::TYPE_BOOLEAN;
                                    });
                                    $productSpecificationsAdditional = array_values($productSpecificationsAdditional);
                                    foreach ($productSpecificationsAdditional as $key => $productSpecification) {
                                        $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
                                    }

                                    /*
                                    * Main Specification
                                    */
                                    $carouselSpec = [];
                                    foreach ($productSpecificationsMain as $i => $productSpec) {
                                        $spec = $productSpec->getSpecification()->one();
                                        $carouselSpec [$i] ['name'] = $spec->i18n()->name;
                                        $carouselSpec [$i] ['format'] = $productSpec->getFormattedValue();
                                        $carouselSpec [$i] ['unit'] = $spec->i18n()->unit;
                                    }
                                    ?>

                                    <div class="carousel-item">
                                        <div class="carousel-image">
                                            <a href="<?= Url::UrlShowProduct($carousel->id) ?>">
                                                <img src="<?php echo $carousel->getFullImage(); ?>"
                                                     alt="<?= Html::encode($carousel->getFullTitle()) ?>">
                                            </a>
                                        </div>
                                        <div class="car-description">
                                            <h5>
                                                <a href="<?= Url::UrlShowProduct($carousel->id) ?>"><?= $carousel->getFullTitle() ?></a>
                                            </h5>
                                            <span class="specifications">
                                                 <?php echo $carouselSpec[2]['format']; ?> см<sup>3</sup>,
                                                <?php echo $carouselSpec[4]['format']; ?>,
                                                <?php echo $carouselSpec[6]['format']; ?>,
                                                <?php echo $carouselSpec[1]['format']; ?>
                                            </span>
                                            <p><?= StringHelper::truncate($carousel->i18n()->seller_comments, 60, '...'); ?></p>
                                            <span class="price-rb"><?= Yii::$app->formatter->asDecimal($carousel->getByrPrice()) ?>
                                                BYN</span><span
                                                    class="price-dol"><?= Yii::$app->formatter->asDecimal($carousel->getUsdPrice()) ?>
                                                $</span>
                                        </div>
                                    </div>
                                <?
                                endforeach;
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-CompanyCars carousel  hidden-desktop">
                        <div class="carousel-inner">
                            <div class="row carousel-row">
                                <?php foreach ($carousels as $carousel):
                                    /*
                                   * Specification
                                   */
                                    $productSpecifications = $carousel->getSpecifications();
                                    $productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
                                        $specification = $productSpec->getSpecification()->one();
                                        return $specification->type != Specification::TYPE_BOOLEAN;
                                    });
                                    $productSpecificationsMain = array_values($productSpecificationsMain);
                                    $productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
                                        $specification = $productSpec->getSpecification()->one();
                                        return $specification->type == Specification::TYPE_BOOLEAN;
                                    });
                                    $productSpecificationsAdditional = array_values($productSpecificationsAdditional);
                                    foreach ($productSpecificationsAdditional as $key => $productSpecification) {
                                        $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
                                    }

                                    /*
                                    * Main Specification
                                    */
                                    $carouselSpec = [];
                                    foreach ($productSpecificationsMain as $i => $productSpec) {
                                        $spec = $productSpec->getSpecification()->one();
                                        $carouselSpec [$i] ['name'] = $spec->i18n()->name;
                                        $carouselSpec [$i] ['format'] = $productSpec->getFormattedValue();
                                        $carouselSpec [$i] ['unit'] = $spec->i18n()->unit;
                                    }
                                    ?>
                                    <div class="carousel-item">
                                        <div class="carousel-image">
                                            <a href="<?= Url::UrlShowProduct($carousel->id) ?>">
                                                <img src="<?php echo $carousel->getFullImage(); ?>"
                                                     alt="<?= Html::encode($carousel->getFullTitle()) ?>">
                                            </a>
                                        </div>
                                        <div class="car-description">
                                            <h5>
                                                <a href="<?= Url::UrlShowProduct($carousel->id) ?>"><?= $carousel->getFullTitle() ?></a>
                                            </h5>
                                            <span class="specifications">
                                                 <?php echo $carouselSpec[2]['format']; ?> см<sup>3</sup>,
                                                <?php echo $carouselSpec[4]['format']; ?>,
                                                <?php echo $carouselSpec[6]['format']; ?>,
                                                <?php echo $carouselSpec[1]['format']; ?>
                                            </span>
                                            <p><?= StringHelper::truncate($carousel->i18n()->seller_comments, 60, '...'); ?></p>
                                            <span class="price-rb"><?= Yii::$app->formatter->asDecimal($carousel->getByrPrice()) ?>
                                                BYN</span><span
                                                    class="price-dol"><?= Yii::$app->formatter->asDecimal($carousel->getUsdPrice()) ?>
                                                $</span>
                                        </div>
                                    </div>
                                <?
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-12 col-lg-3">
                            <a href="<?= Url::to(['/cars/company']); ?>" class="show-more">Показать больше <i
                                        class="fas fa-chevron-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="private-cars" role="tabpanel" aria-labelledby="private-cars-tab">
                    <div class="loader"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
                <div class="tab-pane fade" id="moto" role="tabpanel" aria-labelledby="moto-tab">
                    <div class="loader"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
                <div class="tab-pane fade" id="boat" role="tabpanel" aria-labelledby="boat-tab">
                    <div class="loader"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $content = ob_get_contents();
        Yii::$app->cache->set('carousel', $content,'3600');
        ob_end_flush();
    }
    ?>
    <div class="how-it-works hidden-mobile">
        <div class="container">
            <h2 class="text-center mb-3">Как мы работаем?</h2>
            <div class="row justify-content-center mt-4">
                <div class="col-12 col-lg-3">
                    <a href="#" id="show-how-it-works" class="custom-button red-button">Показать <i class="fas fa-chevron-right ml-2"></i></a>
                </div>
            </div>
            <div class="how-it-works-hidden">
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <ul class="nav row nav-tabs " id="myTab2" role="tablist">
                        <li class="nav-item col-lg-6 p-0">
                            <a class="nav-link active text-center" id="to-buy-tab" data-toggle="tab" href="#to-buy"
                               role="tab" aria-controls="to-buy" aria-selected="true">Купить</a>
                        </li>
                        <li class="nav-item col-lg-6 p-0">
                            <a class="nav-link text-center" id="to-sell-tab" data-toggle="tab" href="#to-sell"
                               role="tab" aria-controls="to-sell" aria-selected="false">Продать</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="myTab2Content">
                <div class="tab-pane fade show active" id="to-buy" role="tabpanel" aria-labelledby="to-buy-tab">
                    <div class="steps-buy-block row justify-content-between ">
                        <div class="step-buy first-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>После того, как вы определились с выбором, приезжаете к нам в офис.</p>
                                <p style="color: #464545;">Наши сотрудники оформят заявку на получение кредита.</p>
                            </div>
                        </div>
                        <div class="step-buy second-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>Заявка на получение кредита будет рассмотрена банком в течение 3-х часов</p>
                            </div>
                        </div>
                        <div class="step-buy third-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>Встречаемся с продавцом и осматриваем автомобиль.</p>
                                <p style="color: #464545;">Вы можете обсудить все вопросы и уточнить детали.</p>
                            </div>
                        </div>
                        <div class="step-buy fourth-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>Подписываем кредитный договор и документы на авто.</p>
                                <p style="color: #464545;">Продавец получает полную сумму за автомобиль на момент
                                    подписания договора.</p>
                            </div>
                        </div>
                        <div class="step-buy fifth-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>Регистрируете авто в МРЭО по месту жительства в течение 10 дней.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="to-sell" role="tabpanel" aria-labelledby="to-sell-tab">
                    <div class="steps-buy-block row justify-content-center">
                        <div class="step-buy first-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>Регистрируйтесь на сайте, или
                               авторизуйтесь через соц. сети.</p>
                            </div>
                        </div>
                        <div class="step-buy second-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>Загрузите объявлеие. Подробно опишите транспортное средство.Укажите характеристики. Возможен ли обмен или торг.</p>
                            </div>
                        </div>
                        <div class="step-buy third-step">
                            <div class="step-image"></div>
                            <div class="step-text">
                                <p>Покупатель звонит Вам (если имеет достаточное количество наличных средств).
                            или приезжает к нам в офис и мы помогаем оформить кредит.
                            Вы, как продовец, получаете  денежные средства за свой автомобиль в день продажи.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 justify-content-center">
                <a href="<?= Url::to(['/cars']); ?>" class="custom-button icon-right-btn col-lg-3 text-center">Перейти в
                    каталог <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </div>
    </div>
    <div class="callback hidden-mobile">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <h2>Закажите обратный звонок</h2>
                    <p>Заполните анкету и мы перзвоним Вам в ближайшее время</p>
                    <ul>
                        <li>Консультация</li>
                        <li>Помощь в выборе</li>
                        <li>Решение спорных вопросов</li>
                        <li>Оформление заявки и т.д.</li>
                    </ul>
                </div>
                <div class="col-12 col-lg-3">
                    <?= Html::beginForm(['/tools/callback'], 'post', ['class' => 'callback-form']); ?>
                    <?= Html::textInput('Callback[name]', '', ['placeholder' => 'Имя', 'class' => 'callback-name-field', 'required' => 'required']); ?>
                    <?= Html::textInput('Callback[phone]', '', ['placeholder' => 'Телефон', 'class' => 'callback-phone-field', 'required' => 'required']); ?>
                    <?= Html::submitButton('Отправить <i class="fas fa-arrow-right"></i>', ['class' => 'custom-button icon-right-btn']) ?>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="ads-mobile hidden-desktop">
        <!-- Yandex.RTB R-A-288803-2 -->
        <div id="yandex_rtb_R-A-288803-2"></div>
        <script type="text/javascript">
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-288803-2",
                        renderTo: "yandex_rtb_R-A-288803-2",
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
    <div class="news">
        <div class="container">
            <h2>Автоновости</h2>
            <p>Порция свежих новостей на каждый день</p>
            <?php
            if (Yii::$app->cache->exists('news')) {
                echo Yii::$app->cache->get('news');
            } else {
            ob_start();
            ?>
            <div class="row news-row main-row">
                <div class="main-news col-lg-6 mb-3 mb-lg-1">
                    <div class="news-item">
                        <div class="news-image">
                            <a href="<?php echo $mainNews->getUrl(); ?>">
                                <img src="<?php echo $mainNews->getTitleImage(595, 311); ?>">
                            </a>
                        </div>
                        <div class="news-description">
                            <a href="<?php echo $mainNews->getUrl(); ?>">
                                <h3><?php echo $mainNews->i18n()->header; ?></h3>
                            </a>
                            <p> <?php echo StringHelper::truncate($mainNews->i18n()->description, 120, '...'); ?></p>
                            <div class="bottom">
                            <span class="created_at"><i
                                        class="fas fa-calendar-o"></i><?php echo Yii::$app->formatter->asDate($mainNews->created_at) ?></span>
                            <a href="<?php echo $mainNews->getUrl(); ?>">Подробнее <i
                                        class="fas fa-chevron-right ml-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row other-news news-row">
                        <?php
                        $i = 0;
                        foreach ($news as $oneNews):
                            ?>
                            <?php
                            if ($i == 0) {
                                ?>
                                <div class="col-12 col-lg-6 mb-3 mb-md-1">
                                    <div class="news-item">
                                        <div class="news-image">
                                            <a href="<?= $oneNews->getUrl() ?>">
                                                <img src="<?= $oneNews->getTitleImage(283, 210) ?>">
                                            </a>
                                        </div>
                                        <div class="news-description">
                                            <a href="<?= $oneNews->getUrl() ?>">
                                                <h3><?= $oneNews->i18n()->header ?></h3>
                                            </a>
                                            <p> <?php echo StringHelper::truncate($oneNews->i18n()->description, 120, '...'); ?></p>
                                            <div class="bottom">
                            <span class="created_at"><i
                                        class="fas fa-calendar-o"></i><?php echo Yii::$app->formatter->asDate($oneNews->created_at) ?></span>
                                                <a href="<?php echo $oneNews->getUrl(); ?>">Подробнее <i
                                                            class="fas fa-chevron-right ml-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($i == 1) {
                                ?>
                                <div class="col-12 col-lg-6">
                                    <div class="news-item">
                                        <div class="news-image">
                                            <a href="<?= $oneNews->getUrl() ?>">
                                                <img src="<?= $oneNews->getTitleImage(283, 210) ?>">
                                            </a>
                                        </div>
                                        <div class="news-description">
                                            <a href="<?= $oneNews->getUrl() ?>">
                                                <h3><?= $oneNews->i18n()->header ?></h3>
                                            </a>
                                            <p> <?php echo StringHelper::truncate($oneNews->i18n()->description, 120, '...'); ?></p>
                                            <div class="bottom">
                            <span class="created_at"><i
                                        class="fas fa-calendar-o"></i><?php echo Yii::$app->formatter->asDate($oneNews->created_at) ?></span>
                                                <a href="<?php echo $oneNews->getUrl(); ?>">Подробнее <i
                                                            class="fas fa-chevron-right ml-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($i > 1) {
                                ?>
                                <div class="col-12 col-lg-6 hidden-desktop">
                                    <div class="news-item">
                                        <div class="news-image">
                                            <a href="<?= $oneNews->getUrl() ?>">
                                                <img src="<?= $oneNews->getTitleImage(283, 210) ?>">
                                            </a>
                                        </div>
                                        <div class="news-description">
                                            <a href="<?= $oneNews->getUrl() ?>">
                                                <h3><?= $oneNews->i18n()->header ?></h3>
                                            </a>
                                            <p> <?php echo StringHelper::truncate($oneNews->i18n()->description, 120, '...'); ?></p>
                                                <div class="bottom">
                            <span class="created_at"><i
                                        class="fas fa-calendar-o"></i><?php echo Yii::$app->formatter->asDate($oneNews->created_at) ?></span>
                                                    <a href="<?php echo $oneNews->getUrl(); ?>">Подробнее <i
                                                                class="fas fa-chevron-right ml-2"></i></a>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            $i++;
                        endforeach;
                        ?>
                    </div>
                    <div class="row mt-4 hidden-mobile">
                        <div class="col-12">
                            <a href="<?= Url::to(['/news']); ?>" class="show-all">Читать все <i
                                        class="fas fa-chevron-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                $newsContent = ob_get_contents();
                Yii::$app->cache->set('news', $newsContent,'3600');
                ob_end_flush();
            }
            ?>
            <div class="row hidden-desktop">
                <div class="col-12">
                    <a href="<?= Url::to(['/news']); ?>" class="show-all">Еще <i class="fas fa-chevron-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="credit-request">
        <div class="online-block">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-12">
                        <h2>ONLINE-заявка на кредит</h2>
                        <p>Заполните анкету в удобное для Вас время, мы примем ее и свяжемся с Вами</p>
                    </div>
                    <div class="col-12 col-lg-4">
                        <a href="<?= Url::to(['/tools/credit-application']); ?>" class="custom-button"><i
                                    style="color: white" class="fas fa-pencil-alt"></i> <span style="color: white;">Заполнить анкету</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="calc-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-7 text-center text-lg-right pr-lg-4">
                        <h4>Рассчитать ежемесячный платеж в 4 клика</h4>
                    </div>
                    <div class="col-12 col-lg-5 text-center text-lg-left">
                        <a href="#" id="showCalculator"><i class="fas fa-calculator mr-2"></i>Кредитный калькулятор</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="calculator-block">
            <div class="container">
                <?php echo $this->render('_calculator'); ?>
            </div>
        </div>
    </div>
</main>