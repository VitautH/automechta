<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use common\models\AppData;
use common\models\Page;
use common\models\MetaData;

$metaData = MetaData::getModels($model);
$this->title = $metaData[MetaData::TYPE_TITLE]->i18n()->value;
\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $metaData[MetaData::TYPE_DESCRIPTION]->i18n()->value
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaData[MetaData::TYPE_KEYWORDS]->i18n()->value
]);

$appData = AppData::getData();
?>
<link type="text/css" rel="stylesheet" href="/css/vykup-style.css">
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Срочный выкуп авто в Беларуси</span></li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Срочный выкуп авто в Беларуси</h3>
            </div>
            <div class="col-12">
                <b>Круглосуточный срочный выкуп авто в Минске и по всей территории Беларуси. Скупка автомобилей. </b>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-10 ml-4 ml-lg-5">
                <div class="image">
                    <img src="/theme/images/services_img_3.png">
                </div>
            </div>
            <div class="text-block col-lg-6 ml-lg-5 mt-lg-5">
                <h3>Покупаем автомобили за наличные деньги в течение 30 минут. </h3>
                <p>
                    Срочный выкуп авто - услуга для тех, кому нужно быстро продать автомобиль и получить деньги.
                </p>
            </div>
            <div class="col-lg-5 ml-lg-5 hidden-desktop">
                <div class="image mt-2 mt-lg-0">
                    <img src="/theme/images/services_img_4.png">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-vykup ml-lg-5">
                    <h3>Срочный выкуп авто</h3>
                    <p>
                        Бывают такие жизненные ситуации, когда срочно нужны деньги. Оформлять кредит в банке долго,
                        взять в
                        долг не у кого. Остается продать имущество. Выставлять на торг квартиру - слишком жирно, а вот
                        отдать в скупку легковую машину и получить деньги -самое то.
                    </p>
                    <p>
                        Впрочем, услугой скупки авто пользуются не только те, кто нуждается в срочных деньгах. С самим
                        автомобилем много чего может случиться. Старые подержанные машины, которым уже пропуски ставят
                        на
                        свалке, битые авто или после ДТП. Машины, испорченные вандалами или природной стихией.
                    </p>
                    <p>
                        К тому, чтобы отдать машину в срочный выкуп, иногда подталкивает замкнутый круг некачественного
                        ремонта. Приезжаешь на СТО, поручаешь машину проверенному мастеру, платишь энную сумму денег, а
                        через неделю везешь к еще более проверенному мастеру с еще более высоким ценником. И в перерывах
                        между СТО ездишь на троллейбусе.
                    </p>
                </div>
            </div>
            <div class="col-lg-5 ml-lg-5 hidden-mobile">
                <div class="image">
                    <img src="/theme/images/services_img_4.png">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom">
    <div class="container">

        <div class="row">
            <div class="documents col-12 mt-lg-5">
                <div class="row">
                    <div class="creative col-lg-2 col-12">

                    </div>
                    <div class="col">
                        <h3>Документы на выкуп машин </h3>
                        <p>
                            Владелец должен снять машину с учета в ГАИ. В компанию, которая занимается скупкой машин, он
                            должен предоставить:
                            <br>
                            - паспорт;     <br>
                            - транзитные номера;     <br>
                            - технический паспорт;     <br>
                            - страховое свидетельство;     <br>
                            - комплекты ключей;     <br>
                            - документы о техосмотре или сервисном обслуживании (необязательно).     <br>
                        </p>
                    </div>
                </div>
            </div>
            <div class="text-block col-12 mt-lg-4">
                <h3>Скупка б/у авто: <span class="red">как не продешевить</span></h3>
                <p>
                    Понятно, что не хочется за бесценнок продовать машину с пробегом. Перед тем, как обращаться в
                    компанию по выкупу авто, лучше посидеть в интернете и оценить, сколько на рынке объективно стоит
                    машина.</p>
                <p>Чтобы потом не было обидно, что её низко оценили, или чтобы поторговаться, если становится
                    очевидным, что выкупщик занижает цену.
                    На выкуп принято пригонять б\у авто чистым снаружи и в салоне. И оценщику приятно, и выгоднее
                    продать можно. Также следует честно рассказать о техническом состоянии авто. Стремление утаить недостатки понятно, не хочется продовать за недорого, но зачем так поступать с достоинствами. Плюсы автомобиля нужно обязательно выпятить.
                </p>
                <p>
                     И главное, не питать иллюзий, пользуясь услугой автовыкупа. Никто не получит 100% стоимостии машины. Обычно это коло 80-95%. Но зато в течении получаса наличными.
                </p>
            </div>
        </div>
        <div class="scheme row justify-content-center">
            <div class="col-12">
                <h3>Скупка автомобилей в Минске. Схема работы.</h3>
                <span>Скупаем поддержанные машины с пробегом</span>
            </div>
            <div class="col-lg-3">
                <div class="circle-icon phone-icon">
                </div>
                <div class="scheme-text">
