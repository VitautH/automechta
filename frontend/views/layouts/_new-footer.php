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

$appData = AppData::getData();
?>
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
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" href="/css/slick-theme.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
      integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
      crossorigin="anonymous">
<link rel="stylesheet" href="/theme/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="/css/accordion-menu.css">
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110162737-1"></script>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>

<script src="/build/controllers/site/modal-main.js"></script>
<script src="/js/new-bootstrap.min.js"></script>
<script src="/js/new-menu.js"></script>
<script src="/js/accordion-menu.js"></script>
<script src="/js/readmore.js"></script>
<script src="/js/calculator.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="/build/controllers/site/main-searchForm.js"></script>
<script src="/js/callback.js"></script>
<script src="/js/carousel.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter43319124 = new Ya.Metrika2({
                    id: 43319124,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true,
                    trackHash: true,
                    ecommerce: "dataLayer"
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks2"); </script> <!-- /Yandex.Metrika counter -->
<!--        <script data-main="../build/config" src="js/require.js"></script>-->
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-110162737-1');
</script>
<script>
    $(document).ready(function () {

        $('#show-how-it-works').click(function (e){
            e.preventDefault();
            $('.how-it-works-hidden').show();
            $('#show-how-it-works').hide();
        });
        var ScreenWidth = screen.width;
        if (ScreenWidth < 3000) {
            $('.brands').readmore({
                speed: 75,
                maxHeight: 350,
                moreLink: '<a class="show-all" href="#">Показать все <i class="fas fa-chevron-right ml-2"></i></a>',
                lessLink: '<a class="show-all" href="#">Скрыть <i class="fas fa-chevron-right ml-2"></i></a>',
            });
        }
    });
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
    });
</script>
</body>
<?php $this->endBody() ?>
</html>
<? $this->endPage(); ?>
