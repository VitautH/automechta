<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Menu as MenuModel;
use common\models\AppData;
use yii\widgets\Menu;
use yii\helpers\Url;
use common\models\Product;
use common\models\Specification;
use common\models\Page;

AppAsset::register($this);

$appData = AppData::getData();
$latestNews = Page::find()->active()->news()->orderBy('id DESC')->limit(3)->all();
$commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');

?>
<?php $this->beginPage() ?>
<!DOCTYPE>
<html lang="<?= Yii::$app->language ?>">
	<head>
        <meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
        <?= Html::csrfMetaTags() ?>
        <script>
            var require = {
                paths : {
                    'messages' : '<?= $commonWebPath ?>/js/messages/<?= Yii::$app->language ?>/messages',
                }
            };
        </script>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <?php if(!empty($appData['favicon'])): ?>
		<link rel="shortcut icon" type="image/x-icon" href="<?= $appData['favicon']->getAbsoluteUrl() ?>" />
        <?php endif ?>

        <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="/js/semantic.js"></script>
        <script src="/js/dropdown.js"></script>
        <script src="/js/search_main.js"></script>
		<link rel="stylesheet" href="/theme/css/master.css">
        <link rel="stylesheet" href="/css/semantic.css">
        <link rel="stylesheet" href="/css/dropdown.css">
		<meta name="yandex-verification" content="72e8b482df4f7fef" />
		<meta name="google-site-verification" content="ranTAzl9yo_biTr4iGmT5Y7uqnuCrENWMYyUOHNAUdc" />
	</head>
    <body class="m-index" data-scrolling-animations="false">

		<!-- Loader -->
		<!--<div id="page-preloader"><span class="spinner"></span></div>-->
		<!-- Loader end -->
		
		<header class="b-topBar wow slideInDown" data-wow-delay="0.7s">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="b-topBar__addr">
                            <a href="/site/contact">
                                <span class="fa fa-map-marker"></span>
                                <?= $appData['address'] ?>
                            </a>
						</div>
					</div>
					<div class="col-md-2 col-sm-12">
						<div class="b-topBar__tel">
                            <div class="b-topBar__tel_inner">
                                <span class="fa fa-phone"></span>
                                <div>
                                    <a href="tel:<?= $appData['phone'] ?>" class="inheritColor"><?= $appData['phone'] ?></a><br>
                                    <a href="tel:<?= $appData['phone_2'] ?>" class="inheritColor"><?= $appData['phone_2'] ?></a>
                                </div>
                            </div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12">
						<nav class="b-topBar__nav">
							<ul>
                                <?php if (Yii::$app->user->isGuest): ?>
                             
                                    <li><a href="<?= Url::to(['/site/login']) ?>"><?= Yii::t('app', 'Log in') ?></a></li>
                                <?php else: ?>
                                    <li><a data-method="post" href="<?= Url::to(['/site/logout']) ?>"><b><?= Yii::t('app', 'Logout') ?></b> (<?= Yii::$app->user->identity->username ?>)</a></li>
                                    <li><a class="account_link" href="<?= Url::to(['/account/index']) ?>"><?= Yii::t('app', 'Account') ?></a></li>
                                <?php endif; ?>
							</ul>
						</nav>
					</div>
					<div class="col-md-3 col-sm-12">
                        <a href="/catalog/create" class="btn m-btn m-btn-dark header-create-button">
                            <?= Yii::t('app', 'ADD YOUR VEHICLE') ?>
                            <span class="fa fa-angle-right"></span>
                        </a>
					</div>
				</div>
			</div>
		</header><!--b-topBar-->

		<nav class="b-nav">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-xs-4">
						<div class="b-nav__logo wow slideInLeft" data-wow-delay="0.3s">
                            <a href="/">
                                <?php if(!empty($appData['logo'])): ?>
                                    <?= Html::img($result = Yii::$app->uploads->getThumbnail($appData['logo']->hash, 220, 75, 'inset')) ?>
                                <?php endif; ?>
                            </a>
                            <h1><a href="/"><?= $appData['logoText'] ?></a></h1>
						</div>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="b-nav__list wow slideInRight" data-wow-delay="0.3s">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
                            <div class="collapse navbar-collapse navbar-main-slide" id="nav">
                                <?=
                                Menu::widget([
                                    'activateParents' => true,
                                    'items' => Yii::$app->menu->getItems(),
                                    'options' => [
                                        'class'=>'navbar-nav-menu',
                                    ],
                                    'submenuTemplate' => "\n<ul class=\"dropdown-menu h-nav\">\n{items}\n</ul>\n"
                                ]);
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav><!--b-nav-->

        <?= $content ?>

        <div class="b-features">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-md-offset-3 col-xs-6 col-xs-offset-6">
                        <ul class="b-features__items">

                        </ul>
                    </div>
                </div>
            </div>
        </div><!--b-features-->

        <div class="b-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <aside class="b-info__aside wow zoomInLeft" data-wow-delay="0.3s">
                            <article class="b-info__aside-article">
                                <div class="h3"><a href="/site/contact"><?= Yii::t('app', 'OPENING HOURS') ?></a></div>
                                <div class="b-info__aside-article-item">
                                    <?= $appData['openingHoursFooter'] ?>
                                </div>
                            </article>
                            <article class="b-info__aside-article">
                                <div class="h3"><a href="/site/about"><?= Yii::t('app', 'About us') ?></a></div>
                                <p> <?= $appData['aboutUsFooter'] ?> </p>
                            </article>
                            <a href="/site/contact" class="btn m-btn"><?= Yii::t('app', 'Read More') ?><span class="fa fa-angle-right"></span></a>
                        </aside>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="b-info__latest">
                            <div class="h3"><a href="/catalog?ProductSearchForm[type]=3"><?//= Yii::t('app', 'Latest autos') ?>Мотоциклы в кредит</a></div>
                            <?php
                            $latestProducts = Product::find()->where('type=:type', array(':type'=>3))->active()->orderBy('id DESC')->limit(3)->all();
                            ?>
                            <?php foreach($latestProducts as $latestProduct): ?>
                            <div class="b-info__latest-article wow zoomInUp" data-wow-delay="0.3s">
                                <div class="b-info__latest-article-photo">
                                    <a href="<?= $latestProduct->getUrl() ?>">
                                        <img src="<?= $latestProduct->getTitleImageUrl(80, 53) ?>" alt="<?= $latestProduct->getFullTitle() ?>" />
                                    </a>
                                </div>
                                <div class="b-info__latest-article-info">
                                    <h6><a href="<?= $latestProduct->getUrl() ?>"><?= $latestProduct->getFullTitle() ?></a></h6>
                                    <span>
                                        <?= Yii::$app->formatter->asDecimal($latestProduct->getByrPrice()) ?> BYN<br>
                                        <?= Yii::$app->formatter->asDecimal($latestProduct->getUsdPrice()) ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="b-info__twitter">
                            <div class="h3"><a href="/news"><?= Yii::t('app', 'Latest news') ?></a></div>
                            <?php foreach ($latestNews as $new): ?>
                                <div class="b-info__latest-article wow zoomInUp" data-wow-delay="0.3s">
                                    <div class="b-info__latest-article-photo">
                                        <a href="<?= $new->getUrl() ?>">
                                            <img src="<?= $new->getTitleImageUrl(80, 53) ?>" alt="<?= $new->i18n()->header ?>" />
                                        </a>
                                    </div>
                                    <div class="b-info__latest-article-info">
                                        <a href="<?= $new->getUrl() ?>">
                                            <p><?= $new->i18n()->header ?></p>
                                            <span><?= Yii::$app->formatter->asDate($new->created_at) ?></span>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <address class="b-info__contacts wow zoomInUp" data-wow-delay="0.3s">
                            <p><a href="/site/contact"><?= Yii::t('app', 'contact us') ?></a></p>
                            <div class="b-info__contacts-item">
                                <span class="fa fa-map-marker"></span>
                                <em><?= $appData['address'] ?></em>
                            </div>
                            <div class="b-info__contacts-item">
                                <span class="fa fa-phone"></span>
                                <em><a href="tel:<?= $appData['phone'] ?>" class="inheritColor"><?= $appData['phone'] ?></a></em>
                                <br>
                                <span class="fa fa-phone"></span>
                                <em><a href="tel:<?= $appData['phone_2'] ?>" class="inheritColor"><?= $appData['phone_2'] ?></a></em>
                                <br>
                                <span class="fa fa-phone"></span>
                                <em><a href="tel:<?= $appData['phone_3'] ?>" class="inheritColor"><?= $appData['phone_3'] ?></a></em>
                            </div>
                            <div class="b-info__contacts-item">
                                <span class="fa fa-envelope"></span>
                                <em><?= Yii::t('app', 'Email') ?>:  <a href="mailto:<?= $appData['email'] ?>" class="inheritColor"><?= $appData['email'] ?></a></em>
                            </div>
                        </address>
                        <address class="b-info__map" style="overflow: hidden;">
                            <?= $appData['footerMap'] ?>
                        </address>
                    </div>
                </div>
            </div>
        </div><!--b-info-->

		<footer class="b-footer">
			<a id="to-top" href="#this-is-top"><i class="fa fa-chevron-up"></i></a>
			<div class="container">
				<div class="row">
					<div class="col-xs-4">
						<div class="b-footer__company wow fadeInLeft" data-wow-delay="0.3s">
							<div class="b-nav__logo">
								<a href="/">
                                    <?php if(!empty($appData['logo'])): ?>
                                        <?= Html::img($result = Yii::$app->uploads->getThumbnail($appData['logo']->hash, 120, 50, 'inset')) ?>
                                    <?php endif; ?>
                                </a>
							</div>
                            <p>&copy; 2013-<?= date('Y') ?> Автомобильный портал «АвтоМечта»
						</div>
					</div>
					<div class="col-xs-8">
						<div class="b-footer__content wow fadeInRight" data-wow-delay="0.3s">
							<nav class="b-footer__content-nav">
                                <?=
                                Menu::widget([
                                    'activateParents' => true,
                                    'items' => Yii::$app->menu->getTopItems(),
                                    'options' => [
                                        'class'=>'',
                                    ],
                                    'itemOptions' => [
                                        'class' => '',
                                    ],
                                    'submenuTemplate' => "\n<ul class=\"dropdown-menu h-nav\">\n{items}\n</ul>\n"
                                ]);
                                ?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</footer><!--b-footer-->
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
			if(isSafari){
				$('input[type=search],input[type=text],input[type=password],select').on('focus', function(){
				  $(this).data('fontSize', $(this).css('font-size')).css('font-size', '18px');
				}).on('blur', function(){
				  $(this).css('font-size', $(this).data('fontSize'));
				});
			}
</script>
<script data-skip-moving="true"> 
(function(w,d,u,b){ 
s=d.createElement('script');r=(Date.now()/1000|0);s.async=1;s.src=u+'?'+r; 
h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h); 
})(window,document,'https://cdn.bitrix24.by/b5147563/crm/site_button/loader_3_yfnk0g.js'); 
</script>

    </body>
</html>
<?php $this->endPage() ?>