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
<link type="text/css" rel="stylesheet" href="/css/prijom-avto-na-komissiju.css">
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Приём авто на комиссию в Минске</span></li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Приём авто на комиссию в Минске</h3>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-10 ml-4 ml-lg-5">
                <div class="image">
                    <img src="/theme/images/services_img_1.png">
                </div>
            </div>
            <div class="text-block col-lg-6 ml-lg-5 mt-lg-5">
                <h3>Услуга для тех, кому недосуг заниматься самостоятельной продажей автомобиля.</h3>
                <p>
                    Постановка автомобиля на комиссию означает, что вы сдаете комиссионному магазину свой автомобиль, а
                    он обязуется продать ее по оговоренной с вами цене, плюс комиссионный процент. На комиссию
                    принимаются автомобили, мотоциклы и другие транспортные средства.
                </p>
            </div>
            <div class="col-lg-5 ml-lg-5 hidden-desktop">
                <div class="image mt-2 mt-lg-0">
                    <img src="/theme/images/services_img_2.png">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-vykup ml-lg-5">
                    <h3>Мы работает за Вас</h3>
                    <p>
                        Круговорот авто, бывших в употреблении, кажется, бесконечен. Опытные автомобилисты готовы сами
                        продавать свои автомобили, размещать рекламу на площадках в интернете, устраивать смотрины и
                        торговаться до потери пульса. Владельцы с дефицитом времени склоняются к услугам площадок по
                        комиссионной продаже авто. Все хлопоты по размещению рекламы, предпродажной подготовке
                        автомобиля, общению с потенциальными покупателями, которые, признаем, не всегда бывают
                        адекватны, берет на себя комиссионный магазин.
                    </p>
                    <p>
                        Также склонны поставить автомобиль на комиссию те, кто пока не сильно опытен в автомобильной
                        тематике, боится по незнанию продешевить или сильно уступить в цене, поддавшись на уговоры.
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
                    <div class="creative col-lg-2 col-10">

                    </div>
                    <div class="col">
                        <h3>Документы для сдачи авто на комиссию</h3>
                        <p>
                            -паспорт или заверенную доверенность на продажу машины; <br>
                            -транзитные номера; <br>
                            -техпаспорт; <br>
                            -страховое свидетельство; <br>
                            -комплект ключей; <br>
                            -документы о техосмотре и сервисном обслуживании (необязательно). <br>
                            <br>
                            *Перед сдачей авто на комиссию владелец должен снять его с учета в ГАИ и предоставить авто в
                            исправном состоянии, чистом снаружи и в салоне. В баке должно быть минимум 20 л топлива. В
                            комиссионном магазине «АвтоМечта» мы предлагаем бесплатную предпродажную чистку и мойку
                            вашего автомобиля, а также стоянку и охрану на период продажи.
                        </p>
                    </div>
                </div>
            </div>
            <div class="text-block col-12 mt-lg-4">
                <h3>Договор комиссии авто</h3>
                <p>
                    Между владельцем авто и комиссионным магазином заключается договор. В нем указывается предмет
                    договора: марка автомобиля, цвет, год выпуска, объем двигателя, идентификационный номер кузова /
                    номер шасси (рамы), а также права и обязанности сторон.
                </p>
                <p>
                    В частности, автовладелец после передачи автомобиля комиссионке не должен предпринимать каких-либо
                    усилий, чтобы продать авто, т.е. не подавать и убрать все текущие рекламные объявления в СМИ и
                    интернете. Реализацией после заключения договора занимается строго компания, принявшая авто на
                    комиссию.
                </p>
                <p>
                    При этом комиссионный магазин несет полную ответственность за сохранность автомобиля. Если владелец
                    отдал авто на комиссию, а затем передумал его продавать, то до заключения договора купли-продажи с
                    потенциальным покупателем вправе расторгнуть договор, заключенный с комиссионкой, и забрать авто.
                </p>
            </div>
            <div class="text-block col-12 mt-lg-4">
                <h3>Продажа автомобиля на комиссии</h3>
                <p>
                    Цена, по которой комиссионная площадка будет продавать автомобиль, а также размер ее вознаграждения
                    фиксируются в договоре.
                </p>
                <p>
                    Комиссионное вознаграждение - это не только некий процент от продажи, но и расходы, связанные с
                    исполнением обязательств по договору, в том числе расходы на рекламу, хранение и содержание
                    автомобиля.
                </p>
                <p>
                    Если магазин продаст автомобиль по цене выше той, что указана в договоре, то разницу она забирает
                    себе. В том случае, если комиссионка реализует авто по цене меньше той, что указана в договоре, то
                    она теряет в комиссионном вознаграждении, но владелец авто получает ту сумму, которая написана в
                    договоре. И ни копейкой меньше. Условно говоря, те деньги, что зафиксированы в договоре, владелец
                    машины должен получить при любых обстоятельствах.
                </p>
                <p>

                    Если автовладелец решил, что промахнулся с ценой и его ласточка стоит дороже, то изменить стоимость
                    он сможет только после согласования с комиссионкой и подписания акта уценки.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="comissija">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>
                    Прием автомобилей на комиссию в салон «АвтоМечта»
                </h3>
                <ul>
                    <li>
                        <div class="row">
                            <div class="col-0 list"><span>1</span></div>
                            <div class="col text">
                                Звоните по телефонам, указанным на нашем сайте. Мы сообщаем примерную цену вашего
                                автомобиля.
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-0 list"><span>2</span></div>
                            <div class="col text">
                                Приезжаете на авто к нам на площадку. Если вам неудобно или нет времени к нам добираться,
                                наш сотрудник выезжает к вам..
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-0 list"><span>3</span></div>
                            <div class="col text">
                                Мы оцениваем ваш автомобиль и даем рекомендации по цене.
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-0 list"><span>4</span></div>
                            <div class="col text">
                                Заключаем договор, размещаем рекламу вашего автомобиля на нашем сайте и всех доступных
                                рекламных
                                площадках.
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-0 list"><span>5</span></div>
                            <div class="col text">
                                Продаем авто и связываемся с вами, чтобы уже на следующий день передать деньги.
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="contact">
    <div class="container">
        <div class="row">
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
            <div class="col-12 col-lg-3">
                <div class="call-back-block">
                <span class="hidden-mobile">
                    Закажите консультацию в 3 клика
                </span>
                    <button class="show-modal-callback custom-button">
                        Обратный звонок
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>