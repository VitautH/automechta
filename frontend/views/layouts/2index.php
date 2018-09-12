<?php

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
use frontend\models\Bookmarks;


$this->registerJs("require(['controllers/site/modal']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/site/moment']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/site/cookie']);", \yii\web\View::POS_HEAD);
AppAsset::register($this);
$commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');
$appData = AppData::getData();

if (!Yii::$app->user->isGuest) {
    $countProduct = Product::find()->where(['created_by' => Yii::$app->user->id])->andWhere(['!=', 'status', Product::STATUS_UNPUBLISHED])->count();
    $query = Product::find();
    $query->rightJoin(Bookmarks::tableName(), Product::tableName() . '.id =' . Bookmarks::tableName() . '.product_id');
    $query->where([Bookmarks::tableName() . '.user_id' => Yii::$app->user->id]);
    $query->andWhere(['!=', Product::tableName() . '.status', Product::STATUS_UNPUBLISHED]);
    $countBookmarks = $query->count();
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
<head>
    <meta name="yandex-verification" content="d1668a24657ff9c4"/>
    <meta name="google-site-verification" content="iZfn4HRVixNo6LGlr0Hqf1hmWhhkETauoslFwTThEJE"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110162737-1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="/build/controllers/site/modal-main.js"></script>
    <script src="/js/new-bootstrap.min.js"></script>
    <script src="/js/new-menu.js"></script>
    <script src="/js/accordion-menu.js"></script>
    <script src="/js/readmore.js"></script>
    <!--        <script data-main="../build/config" src="js/require.js"></script>-->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-110162737-1');
    </script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="/css/slick-theme.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/theme/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/css/new-bootstrap.css">
    <link type="text/css" rel="stylesheet" href="/css/new-style.css">
    <link type="text/css" rel="stylesheet" href="/css/accordion-menu.css">
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

<div class="modal-maps">
    <div class="header">
        <button type="button" class="modal-close">
            <i class="fa fa-close"></i></button>
    </div>
    <div class="inner">
        <?= $appData['map'] ?>
    </div>
</div>
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
                    <?= Url::to(['/account/index']) ?>">Мои объявления</a> <span class="badge badge-danger"><?php echo $countProduct;?></span></li>
                <li><i class="far fa-star"></i><a href="<?= Url::to(['/account/bookmarks']) ?>">Избранное</a><span class="badge badge-danger"><?php echo $countBookmarks;?></span></li>
                <?php
            }
            ?>
        </ul>
        <ul class="cd-accordion-menu animated">
            <li class="has-children">
                <input type="checkbox" name="group-1" id="group-1">
                <label for="group-1">Авто <i class="fas fa-chevron-down ml-1"></i> </label>

                <ul>
                    <li class="dropdown-item"><a href="<?= Url::to(['/cars/company']) ?>">Автомобили компании</a>
                    </li>
                    <li class="dropdown-item"><a href="<?= Url::to(['/cars']) ?>">Частные объявления</a></li>
                </ul>
            </li>
            <li class="has-children">
                <input type="checkbox" name="group-2" id="group-2">
                <label for="group-2">Мото <i class="fas fa-chevron-down ml-1"></i></label>

                <ul>
                    <li class="dropdown-item"><a href="<?= Url::to(['/moto']) ?>">Мотоциклы</a></li>
                    <li class="dropdown-item"><a href="<?= Url::to(['/scooter']) ?>">Скутеры</a></li>
                    <li class="dropdown-item"><a href="<?= Url::to(['/atv']) ?>">Квадроциклы</a></li>
                </ul>
            </li>
            <li class="has-children">
                <input type="checkbox" name="group-3" id="group-3">
                <label for="group-3">Услуги <i class="fas fa-chevron-down ml-1"></i></label>

                <ul>
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
            <li><a href="<?= Url::to(['/tools/callback']) ?>">Вопрос-ответ</a></li>
            <li><a href="<?= Url::to(['/site/contact']); ?>">Контакты</a></li>
        </ul> <!-- cd-accordion-menu -->
        <ul>
            <li><a href="<?= Url::to(['/tools/calculator']); ?>"><i class="fas fa-calculator"></i>Кредитный
                    калькулятор</a>
            </li>
            <li><a href="#" id="show-callback-form"><i class="fas fa-phone"></i>Заказать обратный звонок</a></li>
            <div class="menu-callback">
                <div class="inner">
                    <?= Html::beginForm(['/tools/callback'], 'post', ['class' => 'callback-form']); ?>
                    <?= Html::textInput('Callback[name]', '', ['placeholder' => 'Имя', 'class' => 'callback-name-field','required'=>'required']); ?>
                    <?= Html::textInput('Callback[phone]', '', ['placeholder' => 'Телефон','class' => 'callback-phone-field','required'=>'required']); ?>
                    <?= Html::submitButton('Отправить <i class="fas fa-arrow-right"></i>', ['class' => 'custom-button icon-right-btn']) ?>
                    <?= Html::endForm() ?>
                </div>
            </div>
            <!--            <li><a href="#"><i class="fas fa-question"></i>Как работает портал</a></li>-->
        </ul>
        <div class="social-mobile">
            <a href="https://vk.com/automechta_by" class="mr-3"><i class="fab fa-vk"></i></a>
            <a href="https://www.instagram.com/automechta.by"><i class="fab fa-instagram"></i></a>
            <button class="custom-button mt-4"><a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"
                                                  class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login' : ''; ?>">
                    <i class="fas fa-plus"></i>Подать объявление</a></button>


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
                            <div class="col-lg-3">
                                <ul class="first-level-menu">
                                    <li class="dropdown">
                                        <a href="tel:<?= $appData['phone_credit_1'] ?>" id="dropdownMenu1"
                                           data-toggle="dropdown">
                                            <i class="fas fa-phone"></i><?= $appData['phone_credit_1'] ?>
                                            <i class="fas fa-chevron-down ml-1"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li class="dropdown-item">
                                                <a href="tel:<?= $appData['phone_credit_2'] ?>">
                                                    <i class="fas fa-phone"></i><?= $appData['phone_credit_2'] ?>
                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="tel:<?= $appData['phone_credit_3'] ?>">
                                                    <i class="fas fa-phone"></i><?= $appData['phone_credit_3'] ?>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-3">
                                <a href="#" id="show-modal-maps">
                                    <i class="fas fa-map-marker-alt"></i>
                                    г.Минск, ул.Суражская 8а
                                </a>
                            </div>
                            <div class="col-lg-3 h-100">
                                <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"
                                   class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login' : ''; ?>">
                                    <button>
                                        <i class="fas fa-plus"></i>
                                        Подать объявление
                                    </button>
                                </a>
                            </div>
                            <?php if (Yii::$app->user->isGuest): ?>
                                <div class="col-lg-3">
                                    <a href="#" class="show-modal-login mr-2">
                                        <i class="far fa-user"></i>
                                        <?= Yii::t('app', 'Log in') ?></a>|<a
                                        href="<?= Url::to(['/site/signup']) ?>" class="ml-2"><i
                                            class="fas fa-edit"></i>Регистрация</a>
                                </div>
                            <?php else: ?>
                                <div class="col-lg-3">
                                    <a class="mr-2" href="
                    <?= Url::to(['/account/index']) ?>"><?= Yii::t('app', 'Account') ?></a>
                                    |
                                    <a class="ml-2" data-method="post" href="
                    <?= Url::to(['/site/logout']) ?>"><span><?= Yii::t('app', 'Logout') ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="main-menu hidden-mobile">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <a class="site-logo" href="/">
                            <img src="/uploads/3/b/4/220x75/logo.png">
                        </a>
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
                            <li><a href="<?= Url::to(['/tools/callback']) ?>">Вопрос-ответ</a></li>
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
                    <a href="/" class="logo-mobile">
                        <img width="152px" src="/uploads/3/b/4/150x52/logo-mobile.png">
                    </a>
                </div>
                <div class="col-6">
                    <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>" class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login' : ''; ?> custom-button mobile-button-add"><i class="fas fa-plus"></i></a>
                    <div id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
