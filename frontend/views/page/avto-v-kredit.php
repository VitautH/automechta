<?php
use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use common\models\CreditApplication;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\Alert;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model Page */
/* @var $provider yii\data\ActiveDataProvider */


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
$this->registerJs("require(['controllers/tools/calculator']);", \yii\web\View::POS_HEAD);
$model = new CreditApplication();
?>
<div class="overlay"></div>
<div class="slide_head_credit">
    <div class="container">
        <div class="row credits-block">
            <div class="col-md-3">
                <span class="title"> АВТО В КРЕДИТ</span>
                <span class="desc"> Без первоначального взноса</span>
                <span class="desc_mini"> (до 5000 руб. без справки о доходах)</span>
            </div>
            <div class="col-md-3">
                <div class="cblock">
                    <div class="font36 light white">до <span class="font60 yellow extrabold">20 000</span> руб.</div>
                    <div class="font16 light white">Сумма кредитования</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="cblock">
                    <div class="font36 light white">от<span class="font60 yellow extrabold">14 </span>%</div>
                    <div class="font16 light white">Годовая процентная ставка</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="cblock">
                    <div class="font36 light white">до <span class="font60 yellow extrabold">5</span> лет</div>
                    <div class="font16 light white">Срок кредитования</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="credit container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-9">
                <h2>Требования к кредитополучателю</h2>
                <ul>
                    <li><i class="fa fa-check" aria-hidden="true"></i> Трудоустройство на территории РБ</li>

                    <li><i class="fa fa-check" aria-hidden="true"></i> Возраст: 18-62 лет.</li>

                    <li> <i class="fa fa-check" aria-hidden="true"></i>Доход от 250 BYN в месяц.</li>

                    <li> <i class="fa fa-check" aria-hidden="true"></i>Трудовой стаж на текущем месте работы от 3-х месяцев.</li>

                    <li> <i class="fa fa-check" aria-hidden="true"></i>Для индивидуальных предпринимателей стаж не менее 6 –ти месяцев</li>
                </ul>
                <h2>Необходимые документы: </h2>
                <ul>
                    <li> <i class="fa fa-check" aria-hidden="true"></i>Паспорт или вид на жительство РБ</li>

                    <li><i class="fa fa-check" aria-hidden="true"></i>Военный билет для мужчин в возрасте до 27 лет</li>

                    <li><i class="fa fa-check" aria-hidden="true"></i>Справка о доходах за 3 месяца - при оформлении суммы кредита свыше 5 000 рублей

                        (в справке должны быть указаны Ваши паспортные данные и все вычеты с зарплаты).
                    </li>
                </ul>
                <h2> Условия кредитования:</h2>
                <ul>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i>    Максимальная сумма кредита до 20 000 рублей
                    </li>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i>   Без первоначального взноса
                    </li>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i>  Срок кредита от 3-х месяцев до 5 лет
                    </li>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i>    Процентная ставка от 14% годовых
                    </li>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i>   Досрочное погашение без штрафов и комиссий
                    </li>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i>  до 5000 рублей можно БЕЗ СПРАВКИ О ДОХОДАХ
                    </li>
                </ul>
            <hr>
            <h2>Для индивидуальных предпринимателей:</h2>
                <br>
           <span> Документы необходимые для подтверждения уровня дохода для индивидуальных предпринимателей:</span>
            <ul>
                <li><i class="fa fa-check" aria-hidden="true"></i>Свидетельство о регистрации</li>

                <li><i class="fa fa-check" aria-hidden="true"></i>Копии квитанций (платежных поручений) об уплате налога за последние 3 месяца</li>
            </ul>
           <h3>1. Для ИП – плательщика единого налога:</h3>

              <ul>
                  <li>
                      <i class="fa fa-check" aria-hidden="true"></i> Справка об уплате единого налога с индивидуальных предпринимателей и иных физических лиц.</ul>
                </li>
            </ul>
                <h3> 2. Для ИП – плательщика подоходного налога:</h3>
                <ul>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i> Справка о доходах от предпринимательской деятельности индивидуального предпринимателя – плательщика
                    подоходного налога (при наличии в налоговом органе информации о доходах индивидуального предпринимателя).
                    </li>
                </ul>
                <h3>3. Для ИП – плательщика налога по упрощенной системе:</h3>
                <ul>
                    <li>
                        <i class="fa fa-check" aria-hidden="true"></i> Выписка из данных учета налоговых органов об исчисленных и уплаченных суммах налогов, сборов (пошлин), пеней.</span>
                    </li>
                </ul>
           <hr>
            </div>
        <div class="col-md-3">
            <div class="credit_block">
                <h2> ЗАЯВКА НА КРЕДИТ</h2>
                <?php Pjax::begin(['enablePushState' => false,'id' => 'pajax']); ?>
                <?php if ($model->id): ?>
                <?php else: ?>
                    <?php $form = ActiveForm::begin(['action'=>'/tools/credit-application','options' => ['data-pjax' => true]]); ?>
                        <?= $form->field($model, 'name', ['options' => ['class' => 'b-submit__main-element']])
                        ->textInput(['class' => ''])->label($model->getAttributeLabel('name')) ?>
                    <?= $form->field($model, 'firstname', ['options' => ['class' => 'b-submit__main-element']])
                        ->textInput(['class' => ''])->label($model->getAttributeLabel('firstname')) ?>
                    <?= $form->field($model, 'phone', ['options' => [ 'max' => 19, 'min' => 19,'class' => 'b-submit__main-element']])
                        ->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '+375 (99) 999-99-99',
                    ])->textInput(['class' => '','required'=>true])->label($model->getAttributeLabel('phone') . ' <span class="text-danger">*</span>') ?>
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                <?php endif; ?>
                <?php Pjax::end(); ?>
                </div>
            <div class="info_credit">
               <div class="avatar"></div>
                <span>
                   Нина
                </span>
                <p>
                    Консультант по вопросам автокредитования
                </p>
                <hr>
                <span class="phone"><a href="tel:+375333215555">+375(33)321-55-55</a></span>
                <span class="email">automechta.by@gmail.com</span>
                <p>
                    Ежедневно с 10:00 до 18:00
                    <br>
                    г. Минск, ул. Суржаская, 8А
                    <br>
                    ст. метро Институт Культуры
                </p>
            </div>
            <div class="b-detail__main">
            <div class="right_block">
                <div class="b-detail__main-aside-payment wow zoomInUp" data-wow-delay="0.5s">
                    <h2 class="s-titleDet"><?= Yii::t('app', 'CAR PAYMENT CALCULATOR') ?></h2>
                    <div class="b-detail__main-aside-payment-form">
                        <div class="calculator-loan" style="display: none;"></div>
                        <form action="/" method="post" class="js-loan">
                            <label><?= Yii::t('app', 'ENTER LOAN AMOUNT') ?></label>
                            <input type="text" placeholder="<?= Yii::t('app', 'LOAN AMOUNT') ?>"
                                   value="0" name="price" />
                            <label><?= Yii::t('app', 'Prepayment') ?></label>
                            <input type="number" placeholder="<?= Yii::t('app', 'Prepayment') ?>"
                                   value="0" name="prepayment" id="prepayment" min="0"/>
                            <label><?= Yii::t('app', 'RATE IN') ?> %</label>
                            <div class="s-relative">
                                <select name="rate" class="m-select" id="rate">
                                <option value="14">Приорбанк 14%</option>
                                <option value="22">ВТБ 22%</option>
                                <option value="14.5">БТА 14,5%</option>
                                <option value="16.8">СтатусБанк 16,8%</option>
                            </select>
                            <span class="fa fa-caret-down"></span>
                            </div>
                            <label><?= Yii::t('app', 'LOAN TERM') ?></label>
                            <div class="s-relative">
                                <select name="term" class="m-select" id="term">
                                    <option value="6m"><?= Yii::t('app', '6 month') ?></option>
                                    <option value="12m"><?= Yii::t('app', 'One year') ?></option>
                                    <option value="24m"><?= Yii::t('app', '2 years') ?></option>
                                    <option value="36m"><?= Yii::t('app', '3 years') ?></option>
                                    <option value="48m"><?= Yii::t('app', '4 years') ?></option>
                                    <option value="60m"
                                            selected><?= Yii::t('app', '5 years') ?></option>
                                </select>
                                <span class="fa fa-caret-down"></span>
                            </div>
                            <button type="submit"
                                    class="btn m-btn"><?= Yii::t('app', 'ESTIMATE PAYMENT') ?>
                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            </button>
                        </form>
                        <div class="b-detail__main-aside-about-call js-loan-results">
                            <div><span class="js-per-month"> </span>
                                BYN
                                <p>в месяц</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="container">
    <div class="row">

    </div>
</div>