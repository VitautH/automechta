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
<link type="text/css" rel="stylesheet" href="/css/trade-in-style.css">
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Обмен авто на авто в Беларуси</span></li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Обмен авто на авто в Беларуси</h3>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-10 ml-4 ml-lg-5">
                <div class="image">
                    <img src="/theme/images/car_1.png">
                </div>
            </div>
            <div class="text-block col-lg-6 ml-lg-5 mt-lg-5">
                <p>
                    Сегодня без автомобиля достаточно трудно представить современную жизнь. Всех граждан условно можно
                    разделить на пешеходов и водителей, но есть и третья категория – желающие продать свою машину, чтобы
                    приобрести новую. И последних с каждым годом становится все больше. Специально для них существует
                    программа, предлагаемая многочисленными автосалонами, - «trade-in».
                </p>
                <p>
                    У данного варианта немало последователей, впрочем, как и противников, каждый имеет свои аргументы, о
                    которых следует знать, обращаясь к этому виду услуги. Обмен авто на другой автомобиль - это прежде
                    всего удобно.
                </p>
                <p>
                    На комиссию принимаются автомобили, мотоциклы и другие транспортные средства.
                </p>
            </div>
            <div class="col-lg-6 hidden-mobile">
                <div class="features ml-lg-5">
                    <h3> Преимущества услуги «trade-in»</h3>
                    <ul>
                        <li>
                            <i class="fas fa-check"></i> оперативность оформления сделки;
                        </li>
                        <li>
                            <i class="fas fa-check"></i> юридическая безопасность;
                        </li>
                        <li>
                            <i class="fas fa-check"></i> простота процедуры и прочее;
                        </li>
                    </ul>
                    <p>
                        Немаловажно, что приобретаемый таким образом автомобиль с пробегом, будет технически исправлен.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="image">
                    <img src="/theme/images/car_2.png">
                </div>
            </div>
            <div class="col-lg-6 hidden-desktop">
                <div class="features ml-lg-5">
                    <h3> Преимущества услуги «trade-in»</h3>
                    <ul>
                        <li>
                            <i class="fas fa-check"></i> оперативность оформления сделки;
                        </li>
                        <li>
                            <i class="fas fa-check"></i> юридическая безопасность;
                        </li>
                        <li>
                            <i class="fas fa-check"></i> простота процедуры и прочее;
                        </li>
                    </ul>
                    <p>
                        Немаловажно, что приобретаемый таким образом автомобиль с пробегом, будет технически исправлен.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom">
    <div class="container">

        <div class="row">
            <div class="text-block col-12 mt-lg-5">
                <h3> Продать или обменять – что выгоднее? </h3>
                <p>
                    Прежде чем приступить к покупке нового автомобиля, владельцу следует продать старый. На самом деле –
                    это достаточно сложная задача. Владелец уверен, что стоимость транспортного средства, которое
                    отлично показывает себя в дороге, намного больше той, что за него предлагают на рынке или в
                    автосалонах. Поэтому многие автолюбители ищут покупателя, который по достоинству оценит состояние
                    машины, ее комплектацию, технические возможности, внешний вид, не одну неделю и даже месяц. В итоге
                    авто, который уже присмотрен в салоне в качестве следующего транспортного средства, приобретается
                    другим автолюбителем. Добавить к этому напрасно потраченные финансы, время и нервы и остается только
                    добавить, что вариант с продажей прежнего автомобиля многих владельцев не устраивает.
                </p>
                <p>
                    Кроме того, после реализации машины никто не даст гарантию, что новый автомобиль будет приобретен в
                    считанные дни. Обычно на поиски достойного транспортного средства уходит немало дней. Ведь данный
                    вид покупки отличается дороговизной, что предполагает ответственный подход к исполнению задачи. Все
                    время до покупки новой машины автолюбителю придется перемещаться пешком или на внутригородском
                    транспорте.
                </p>
                <p>
                    Допустим, что прежний автомобиль продан и у вас есть средства на приобретение подержанного авто.
                    Обычно такое транспортное средство предлагается на рынке, и здесь немало подводных камней, связанных
                    с безопасностью. Транспортное средство может быть залогом, продаваться по документам подложного
                    типа, разыскиваться в связи с разными обстоятельствами. </p>
                <p><b>Никто не гарантирует юридическую чистоту
                        автомобиля, приобретенного у неизвестных лиц.
                    </b>
                </p>
            </div>
            <div class="text-block col-12 mt-lg-4">
                <h3>Как осуществляется процедура обмена авто </h3>
                <p>
                    Услуга «trade-in» представляет собой приобретение нового транспортного средства с доплатой. Когда
                    цена прежнего авто учитывается при продаже нового взаимозачетом. Вы можете стать владельцем нового
                    или подержанного транспортного средства. Для этого реализуемая машина обязательно оценивается
                    специалистом, который проводит ее диагностику. Далее, если стороны договорились о стоимости,
                    осуществляется процедура оформления документов. Кстати, ее берет на себя автосалон, избавляя клиента
                    от неприятных очередей в ГАИ.
                </p>
                <p>
                    Единственным минусом является то, что стоимость вашего авто будет немного ниже той, что можно
                    получить за него на рынке.
                </p>
                <p>
                    <b> Но этот факт с лихвой восполняется. Вы покупаете автомобиль с пробегом, который избежал ДТП,
                        имеет
                        чистую юридическую историю, отличное
                        техническое состояние. Почти всегда такие машины не требуют вложений, многие годы эффективно
                        справляясь со своими задачами.
                    </b>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="consultation">
    <div class="container">
        <div class="row d-flex justify-content-left">
            <div class="col-lg-7">
                <h3 class="hidden-mobile">Консультация по вопросам обмена авто</h3>
                <h3 class="hidden-desktop">Наши контакты</h3>

            </div>
        </div>
        <div class="row d-flex justify-content-left">
            <div class="cirkle col-1 hidden-mobile">
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
                        <button class="show-modal-callback custom-button text-center hidden-mobile">
                            Обратный звонок
                        </button>
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
                    <i class="fas fa-at"></i> <b>E-mail:</b> automechta.by@gmqil.com
                </div>
                <button class="show-modal-callback custom-button text-center hidden-desktop">
                    Обратный звонок
                </button>
            </div>

        </div>
    </div>
</div>