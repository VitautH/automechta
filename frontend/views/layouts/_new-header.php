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
    <link type="text/css" rel="stylesheet" href="/css/new-bootstrap.css">
    <link type="text/css" rel="stylesheet" href="/css/new-style.css">
    <meta name="yandex-verification" content="6671e701e627845e"/>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
<? $this->beginBody(); ?>
<body class="<?= $this->context->bodyClass; ?> m-index">
<div class="popup-block"></div>
<div class="load-spinner">
    <i class="fas fa-spinner fa-spin"></i>
</div>
<?php
if (Yii::$app->user->isGuest):
    ?>
    <div class="modal-login">
        <?= $this->render('//login-modal/_newLoginWidget'); ?>
    </div>
    <div class="modal-registration">
        <div class="modal-login">
            <?= $this->render('//login-modal/_registrationWidget'); ?>
        </div>
    </div>
    <div class="modal-reset-password">
        <div class="modal-login">
            <?= $this->render('//login-modal/_resetPasswordWidget'); ?>
        </div>
    </div>
<?php
endif;
?>
<div class="modal-callback">
    <?= $this->render('//login-modal/_callbackWidget'); ?>
</div>
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
                <li><i class="far fa-user"></i> <a class="show-modal-login-mobile" href="#">
                        <?= Yii::t('app', 'Log in') ?>
                    </a></li>
                <li class="mb-4"><i class="fas fa-edit"></i><a href="#" class="show-modal-registration-mobile">
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
                    <?= Url::to(['/account/index']) ?>">Мои объявления</a> <span
                            class="badge badge-danger"><?php echo $countProduct; ?></span></li>
                <li><i class="far fa-star"></i><a href="<?= Url::to(['/account/bookmarks']) ?>">Избранное</a><span
                            class="badge badge-danger"><?php echo $countBookmarks; ?></span></li>
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
            <li><a id="show-credit-calculator" href="#"><i class="fas fa-calculator"></i>Кредитный
                    калькулятор</a>
            </li>
            <div class="menu-credit-clculator" style="display: none">
                <div class="d-flex justify-content-center b-detail__main-aside-payment">
                    <div class="inner">
                        <div class="b-detail__main-aside-payment-form">
                            <div class="calculator-loan-mobile" style="display: none;"><div class="form"><div class="accrue-field-amount"><p><label>Loan Amount:</label><input type="text" class="amount" value=""></p></div><div class="accrue-field-rate"><p><label>Rate (APR):</label><input type="text" class="rate" value="15.5"></p></div><div class="accrue-field-term"><p><label>Term:</label><input type="text" class="term" value="60m"><small>Format: 12m, 36m, 3y, 7y</small></p></div></div><div class="results"><p class="error">Please fill in all fields.</p></div></div>
                            <form action="/" method="post" class="js-loan-mobile">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Цена, BYN</label>
                                        <input  type="text" placeholder="5000" value="" name="price">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Первоначальный взнос, BYN</label>
                                        <input type="number" placeholder="0" value="0" name="prepayment" id="prepayment-mobile" min="0" max="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputAddress">Ставка в %</label>
                                        <select  name="rate" id="rate-mobile">
                                            <option value="15.5">Приорбанк 15.5%</option>
                                            <option value="19.9">ВТБ 19.9%</option>
                                            <option value="16">БТА 16%</option>
                                            <option value="16.45">ИдеяБанк 16.45%</option>
                                            <option value="16">СтатусБанк 16%</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputAddress2">Срок кредита</label>
                                        <select name="term" id="term-mobile">
                                            <option value="6m">6 месяцев</option>
                                            <option value="12m">1 год</option>
                                            <option value="24m">2 года</option>
                                            <option value="36m">3 года</option>
                                            <option value="48m">4 года</option>
                                            <option value="60m" selected="">5 лет</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="custom-button" type="submit">Рассчитать <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </button>
                                <div class="d-flex justify-content-center js-loan-results-mobile">
                                    <span class="js-per-month-mobile">0 </span>
                                    <p> BYN в месяц</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <li><a href="#" id="show-callback-form"><i class="fas fa-phone"></i>Заказать обратный звонок</a></li>
            <div class="menu-callback">
                <div class="inner">
                    <?= Html::beginForm(['/tools/callback'], 'post', ['class' => 'callback-form']); ?>
                    <?= Html::textInput('Callback[name]', '', ['placeholder' => 'Имя', 'class' => 'callback-name-field', 'required' => 'required']); ?>
                    <?= Html::textInput('Callback[phone]', '', ['placeholder' => 'Телефон', 'class' => 'callback-phone-field', 'required' => 'required']); ?>
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
                                    <li class="phone-menu dropdown">
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
                                    г. Минск, ул.Суражская 8а
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
                                            href="#" class="show-modal-registration ml-2"><i
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
                    <a href="<?= Yii::$app->user->isGuest == true ? '#' : '/create-ads'; ?>"
                       class="<?= Yii::$app->user->isGuest == true ? 'show-modal-login-mobile' : ''; ?> custom-button mobile-button-add"><i
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