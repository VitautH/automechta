<?php
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use common\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Menu as MenuModel;
use common\models\AppData;
use yii\widgets\Menu;
use common\models\Product;
use common\models\Specification;
use common\models\Page;
use common\models\User;
use common\helpers\User as UserHelpers;

//$this->registerCssFile('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
//$this->registerCssFile('css/slick-theme.css');
//$this->registerCssFile('https://use.fontawesome.com/releases/v5.0.13/css/all.css');
//$this->registerCssFile('css/new-bootstrap.css');
//$this->registerCssFile('css/new-style.css');
$this->registerJs("https://code.jquery.com/jquery-3.3.1.slim.min.js", '');
$this->registerJs("https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js", '');

$this->registerJs("//code.jquery.com/jquery-1.11.0.min.js", '');
$this->registerJs("//code.jquery.com/jquery-migrate-1.2.1.min.js", '');
$this->registerJs("//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js", '');

$this->registerJs("js/new-bootstrap.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("js/new-menu.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

//$this->registerJsFile('/js/dropdown.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("require(['controllers/site/modal']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/site/moment']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/site/cookie']);", \yii\web\View::POS_HEAD);
AppAsset::register($this);
$appData = AppData::getData();
$latestNews = Page::find()->active()->news()->orderBy('id DESC')->limit(3)->all();
$commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');
?>
<?php $this->beginPage() ?>
    <html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
    <head>
        <meta name="yandex-verification" content="d1668a24657ff9c4"/>
        <meta name="google-site-verification" content="iZfn4HRVixNo6LGlr0Hqf1hmWhhkETauoslFwTThEJE"/>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110162737-1"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-110162737-1');
        </script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="css/slick-theme.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
              integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
              crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="css/new-bootstrap.css">
        <link type="text/css" rel="stylesheet" href="css/new-style.css">
        <meta name="yandex-verification" content="6671e701e627845e"/>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="format-detection" content="telephone=no"/>
        <?= Html::csrfMetaTags() ?>
        <script>
            var require = {
                paths: {
                    'messages': '<?= $commonWebPath ?>/js/messages/<?= Yii::$app->language ?>/messages',
                }
            };
        </script>
        <title><?= Html::encode($this->title) ?></title>
        <meta property="og:title" content="<?= Html::encode($this->title) ?>"/>
        <?php $this->head() ?>

        <?php if (!empty($appData['favicon'])): ?>
            <link rel="shortcut icon" type="image/x-icon" href="<?= $appData['favicon']->getAbsoluteUrl() ?>"/>
        <?php endif ?>

        <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <meta name="yandex-verification" content="72e8b482df4f7fef"/>
        <meta name="google-site-verification" content="ranTAzl9yo_biTr4iGmT5Y7uqnuCrENWMYyUOHNAUdc"/>
    </head>
    <body class="<?= $this->context->bodyClass; ?> m-index">
    <div class="popup-block"></div>
    <?php
    if (Yii::$app->user->isGuest):
        ?>
        <div class="modal-login">
            <?= $this->render('//login-modal/_loginWidget'); ?>
        </div>
    <?php
    endif;
    ?>
    <div class="mobile-menu">
        <nav>
            <ul>
                <?php if (Yii::$app->user->isGuest) { ?>
                    <li><i class="far fa-user"></i> <a class="show-modal-login" href="#">
                            <?= Yii::t('app', 'Log in') ?>
                        </a></li>
                    <li class="mb-4"><i class="fas fa-edit"></i><a href="<?= Url::to(['/site/signup']) ?>">
                            Регистрация
                        </a></li>
                    <?php
                } else {

                    ?>
                    <li><i class="far fa-user"></i> <a data-method="post" href="
                    <?= Url::to(['/site/logout']) ?>">
                            <?= Yii::t('app', 'Logout') ?>
                        </a></li>
                    <li><i class="fas fa-car"></i><a href="
                    <?= Url::to(['/account/index']) ?>">Мои объявления</a></li>
                    <li><i class="far fa-star"></i><a href="<?= Url::to(['/account/bookmarks']) ?>">Избранное</a></li>
                    <?php
                }
                ?>
            </ul>
            <ul class="">
                <li class="dropdown">
                    <a href="#" id="dropdownMenu4" data-toggle="dropdown">
                        Авто
                        <i class="fas fa-chevron-down ml-1"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
                        <li class="dropdown-item"><a href="<?= Url::to(['/cars/company']) ?>">Автомобили компании</a>
                        </li>
                        <li class="dropdown-item"><a href="<?= Url::to(['/cars']) ?>">Частные объявления</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" id="dropdownMenu5" data-toggle="dropdown">
                        Мото
                        <i class="fas fa-chevron-down ml-1"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu5">
                        <li class="dropdown-item"><a href="<?= Url::to(['/moto']) ?>">Мотоциклы</a></li>
                        <li class="dropdown-item"><a href="<?= Url::to(['/scooter']) ?>">Скутеры</a></li>
                        <li class="dropdown-item"><a href="<?= Url::to(['/atv']) ?>">Квадроциклы</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" id="dropdownMenu6" data-toggle="dropdown">
                        Услуги
                        <i class="fas fa-chevron-down ml-1"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu6">
                        <li class="dropdown-item"><a href="<?= Url::to(['/avto-v-kredit']) ?>">Авто в кредит</a></li>
                        <li class="dropdown-item"><a
                                    href="<?= Url::to(['/oformlenie-schet-spravki']) ?>">Счет-справка </a>
                        </li>
                        <li class="dropdown-item"><a href="<?= Url::to(['/srochnyj-vykup']) ?>">Срочный выкуп авто</a>
                        </li>
                        <li class="dropdown-item"><a href="<?= Url::to(['/prijom-avto-na-komissiju']) ?>">Приём авто на
                                комиссию</a></li>
                        <li class="dropdown-item"><a href="<?= Url::to(['/obmen-avto']) ?>">Trade-In(Обмен авто)</a>
                        </li>
                    </ul>
                </li>
                <li><a href="<?= Url::to(['/catalog']) ?>">Энциклопедия</a></li>
                <li><a href="<?= Url::to(['/news']) ?>">Автоновости</a></li>
                <!--            <li><a href="#">Вопрос-ответ</a></li>-->
                <li><a href="<?= Url::to(['/site/contact']); ?>">Контакты</a></li>
            </ul>
            <ul>
                <li><a href="<?= Url::to(['/tools/calculator']); ?>"><i class="fas fa-calculator"></i>Кредитный
                        калькулятор</a>
                </li>
                <!--            <li><a href="#"><i class="fas fa-phone"></i>Заказать обратный звонок</a></li>-->
                <!--            <li><a href="#"><i class="fas fa-question"></i>Как работает портал</a></li>-->
            </ul>
            <div class="social-mobile">
                <a href="https://vk.com/automechta_by" class="mr-3"><i class="fab fa-vk"></i></a>
                <a href="https://www.instagram.com/automechta.by"><i class="fab fa-instagram"></i></a>
                <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"
                   class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login' : ''; ?> custom-button mt-4"><i
                            class="fas fa-plus"></i>Подать объявление</a>

                <!--            <a class="full-version" href="#">Полная версия</a>-->
                <p>© 2013-2018 Автомобильный портал «АвтоМечта»</p>
            </div>
        </nav>
    </div>
    <div class="wrapper">
        <header>
            <div class="info-header hidden-mobile">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-xl-3 social-m">
                            <a href="https://vk.com/automechta_by" class="mr-3"><i class="fab fa-vk"></i></a>
                            <a href="https://www.instagram.com/automechta.by/"><i class="fab fa-instagram"></i></a>
                        </div>
                        <div class="col-lg-10 col-xl-9 h-100">
                            <div class="row align-items-center header-info-links">
                                <div class="col-lg-3"><a
                                            href="tel:<?= $appData['phone_credit_1'] ?>"><i
                                                class="fas fa-phone"></i><?= $appData['phone_credit_1'] ?></a></div>
                                <div class="col-lg-3"><i class="fas fa-map-marker-alt"></i> <?= $appData['address'] ?>
                                </div>
                                <div class="col-lg-3 h-100">
                                    <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"
                                       class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login' : ''; ?>"><i
                                                class="fas fa-plus"></i>Подать объявление</a>
                                </div>

                                <div class="col-lg-3"><a href="#" class="show-modal-login mr-2"><i
                                                class="far fa-user"></i> <?= Yii::t('app', 'Log in') ?></a>|<a
                                            href="<?= Url::to(['/site/signup']) ?>" class="ml-2"><i
                                                class="fas fa-edit"></i>Регистрация</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="main-menu hidden-mobile">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2">
                            <a class="site-logo" href="/">  <?php if (!empty($appData['logo'])): ?>
                                    <?= Html::img($result = Yii::$app->uploads->getThumbnail($appData['logo']->hash, null, 220, 75)) ?>
                                <?php endif; ?></a>
                        </div>
                        <div class="col-lg-10">
                            <ul class="first-level-menu">
                                <li class="dropdown">
                                    <a href="#" id="dropdownMenu1" data-toggle="dropdown">
                                        Авто
                                        <i class="fas fa-chevron-down ml-1"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li class="dropdown-item"><a href="<?= Url::to(['/cars/company']); ?>">Автомобили
                                                компании</a></li>
                                        <li class="dropdown-item"><a href="<?= Url::to(['/cars']); ?>">Частные
                                                объявления</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" id="dropdownMenu2" data-toggle="dropdown">
                                        Мото
                                        <i class="fas fa-chevron-down ml-1"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <li class="dropdown-item"><a href="<?= Url::to(['/moto']); ?>">Мотоциклы</a>
                                        </li>
                                        <li class="dropdown-item"><a href="<?= Url::to(['/scooter']); ?>">Скутеры</a>
                                        </li>
                                        <li class="dropdown-item"><a href="<?= Url::to(['/atv']); ?>">Квадроциклы</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" id="dropdownMenu3" data-toggle="dropdown">
                                        Услуги
                                        <i class="fas fa-chevron-down ml-1"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                        <li class="dropdown-item"><a href="<?= Url::to(['/avto-v-kredit']); ?>">Авто в
                                                кредит</a></li>
                                        <li class="dropdown-item"><a
                                                    href="<?= Url::to(['/oformlenie-schet-spravki']); ?>">Счет-справка </a>
                                        </li>
                                        <li class="dropdown-item"><a href="<?= Url::to(['/srochnyj-vykup']); ?>">Срочный
                                                выкуп авто</a></li>
                                        <li class="dropdown-item"><a
                                                    href="<?= Url::to(['/prijom-avto-na-komissiju']); ?>">Приём авто на
                                                комиссию</a></li>
                                        <li class="dropdown-item"><a href="<?= Url::to(['/obmen-avto']); ?>">Trade-In(Обмен
                                                авто)</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= Url::to(['/catalog']); ?>">Энциклопедия</a></li>
                                <li><a href="<?= Url::to(['/news']); ?>">Автоновости</a></li>
                                <!--                            <li><a href="-->
                                <? //= Url::to(['/tools/calculator']); ?><!--">Вопрос-ответ</a></li>-->
                                <li><a href="<?= Url::to(['/site/contact']); ?>">Контакты</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!--mobile header-->
            <div class="mobile-header hidden-desktop">
                <div class="row">
                    <div class="col-6">
                        <a href="/" class="logo-mobile"> <?php if (!empty($appData['logo'])): ?>
                                <?= Html::img($result = Yii::$app->uploads->getThumbnail($appData['logo']->hash, null, 150, 52)) ?>
                            <?php endif; ?></a>
                    </div>
                    <div class="col-6">
                        <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"
                           class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login' : ''; ?>  custom-button mobile-button-add"><i
                                    class="fas fa-plus"></i></a>
                        <div id="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?= $content ?>
        <footer>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-11">
                        <nav class="info-links">
                            <ul>
                                <li class="mr-lg-5"><a href="#">О проекте</a></li>
                                <li class="mr-lg-5"><a href="#">Помощь</a></li>
                                <li class="mr-lg-5"><a href="#">Правила подачи объявления</a></li>
                                <li class="mr-lg-5"><a href="#">Реклама на сайте</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row justify-content-center footer-menu">
                    <div class="col-12 col-lg-2 hidden-mobile">
                        <h3>Продажа</h3>
                        <ul>
                            <li><a href="<?= Url::to(['/cars/company']); ?>">Автомобили компании</a></li>
                            <li><a href="<?= Url::to(['/cars']); ?>">Частные объявления</a></li>
                            <li><a href="<?= Url::to(['/moto']); ?>">Мотоциклы</a></li>
                            <li><a href="<?= Url::to(['/scooter']); ?>">Скутеры</a></li>
                            <li><a href="<?= Url::to(['/atv']); ?>">Квадроциклы</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-2 hidden-mobile">
                        <h3>Услуги</h3>
                        <ul>
                            <li><a href="<?= Url::to(['/avto-v-kredit']); ?>">Авто в кредит</a></li>
                            <li><a href="<?= Url::to(['/oformlenie-schet-spravki']); ?>">Счет-справка</a></li>
                            <li><a href="<?= Url::to(['/srochnyj-vykup']); ?>">Срочный выкуп авто</a></li>
                            <li><a href="<?= Url::to(['/prijom-avto-na-komissiju']); ?>">Прием авто на комиссию</a></li>
                            <li><a href="<?= Url::to(['/obmen-avto']); ?>">Traid-in (обмен авто)</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-2 hidden-mobile">
                        <h3>Полезное</h3>
                        <ul>
                            <li><a href="#">Вопрос-ответ</a></li>
                            <li><a href="<?= Url::to(['/catalog']); ?>">Энциклопедия</a></li>
                            <li><a href="<?= Url::to(['/news']); ?>">Автоновости</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-2 hidden-mobile">
                        <h3>Контакты</h3>
                        <ul>
                            <li><a href="#"><?= $appData['address'] ?> </a></li>
                            <li><a href="tel:<?= $appData['phone_credit_1'] ?>"></a></li>
                            <li><a href="tel:<?= $appData['phone_credit_2'] ?>"></a></li>
                            <li><a href="tel:<?= $appData['phone_credit_3'] ?>"></a></li>
                            <li><a href="mailto:<?= $appData['email'] ?>"><?= $appData['email'] ?></a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-3">
                        <h3 class="hidden-mobile">Давайте дружить</h3>
                        <a href="https://vk.com/automechta_by" class="mr-3"><i class="fab fa-vk"></i></a>
                        <a href="https://www.instagram.com/automechta.by/"><i class="fab fa-instagram"></i></a>
                        <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"
                           class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login' : ''; ?> custom-button mt-4"><i
                                    class="fas fa-plus"></i>Подать объявление</a>
                    </div>
                </div>
            </div>
            <div class="copyrights hidden-mobile">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6 text-left">
                            <p>© 2013-<?= date('Y') ?> Автомобильный портал «АвтоМечта»</p>
                        </div>
                        <div class="col-12 col-lg-6 text-right"><p>Все права защищены</p></div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script async data-skip-moving="true">
        window.onload = function () {
            (function (w, d, u) {
                var s = d.createElement('script');
                s.async = 1;
                s.src = u + '?' + (Date.now() / 60000 | 0);
                var h = d.getElementsByTagName('script')[0];
                h.parentNode.insertBefore(s, h);
            })(window, document, 'https://cdn.bitrix24.by/b5147563/crm/site_button/loader_3_yfnk0g.js');
            setTimeout(function () {
                $('.bx-crm-widget-wrapper').show();
            }, 1000);
        };
    </script>
    <script>
        $(document).ready(function () {
            $('.carousel-row').slick({
                dots: false,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            arrows: true,
                            slidesToShow: 1
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            dots: true,
                            arrows: true,
                            slidesToShow: 2
                        }
                    }
                ]
            });
        })
    </script>
    </body>
    </html>
<?php $this->endBody() ?>