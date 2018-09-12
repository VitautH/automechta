<?php

use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\helpers\Html;
use common\models\CreditApplication;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\Alert;
use yii\widgets\MaskedInput;
use common\models\User;

$appData = AppData::getData();
$asidePages = Page::find()->active()->aside()->andWhere('id<>' . $model->id)->orderBy('views DESC')->limit(3)->all();
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
//$this->registerJsFile('@web/build/controllers/tools/calculator.js');
$this->registerJs("require(['controllers/tools/calculator']);", \yii\web\View::POS_HEAD);
$model = new CreditApplication();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
<script src="/js/calculator.js"></script>
<script src="/js/avto-v-credit.js"></script>
<link type="text/css" rel="stylesheet" href="/css/avto-v-kredit.css">
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
                <h3>
                    Авто в кредит
                </h3>
            </div>
            <div class="col-12">
                <p>
                   <b>Покупка автомобиля в кредит - серьёзный шаг в жизни каждого человека. Мы предлагаем вам получить
                    кредит на покупку транспортного средства , и приобрести его уже сегодня.</b>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6">
                <i class="far fa-check-square"></i>
                <span>
Без первоначального <br> взноса
                </span>
            </div>
            <div class="col-lg-3 col-6">

                <i class="far fa-check-square"></i>
                <span>
Сумма кредитования <br>до 20 000 руб.
                </span>

            </div>
            <div class="col-lg-3 col-6">
                <i class="far fa-check-square"></i>
                <span>
Срок кредитования <br>до 5 лет
                </span>
            </div>
            <div class="col-lg-3 col-6">
                <i class="far fa-check-square"></i>
                <span>
