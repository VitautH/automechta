<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\models\CreditApplication;
use common\widgets\Alert;

$this->title = Yii::t('app', 'Credit application');

$this->registerJs("require(['controllers/tools/creditApplication']);", \yii\web\View::POS_HEAD);
//$this->registerJsFile("@web/build/controllers/tools/calculator.js", \yii\web\View::POS_HEAD);
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
$model->term = '60m';
$model->loans_payment = '0';

?>
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft"><?= Yii::t('app', 'Online credit application') ?></h1>
    </div>
</section><!--b-pageHeader-->

<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            $this->title
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div>
<!--b-breadCumbs-->
<section class="credit_applecation b-contacts s-shadow">
    <div class="container">
        <div class="credit row">
            <div class="col-xs-12">
                <?= Alert::widget() ?>
            </div>
            <div class="col-md-9 col-xs-12">
            <?php $form = ActiveForm::begin([
                'id' => 'credit-application-form',
                'fieldConfig' => [
                    'options' => [
                        'class' => '',
                    ]
                ],
                'options' => [
                    'class' => 's-submit wow zoomInUp',
                    'data-wow-delay' => '0.5s',
                ]
            ]); ?>
                <div class="b-contacts__form">
                    <div id="success"></div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'firstname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label($model->getAttributeLabel('firstname')) ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'name', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label($model->getAttributeLabel('name')) ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'lastname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label($model->getAttributeLabel('lastname')) ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'phone', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field required_field', 'required'=>true])->label($model->getAttributeLabel('phone') . ' <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'dob', ['options' => ['class' => 'b-submit__main-element']])->input('date', ['class'=>'field'])->label($model->getAttributeLabel('dob')) ?>
                    </div>
                    <div class="col-xs-12">
                        <div class='s-relative'>
                        <?= $form->field($model, "sex", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getSexList(), ['class' => 'm-select field','prompt' => 'Выбрать'])->label($model->getAttributeLabel('sex')) ?>
                        <span class="fa fa-caret-down"></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class='s-relative'>
                        <?= $form->field($model, "previous_conviction", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getConvictionList(), ['class' => 'm-select field','prompt' => 'Выбрать'])->label($model->getAttributeLabel('previous_conviction')) ?>
                        <span class="fa fa-caret-down"></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class='s-relative'>
                        <?= $form->field($model, "family_status", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getFamilyStatueList(), ['class' => 'm-select field', 'prompt' => 'Выбрать'])->label($model->getAttributeLabel('family_status')) ?>
                        <span class="fa fa-caret-down"></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class='s-relative'>
                        <?= $form->field($model, "information_on_income", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getInformationOnIncomeList(), ['class' => 'm-select field','prompt' => 'Выбрать'])->label($model->getAttributeLabel('information_on_income')) ?>
                        <span class="fa fa-caret-down"></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'job', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field','placeholder' => 'Например: УП "Зеленоград"'])->label($model->getAttributeLabel('Официальное место работы').' (контракт)') ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'experience', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field','placeholder' => 'Например: 6 месяцев или 1 год'])->label('Стаж на последнем месте работы') ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'salary', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field','placeholder' => 'Например: 300'])->label($model->getAttributeLabel('salary').' (руб.)') ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'loans_payment', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label($model->getAttributeLabel('loans_payment').' (руб.)') ?>
                    </div>
                    <div class="col-xs-12">
                        <label class="control-label" for="creditapplication-product">Выбранное авто</label>
                        <input type="text" class="field" placeholder="Например: Acura CL" name="CreditApplication[product]" value="<?= $model->product ?>"/>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'credit_amount', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label($model->getAttributeLabel('Сумма кредита').' (руб.)') ?>
                    </div>
                    <div class="col-xs-12">
                        <div class='s-relative'>
                        <?= $form->field($model, "term", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getTermList(), ['class' => 'm-select field'])->label($model->getAttributeLabel('term')) ?>
                        <span class="fa fa-caret-down"></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn m-btn" name="contact-button"><?= Yii::t('app', 'Submit') ?>
                                <span class="fa fa-angle-right"></span></button>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="spravka-btn">
                    <a href="/documents/spravka-2018.doc">Справка о доходах</a>
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
                            <h2 class="s-titleDet">КРЕДИТНЫЙ КАЛЬКУЛЯТОР</h2>
                            <div class="b-detail__main-aside-payment-form">
                                <div class="calculator-loan" style="display: none;">
                                    <div class="form">
                                        <div class="accrue-field-amount"><p><label>Loan Amount:</label><input
                                                        type="text" class="amount" value="0"></p></div>
                                        <div class="accrue-field-rate"><p><label>Rate (APR):</label><input type="text"
                                                                                                           class="rate"
                                                                                                           value="14">
                                            </p></div>
                                        <div class="accrue-field-term">
                                            <p><label>Term:</label><input type="text" class="term" value="60m">
                                                <small>Format: 12m, 36m, 3y, 7y</small>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="results"><p class="error">Please fill in all fields.</p></div>
                                </div>
                                <form action="/" method="post" class="js-loan">
                                    <label>Цена автомобиля (руб.)</label>
                                    <input type="text" placeholder="Сумма кредита" value="0" name="price">
                                    <label>Первоначальный взнос (руб.)</label>
                                    <input type="number" placeholder="Первоначальный взнос (руб.)" value="0"
                                           name="prepayment" id="prepayment" min="0">
                                    <label>Ставка в %</label>
                                    <div class="s-relative">
                                        <select name="rate" class="m-select" id="rate">
                                            <option value="14">Приорбанк 14%</option>
                                            <option value="22">ВТБ 22%</option>
                                            <option value="14.5">БТА 14,5%</option>
                                            <option value="16.8">СтатусБанк 16,8%</option>
                                        </select>
                                        <span class="fa fa-caret-down"></span>
                                    </div>
                                    <label>Срок кредита</label>
                                    <div class="s-relative">
                                        <select name="term" class="m-select" id="term">
                                            <option value="6m">6 месяцев</option>
                                            <option value="12m">1 год</option>
                                            <option value="24m">2 года</option>
                                            <option value="36m">3 года</option>
                                            <option value="48m">4 года</option>
                                            <option value="60m" selected="">5 лет</option>
                                        </select>
                                        <span class="fa fa-caret-down"></span>
                                    </div>
                                    <button type="submit" class="btn m-btn">РАССЧИТАТЬ ПЛАТЕЖИ <i
                                                class="fa fa-angle-double-right" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <div class="b-detail__main-aside-about-call js-loan-results">
                                    <div><span class="js-per-month">0</span>
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
</section><!--b-contacts-->