<? echo $content; ?>
    <footer>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-11">
                    <nav class="info-links">
                        <ul>
                            <li class="mr-lg-5"><a href="<?= Url::to(['/site/contact']);?>">О проекте</a></li>
                            <!--                        <li class="mr-lg-5"><a href="#">Помощь</a></li>-->
                            <li class="mr-lg-5"><a href="<?= Url::to(['/oferta']);?>">Правила подачи объявления</a></li>
                            <!--                        <li class="mr-lg-5"><a href="#">Реклама на сайте</a></li>-->
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
                        <li><a href="<?= Url::to(['/tools/callback']) ?>">Вопрос-ответ</a></li>
                        <li><a href="<?= Url::to(['/catalog']); ?>">Энциклопедия</a></li>
                        <li><a href="<?= Url::to(['/news']); ?>">Автоновости</a></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-2 hidden-mobile">
                    <h3>Контакты</h3>
                    <ul>
                        <li>г. Минск, ул.Суражская 8a</li>
                        <li><a href="tel:<?= $appData['phone_credit_1'] ?>"><?= $appData['phone_credit_1'] ?></a></li>
                        <li><a href="tel:<?= $appData['phone_credit_2'] ?>"><?= $appData['phone_credit_2'] ?></a></li>
                        <li><a href="tel:<?= $appData['phone_credit_3'] ?>"><?= $appData['phone_credit_3'] ?></a></li>
                        <li><a href="mailto:<?= $appData['email'] ?>"><?= $appData['email'] ?></a></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-3">
                    <h3 class="hidden-mobile">Давайте дружить</h3>
                    <a href="https://vk.com/automechta_by" class="mr-3"><i class="fab fa-vk"></i></a>
                    <a href="https://www.instagram.com/automechta.by/"><i class="fab fa-instagram"></i></a>
                    <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"  class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login custom-button mt-4' : 'custom-button mt-4'; ?>"> <i class="fas fa-plus"></i>Подать объявление</a>
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
        <div class="copirights-mobile hidden-desktop">
            <div class="container">
                <p>© 2013-2018 Автомобильный портал «АвтоМечта»</p>
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
        $('#carousel-CompanyCars').slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            adaptiveHeight: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        dots: false,
                        arrows: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: true,
                        variableWidth: true
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        dots: false,
                        arrows: true,
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        centerMode: true,
                        variableWidth: true
                    }
                }
            ]
        });
    })
</script>
</body>
</html>
<?php $this->endBody() ?>