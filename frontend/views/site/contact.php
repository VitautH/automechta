<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\widgets\Alert;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
<script src="/js/callback-contacts.js"></script>
<script src="/js/callback.js"></script>
<link type="text/css" rel="stylesheet" href="/css/contact-style.css">
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Контакты</span></li>
        </ul>
    </div>
</div>
<div class="header">
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>Контакты</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <span>Автомобильный портал «АвтоМечта»</span>
        </div>
    </div>
</div>
</div>
<div class="info-block">
    <div class="container">
        <div class="row">
            <div class="phone-block col-12 col-lg-3">
                <div class="row">
                <div class="col-1">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="col">
                <a href="tel:<?= $appData['phone_credit_1'] ?>" class="inheritColor"><?= $appData['phone_credit_1'] ?></a>
               <a href="tel:<?= $appData['phone_credit_2'] ?>" class="inheritColor"><?= $appData['phone_credit_2'] ?></a>
              <a href="tel:<?= $appData['phone_credit_3'] ?>" class="inheritColor"><?= $appData['phone_credit_3'] ?></a>
                </div>
            </div>
            </div>
            <div class="col-12 hidden-desktop">
                <button class="callback-button custom-button hidden-desktop">Обратный звонок</button>
                <div class="call-back call-back-phone">
                <?= Html::beginForm(['/tools/callback'], 'post', ['class' => 'callback-form']); ?>
                <?= Html::textInput('Callback[name]', '', ['placeholder' => 'Имя', 'class' => 'callback-name-field', 'required' => 'required']); ?>
                <?= Html::textInput('Callback[phone]', '', ['placeholder' => 'Телефон', 'class' => 'callback-phone-field', 'required' => 'required']); ?>
                <?= Html::submitButton('Отправить <i class="fas fa-arrow-right"></i>', ['class' => 'custom-button icon-right-btn']) ?>
                <?= Html::endForm() ?>
                </div>
            </div>
            <div class="col-12 col-lg-3">
<div class="open-hours">
    <i class="fas fa-clock"></i>  <b>Пн - Вс:</b> 09:00 - 18:00. Ежедневно
</div>
                <div class="address">
                    <i class="fas fa-map-marker-alt"></i>      <b>Адрес:</b> г. Минск, ул. Суражская, 8А
                </div>
                <div class="email">
                    <i class="fas fa-at"></i>     <b>E-mail:</b> automechta.by@gmail.com
                </div>
            </div>
            <div class="col-12 col-lg-5 ml-lg-5">
<div class="company-address">
    <div class="row">
   <div class="col-1">
       <i class="fas fa-id-card"></i>
   </div>
        <div class="col">  <b>Юридический адрес:</b> ИП Соболевский Никита Викторович
    УНП: 191901952 выданное 04.03 2013г
    р\с BY92SOMA30130041800101000933
    в ЗАО «Идея Банк» , БИК SOMABY22
    г. Минск пр-кт Независимости 149-74
</div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>
<div class="container  hidden-mobile"><div class="row">
     <div class="col-lg-4">
         <button class="callback-button custom-button  hidden-mobile">Обратный звонок</button>
         <div class="call-back call-back-desktop">
             <?= Html::beginForm(['/tools/callback'], 'post', ['class' => 'callback-form']); ?>
             <?= Html::textInput('Callback[name]', '', ['placeholder' => 'Имя', 'class' => 'callback-name-field', 'required' => 'required']); ?>
             <?= Html::textInput('Callback[phone]', '', ['placeholder' => 'Телефон', 'class' => 'callback-phone-field', 'required' => 'required']); ?>
             <?= Html::submitButton('Отправить <i class="fas fa-arrow-right"></i>', ['class' => 'custom-button icon-right-btn']) ?>
             <?= Html::endForm() ?>
         </div>
    </div>
</div></div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>Компания «АвтоМечта» работает без посредников и не привлекает специалистов со стороны, давая возможность клиентам удостовериться в правильном оформлении документации, а также право сэкономить часть денежной суммы.</p>
            </div>
        </div>
    </div>
</div>
<div class="maps">
    <? echo $appData['map']; ?>
</div>

<div class="features">
    <div class="container">
        <div class="row">
<h3>Наши преимущества</h3>

            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-check-square"></i>
                    </div>
                    <div class="col">
                       <b> Ценность каждого клиента.</b> Это  неотъемлемая часть характера компании. Прежде всего — важны взгляд и точка зрения клиента. На фоне его интересов создается максимальный комфорт и удобство выбора.
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-check-square"></i>
                    </div>
                    <div class="col">
                        <b> Процедура получения кредитов совершенно прозрачная.</b> Представитель компании подбирает самый оптимальный вариант взятия ссуды, вводится в полный курс дела: платежи, проценты, сроки погашения, условия и др., подтверждая свои слова на представленном договоре.
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-check-square"></i>
                    </div>
                    <div class="col">
                        <b>  Тщательное рассмотрение всех заключаемых договоров.</b> Компании «АвтоМечта» уже удалось зарекомендовать себя, как надежную организацию на отечественном рынке. Подобное достигается, только при серьезном деловом подходе, заострении внимания на всех возможных деталях, а также работе исключительно в целях своих клиентов.
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-check-square"></i>
                    </div>
                    <div class="col">
                     <b>   Долгосрочные цели развития компании в автобизнесе. </b>На сегодняшний день принцип работы компании — функциональность и качество услуг, характерных для высококлассного общества. Специалисты компании являются профессионалами в своем деле, способными выполнить любые задачи и удовлетворить самые разные потребности.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>