Годовая процентная  <br> ставка  от 15%
                </span>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="demands">
                    <h3>
                        Требования к кредитополучателю
                    </h3>
                    <ul>
                        <li> Трудоустройство на территории РБ</li>
                        <li> Возраст: 18-62 лет.</li>
                        <li>Доход от 250 BYN в месяц.</li>
                        <li> Трудовой стаж на текущем месте работы от 3-х месяцев.</li>
                        <li>Для индивидуальных предпринимателей стаж не менее 6 –ти месяцев</li>
                    </ul>
                </div>

                <div class="conditions">
                    <h3>
                        Условия кредитования
                    </h3>
                    <ul>
                        <li>
                            Максимальная сумма кредита до 20 000 рублей
                        </li>
                        <li>
                            Без первоначального взноса
                        </li>
                        <li>
                            Срок кредита от 3-х месяцев до 5 лет
                        </li>
                        <li>
                            Процентная ставка от 16% годовых
                        </li>
                        <li>
                            Досрочное погашение без штрафов и комиссий
                        </li>
                        <li>
                            Без справок о доходах (до 5000 рублей)
                        </li>
                    </ul>
                </div>
                <div class="documents">
                    <div class="row">
                        <div class="creative col-lg-2 col-12">

                        </div>
                        <div class="col">
                            <h3>Необходимые документы</h3>
                            <p>
                                - Паспорт или вид на жительство РБ <br>
                                - Военный билет для мужчин в возрасте до 27 лет <br>
                                - Справка о доходах за 3 месяца - при оформлении суммы кредита свыше 5 000 рублей (в
                                справке должны быть указаны Ваши паспортные данные и все вычеты с зарплаты).
                            </p>
                        </div>
                    </div>
                </div>
                <div class="documents-for-company">
                    <h3>Для индивидуальных предпринимателей</h3>
                    <div class="documents">
                        <div class="row">
                            <div class="creative col-lg-2 col-12">

                            </div>
                            <div class="col">
                                <h3>Необходимые документы</h3>
                                <p>
                                    - Свидетельство о регистрации <br>
                                    - Копии квитанций (платежных поручений) об уплате налога за последние 3 месяца
                                </p>
                            </div>
                        </div>
                    </div>

                    <ul>
                        <li>
                            <div class="row">
                                <div class="col-0 list"><span>1</span></div>
                                <div class="col text">
                                    <b> Для ИП – плательщика единого налога:</b>
                                    <br>
                                    <span>Справка об уплате единого налога с индивидуальных предпринимателей и иных физических лиц.</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-0 list"><span>2</span></div>
                                <div class="col text">
                                    <b> Для ИП – плательщика подоходного налога:</b>
                                    <br>
                                    <span>
                                      Справка о доходах от предпринимательской деятельности индивидуального предпринимателя – плательщика подоходного налога (при наличии в налоговом органе информации о доходах индивидуального предпринимателя).
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-0 list"><span>3</span></div>
                                <div class="col text">
                                    <b> Для ИП – плательщика налога по упрощенной системе:</b>
                                    <br>
                                    <span>Выписка из данных учета налоговых органов об исчисленных и уплаченных суммах налогов, сборов (пошлин), пеней.</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="credit_block">
                    <h3> Заявка на кредит</h3>
                        <?php $form = ActiveForm::begin(['action'=>'/tools/credit-application','options' => ['id' => 'form-credit-application']]); ?>
                        <?= $form->field($model, 'name', ['options' => ['class' => 'b-submit__main-element']])
                            ->textInput(['placeholder'=>'Имя','class' => ''])->label($model->getAttributeLabel('name'))->label(false) ?>
                        <?= $form->field($model, 'firstname', ['options' => ['class' => 'b-submit__main-element']])
                            ->textInput(['placeholder'=>'Фамилия','class' => ''])->label($model->getAttributeLabel('firstname'))->label(false) ?>
                        <?= $form->field($model, 'phone', ['options' => [ 'max' => 19, 'min' => 19,'class' => 'b-submit__main-element']])
                            ->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '+375 (99) 999-99-99',
                            ])->textInput(['class' => '','placeholder'=>'Телефон','required'=>true])->label(false) ?>
                    <div class="col">
                        <?= Html::submitButton('Отправить', ['class' => 'custom-button text-center']) ?>
                    </div>
                        <?php ActiveForm::end(); ?>
                </div>
                <a href="/documents/spravka-2018.doc" class="download-income"><i class="fas fa-download mr-2"></i>Справка о доходах</a>
                <div class="b-detail__main-aside-payment">
                    <h3 class="s-titleDet">Кредитный калькулятор</h3>
                    <div class="b-detail__main-aside-payment-form">
                        <div class="calculator-loan" style="display: none;"></div>
                        <form action="/" method="post" class="js-loan">
                            <div class="form-block">
                            <label>Цена, BYN</label>
                            <input type="text" placeholder="<?= Yii::t('app', 'LOAN AMOUNT') ?>"
                                   value="0" name="price" />
                            </div>
                            <div class="form-block">
                            <label>Первоначальный взнос, BYN</label>
                            <input type="number" placeholder="<?= Yii::t('app', 'Prepayment') ?>"
                                   value="0" name="prepayment" id="prepayment" min="0"/>
                            </div>
                            <div class="form-block">
                            <label><?= Yii::t('app', 'RATE IN') ?>, %</label>
                                <div class="m-select">
                                <select name="rate" class="" id="rate">
                                    <option value="<?= $appData['prior_bank']?>">Приорбанк <?= $appData['prior_bank']?>%</option>
                                    <option value="<?= $appData['vtb_bank']?>">ВТБ <?= $appData['vtb_bank']?>%</option>
                                    <option value="<?= $appData['bta_bank']?>">БТА <?= $appData['bta_bank']?>%</option>
                                    <option value="<?= $appData['status_bank']?>">СтатусБанк <?= $appData['status_bank']?>%</option>
                                </select>
                                <i class="fas fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="form-block">
                                <label><?= Yii::t('app', 'LOAN TERM') ?></label>
                                <div class="m-select">
                                <select name="term" id="term">
                                    <option value="6m"><?= Yii::t('app', '6 month') ?></option>
                                    <option value="12m"><?= Yii::t('app', 'One year') ?></option>
                                    <option value="24m"><?= Yii::t('app', '2 years') ?></option>
                                    <option value="36m"><?= Yii::t('app', '3 years') ?></option>
                                    <option value="48m"><?= Yii::t('app', '4 years') ?></option>
                                    <option value="60m"
                                            selected><?= Yii::t('app', '5 years') ?></option>
                                </select>
                                <i class="fas fa-caret-down"></i>
                                </div>
                            </div>

                            <div class="b-detail__main-aside-about-call js-loan-results">
                                <p><b><span class="js-per-month"> </span>
                                    BYN</b> / месяц
                                </p>
                            </div>

                            <button type="submit"
                                    class="custom-button">Рассчитать платежи
                                <i class="fas fa-angle-right" aria-hidden="true"></i>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="consultation">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <h3 class="hidden-mobile">Консультация по вопросам автокредитования</h3>
                <h3 class="hidden-desktop">Наши контакты</h3>

            </div>
        </div>
        <div class="row">
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
                    <i class="fas fa-at"></i> <b>E-mail:</b> automechta.by@gmail.com
                </div>
                <button class="show-modal-callback custom-button text-center hidden-desktop">
                    Обратный звонок
                </button>
            </div>

        </div>
    </div>
</div>
<div class="partner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Наши партнёры</h3>
            </div>
            <div class="col-12">
                <img src="/theme/images/PNG_eng.png">
                <img src="/theme/images/vtb.png">
                <img src="/theme/images/bta.png">
                <img src="/theme/images/logo-idea-bank.png">
                <img src="/theme/images/logo-mtbank.png">
                <img src="/theme/images/status.png">
            </div>
        </div>
    </div>
</div>