<span class="title">
    Звонок
</span>
                    <p>
                        Вы звоните нам по телефонам, указанным в контактах, и рассказываете про свою машину: марку,
                        модель, год выпуска, техсостояние и комплектацию. Наши специалисты с ваших слов предварительно
                        оценивают машину.
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="circle-icon marker-icon">
                </div>
                <div class="scheme-text">
<span class="title">
    Встреча
</span>
                    <p>
                        Если вы согласны с ценой, которую вам назвали по телефону, это лучшее предложение, наш оценщик
                        выезжает к вам в течение 30 минут или в любое подходящее для вас время. Он тщательно осматривает
                        авто, знакомится с документами и сразу же оформляет договор.
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="circle-icon money-icon">
                </div>
                <div class="scheme-text">
<span class="title">
    Деньги
</span>
                    <p>
                        После того, как подписаны нужные бумаги, мы рассчитываемся с вами наличными либо переводим
                        деньги на вашу карту или банковский счет.
                        Осмотр, изучение документов и заключение договора отнимают 30 минут.
                        Расчет происходит сразу после того, как подписывается договор.
                    </p>
                </div>
            </div>
            <div class="content col-12">
                <p>
                    Расчет за любую машину происходит сразу после того, как подписывается договор. Мы бережно относимся
                    к клиентам и гарантируем конфиденциальность данных. Никто и никогда не узнает, что вы
                    воспользовались нашей услугой.

                    Работаем 24 часа. Если у вас возникла острая потребность в деньгах, мы готовы в любое время суток
                    дать консультацию, оценить стоимость б/у машины и выехать на ваш адрес для заключения договора и
                    расчета.

                    Салон «АвтоМечта» занимается выкупом авто в Минске с выездом за наличные, принимает авто на
                    комиссию, сопровождает сделки купли-продажи транспортных средств, оформляет страховки и выписывает
                    счета-справки. Наши менеджеры всегда готовы проконсультировать вас по продаже и другим операциям с
                    автомобилями.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="contact">
    <div class="container">
        <div class="row  align-items-center  justify-content-center">
            <div class="col-12">
                <h3>Наши контакты </h3>
            </div>
            <div class="phone-block col-12 col-lg-3">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="col">
                        <a href="tel:<?= $appData['phone_credit_1'] ?>"
                           class="inheritColor"><?= $appData['phone_credit_1'] ?></a>
                        <a href="tel:<?= $appData['phone_credit_2'] ?>"
                           class="inheritColor"><?= $appData['phone_credit_2'] ?></a>
                        <a href="tel:<?= $appData['phone_credit_3'] ?>"
                           class="inheritColor"><?= $appData['phone_credit_3'] ?></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="open-hours">
                    <i class="fas fa-clock"></i> <b>Пн - Вс:</b> 09:00 - 18:00. Ежедневно
                </div>
                <div class="address">
                    <i class="fas fa-map-marker-alt"></i> <b>Адрес:</b> г. Минск, ул. Суражская, 8А
                </div>
                <div class="email">
                    <i class="fas fa-at"></i> <b>E-mail:</b> automechta.by@gmail.com
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12  text-lg-center">
                <button class="show-modal-callback custom-button">
                    Обратный звонок
                </button>
            </div>
    </div>
        </div>
    </div>