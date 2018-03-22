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

$this->registerJsFile('/js/semantic.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/js/dropdown.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("require(['controllers/site/modal']);", \yii\web\View::POS_HEAD);
AppAsset::register($this);
$appData = AppData::getData();
$latestNews = Page::find()->active()->news()->orderBy('id DESC')->limit(3)->all();
$commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');
?>
<?php $this->beginPage() ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
    <head>
        <meta name="yandex-verification" content="d1668a24657ff9c4"/>
        <meta name="google-site-verification" content="iZfn4HRVixNo6LGlr0Hqf1hmWhhkETauoslFwTThEJE"/>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110162737-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-110162737-1');
        </script>

        <meta name="yandex-verification" content="6671e701e627845e"/>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
        <link rel="stylesheet" href="/theme/css/master.css">
        <link rel="stylesheet" href="/css/semantic.css">
        <link rel="stylesheet" href="/css/dropdown.css">
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
    <header class="b-topBar">
        <div class="container" style="width:97%;">
            <div class="row hidden-xs hidden-sm">
                <div class="col-md-2 col-xs-2 col-sm-6 ">
                    <div class="b-nav__logo">
                        <a href="/">
                            <?php if (!empty($appData['logo'])): ?>
                                <?= Html::img($result = Yii::$app->uploads->getThumbnail($appData['logo']->hash, null, 220, 75)) ?>
                            <?php endif; ?>
                        </a>
                        <h1><a href="/"><?= $appData['logoText'] ?></a></h1>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 hidden-xs hidden-sm">
                    <div class="b-topBar__tel">
                        <div class="b-topBar__tel_inner">
                            <span class="fa fa-phone"></span>
                            <div>
                                <a href="tel:<?= $appData['phone_credit_1'] ?>"
                                   class="inheritColor"><?= $appData['phone_credit_1'] ?></a>
                                <br>
                                <a href="tel:<?= $appData['phone_credit_2'] ?>"
                                   class="inheritColor"><?= $appData['phone_credit_2'] ?></a>
                                <br>
                                <a href="tel:<?= $appData['phone_credit_3'] ?>"
                                   class="inheritColor"><?= $appData['phone_credit_3'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 hidden-xs hidden-sm">
                    <div class="b-topBar__addr">
                        <a href="/site/contact">
                            <span class="fa fa-map-marker"></span>
                            <?= $appData['address'] ?>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 hidden-xs hidden-sm text-right">
                    <nav class="b-topBar__nav">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <span>
                         <i class="fa fa-user" aria-hidden="true"></i>
                       </span>
                            <ul>
                                <li>
                                    <a class="show-modal-login" href="#">
                                        <?= Yii::t('app', 'Log in') ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/site/signup']) ?>">
                                        Регистрация
                                    </a>
                                </li>
                            </ul>
                        <?php else: ?>
                        <?php
                        $avatar = UserHelpers::getAvatar(Yii::$app->user->id, '50px', '50px', '100%');
                        ?>
                        <? if ($avatar == null):
                            ?>
                            <span>
                         <i class="fa fa-user" aria-hidden="true"></i>
                       </span>
                        <?php
                        endif;
                        ?>
                        <ul>
                            <li>
                                <? if ($avatar !== null):
                                    ?>
                                    <div class="avatar col-md-3">
                                        <a href="
                    <?= Url::to(['/account/index']) ?>">
                                            <?
                                            echo $avatar;
                                            ?>
                                        </a>
                                    </div>
                                <?
                                endif;
                                ?>
                                <a class="account_link col-md-8" href="
                    <?= Url::to(['/account/index']) ?>">
                                    <div><?= Yii::t('app', 'Account') ?></div>
                                </a>
                                <br>
                                <a class="logout col-md-5" data-method="post" href="
                    <?= Url::to(['/site/logout']) ?>">
                                    <div><?= Yii::t('app', 'Logout') ?></div>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-3 hidden-xs hidden-sm">
                    <a href="/create-ads" class="btn m-btn m-btn-dark header-create-button">
                        <span class="fa fa-plus"></span>
                        ПОДАТЬ ОБЪЯВЛЕНИЕ
                    </a>
                </div>
            </div>
            <div class="phone_row row visible-xs visible-sm">
                <div class="col-xs-3 col-sm-3">
                    <div class="b-nav__list wow slideInLeft" data-wow-delay="0.3s">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse navbar-main-slide" id="nav">
                            <ul>
                                <?php if (Yii::$app->user->isGuest): ?>

                                    <li class="accaunt-menu">
                                        <a class="show-modal-login" href="#">
                                            <?= Yii::t('app', 'Log in') ?>
                                        </a>

                                        <a href="<?= Url::to(['/site/signup']) ?>">
                                            Регистрация
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="accaunt-menu">
                                        <a class="account_link" href="
                    <?= Url::to(['/account/index']) ?>"><?= Yii::t('app', 'Account') ?></a>

                                        <a class="logout" data-method="post" href="
                    <?= Url::to(['/site/logout']) ?>"><span><?= Yii::t('app', 'Logout') ?></span> (
                                            <?= Yii::$app->user->identity->username ?>)
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="create-ads-menu">
                                    <a href="/create-ads" class="btn m-btn m-btn-dark header-create-button">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <?= Yii::t('app', 'ADD YOUR VEHICLE') ?>
                                    </a>
                                </li>
                            </ul>
                            <?=
                            Menu::widget([
                                'activateParents' => true,
                                'items' => Yii::$app->menu->getItems(),
                                'options' => [
                                    'class' => 'navbar-nav-menu',
                                ],
                                'submenuTemplate' => "\n<ul class=\"dropdown-menu h-nav\">\n{items}\n</ul>\n"
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                    <div class="b-nav__logo">
                        <a href="/">
                            <?php if (!empty($appData['logo'])): ?>
                                <?= Html::img($result = Yii::$app->uploads->getThumbnail($appData['logo']->hash, null, 220, 75)) ?>
                            <?php endif; ?>
                        </a>
                        <h1><a href="/"><?= $appData['logoText'] ?></a></h1>
                    </div>
                </div>
                <div class="col-xs-3 col-sm-3 text-right">
                    <div class="add_ads">
                        <a href="/create-ads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                </div>
            </div>
            <div class="row visible-xs visible-sm phone_number">
                <div class="col-xs-6 col-sm-6">
                    <a href="tel:<?= $appData['phone_credit_1'] ?>"
                       class="inheritColor"><?= $appData['phone_credit_1'] ?></a>
                </div>
                <div class="col-xs-6 col-sm-6">
                    <a href="tel:<?= $appData['phone_credit_2'] ?>"
                       class="inheritColor"><?= $appData['phone_credit_2'] ?></a>
                </div>
            </div>
        </div>
    </header>
    <!--b-topBar-->
    <nav class="b-nav hidden-xs hidden-sm">
        <div class="container" style="width: 94%;">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="b-nav__list wow slideInLeft" data-wow-delay="0.3s">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse navbar-main-slide" id="nav">
                            <?=
                            Menu::widget([
                                'activateParents' => true,
                                'items' => Yii::$app->menu->getItems(),
                                'options' => [
                                    'class' => 'navbar-nav-menu',
                                ],
                                'submenuTemplate' => "\n<ul class=\"dropdown-menu h-nav\">\n{items}\n</ul>\n"
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
    </nav>
    <!--b-nav-->
    <?= $content ?>
    <!--b-info-->
    <?php
    if (Yii::$app->cache->exists('footer')) {
        echo Yii::$app->cache->get('footer');
    } else {
        ob_start();
        ?>
        <div class="additional_block">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
        <div class="b-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-6">
                        <div class="b-info__latest">
                            <div class="h3"><a
                                        href="<?= Url::UrlBaseCategory(Url::MOTO) ?>">
                                    Мотоциклы в кредит</a></div>
                            <?php
                            $latestProducts = Product::find()->where('type=:type', array(':type' => 3))->active()->orderBy('id DESC')->limit(2)->all();
                            ?>
                            <?php foreach ($latestProducts as $latestProduct): ?>
                                <div class="b-info__latest-article wow zoomInUp" data-wow-delay="0.3s">
                                    <div class="b-info__latest-article-photo">
                                        <a href="<?= URL::UrlShowProduct($latestProduct->id) ?>">
                                            <img src="<?= $latestProduct->getTitleImageUrl(80, 53) ?>"
                                                 alt="<?= $latestProduct->getFullTitle() ?>"/>
                                        </a>
                                    </div>
                                    <div class="b-info__latest-article-info">
                                        <h6>
                                            <a href="<?= URL::UrlShowProduct($latestProduct->id) ?>"><?= $latestProduct->getFullTitle() ?></a>
                                        </h6>
                                        <span>
                                        <?= Yii::$app->formatter->asDecimal($latestProduct->getByrPrice()) ?> BYN<br>
                                            <?= Yii::$app->formatter->asDecimal($latestProduct->getUsdPrice()) ?>
                                    </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <div class="b-info__twitter">
                            <div class="h3"><a href="/site/contact"><?= Yii::t('app', 'OPENING HOURS') ?></a></div>
                            <div class="b-info__contacts-item">
                                <?= $appData['openingHoursFooter'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <address class="b-info__contacts">
                            <p><a href="/site/contact"><?= Yii::t('app', 'contact us') ?></a></p>
                            <div class="b-info__contacts-item">
                                <span class="fa fa-map-marker"></span>
                                <em><?= $appData['address'] ?></em>
                            </div>
                            <div class="b-info__contacts-item">
                                <span class="fa fa-phone"></span>
                                <div>
                                    <em><a href="tel:<?= $appData['phone_credit_1'] ?>"
                                           class="inheritColor"><?= $appData['phone_credit_1'] ?></a></em>
                                    <br>
                                    <em><a href="tel:<?= $appData['phone_credit_2'] ?>"
                                           class="inheritColor"><?= $appData['phone_credit_2'] ?></a></em>
                                    <br>
                                    <em><a href="tel:<?= $appData['phone_credit_3'] ?>"
                                           class="inheritColor"><?= $appData['phone_credit_3'] ?></a></em>
                                </div>
                            </div>
                            <div class="b-info__contacts-item">
                                <span class="fa fa-envelope"></span>
                                <em><?= Yii::t('app', 'Email') ?>: <a href="mailto:<?= $appData['email'] ?>"
                                                                      class="inheritColor"><?= $appData['email'] ?></a></em>
                            </div>
                            <div class="social">
                                <noindex>
                                    <a href="https://vk.com/automechta_by" rel="nofollow" class="vk">
                                        <i class="social_icons fa fa-vk" aria-hidden="true"></i>
                                    </a>
                                    <a href="https://www.facebook.com/automechta/" rel="nofollow" class="fb">
                                        <i class="social_icons fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                    <a href="https://ok.ru/automechta" rel="nofollow" class="ok">
                                        <i class="social_icons fa fa-odnoklassniki-square" aria-hidden="true"></i>
                                    </a>
                                    <a href="https://www.instagram.com/automechta.by" rel="nofollow" class="instagram">
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                    </a>
                                </noindex>
                            </div>
                        </address>
                    </div>
                    <!--<div class="col-md-3 col-xs-6">-->
                    <!--<address class="b-info__map" style="overflow: hidden;">-->
                    <?= $appData['footerMap'] ?>
                    <!--</address>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
        <!--b-info-->
        <footer class="b-footer">
            <a id="to-top" href="#this-is-top"><i class="fa fa-chevron-up"></i></a>
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-xs-6 text-left">
                        <p><b>ПРОДАЖА И ПОКУПКА АВТОМОБИЛЕЙ В КРЕДИТ В БЕЛАРУСИ</b></p>
                    </div>
                    <div class="col-md-5 col-xs-6 text-sm-right">
                        <p>&copy; 2013-<?= date('Y') ?> Автомобильный портал «АвтоМечта»</p>
                    </div>
                </div>
            </div>
        </footer><!--b-footer-->
        <?php
        $content = ob_get_contents();
        Yii::$app->cache->set('footer', $content);
        ob_end_flush();
    }
    ?>
    <?php $this->endBody() ?>
    <link rel="stylesheet" href="/theme/assets/bxslider/jquery.bxslider.css">
    <link rel="stylesheet" href="/theme/assets/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="/theme/assets/owl-carousel/owl.theme.css">
    <script>
        //iOS fix
        // Opera 8.0+
        var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
        // Chrome 1+
        var isChrome = !!window.chrome && !!window.chrome.webstore;
        // Blink engine detection
        var isBlink = (isChrome || isOpera) && !!window.CSS;
        var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 || !isChrome && !isOpera && window.webkitAudioContext !== undefined;
        if (isSafari) {
            $('input[type=search],input[type=text],input[type=password],select').on('focus', function () {
                $(this).data('fontSize', $(this).css('font-size')).css('font-size', '18px');
            }).on('blur', function () {
                $(this).css('font-size', $(this).data('fontSize'));
            });
        }
    </script>
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
    </body>
    </html>
    Отработало за <?= Yii::getLogger()->getElapsedTime(); ?> с. Скушано памяти: <?= round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB" ?>

<?php $this->endPage() ?>