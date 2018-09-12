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
use frontend\assets\AppAsset;

$appData = AppData::getData();
$this->title = Yii::t('app', 'Credit application');
$this->registerMetaTag([
    'name' => 'robots',
    'content' => 'noindex, nofollow'
]);
$this->registerJs("require(['controllers/tools/creditApplication']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/tools/creditApplication']);", \yii\web\View::POS_HEAD);
$this->registerCssFile('@web/css/credit-app-style.css');
$this->registerCssFile('@web/css/style.css');
AppAsset::register($this);
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
$model->term = '60m';
$model->loans_payment = '0';

?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная <i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Заявка на кредит</span></li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Онлайн заявка на кредит</h3>
            </div>
        </div>
    </div>
</div>
<!--b-breadCumbs-->
<section class="credit_applecation b-contacts s-shadow">
    <div class="container">
        <div class="credit row">
            <div class="col-12">
                <?= Alert::widget() ?>
            </div>
            <div class="col-lg-9 col-12">
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
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php echo $model->getAttributeLabel('firstname');?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'firstname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false);?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php echo $model->getAttributeLabel('name');?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'name', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php echo $model->getAttributeLabel('lastname');?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'lastname', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php echo $model->getAttributeLabel('phone');?> <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'phone', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field required_field', 'required'=>true])->label(false ) ?>
                    </div>
                    </div>
                        <div class="form-field row">
                            <div class="col-lg-3">
                                <label class="control-label">
                                    <?php
                                    echo $model->getAttributeLabel('dob');
                                    ?>
                                </label>
                            </div>
                            <div class="col-lg-5">
                        <?= $form->field($model, 'dob', ['options' => ['class' => 'b-submit__main-element']])->input('text', ['class'=>'field'])->label(false) ?>
                    </div>
                        </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('sex');
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, "sex", ['options' => ['class' => 'b-submit__main-element']])
                            ->dropDownList(CreditApplication::getSexList(), ['class' => 'm-select field','prompt' => 'Выбрать'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('previous_conviction');
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, "previous_conviction", ['options' => ['class' => 'b-submit__main-element']])
                            ->dropDownList(CreditApplication::getConvictionList(), ['class' => 'm-select field','prompt' => 'Выбрать'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('family_status');
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, "family_status", ['options' => ['class' => 'b-submit__main-element wow zoomInUp']])
                            ->dropDownList(CreditApplication::getFamilyStatueList(), ['class' => 'm-select field', 'prompt' => 'Выбрать'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('information_on_income');
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, "information_on_income", ['options' => ['class' => 'b-submit__main-element wow zoomInUp']])
                            ->dropDownList(CreditApplication::getInformationOnIncomeList(), ['class' => 'm-select field','prompt' => 'Выбрать'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('Официальное место работы').' (контракт)';
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'job', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field','placeholder' => 'Например: УП "Зеленоград"'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                Стаж на последнем месте работы
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'experience', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field','placeholder' => 'Например: 6 месяцев или 1 год'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('salary').' (руб.)';
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'salary', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field','placeholder' => 'Например: 300'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('loans_payment').' (руб.)';
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'loans_payment', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                                <label class="control-label" for="creditapplication-product">Выбранное авто</label>
                        </div>
                        <div class="col-lg-5">
                        <input type="text" class="field" placeholder="Например: Acura CL" name="CreditApplication[product]" value="<?= $model->product ?>"/>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('Сумма кредита').' (руб.)';
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, 'credit_amount', ['options' => ['class' => 'b-submit__main-element']])->textInput(['class' => 'field'])->label(false) ?>
                    </div>
                    </div>
                    <div class="form-field row">
                        <div class="col-lg-3">
                            <label class="control-label">
                                <?php
                                echo $model->getAttributeLabel('term');
                                ?>
                            </label>
                        </div>
                        <div class="col-lg-5">
                        <?= $form->field($model, "term", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                            ->dropDownList(CreditApplication::getTermList(), ['class' => 'm-select field'])->label(false) ?>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="custom-button" name="contact-button"><?= Yii::t('app', 'Submit') ?>
                                <i class="ml-2 fas fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
                </div>
            <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-3 col-12">
                <div class="b-detail__main-aside-payment">
                    <h3 class="s-titleDet">Кредитный калькулятор</h3>
                    <div class="b-detail__main-aside-payment-form">
                        <div class="calculator-loan" style="display: none;"><div class="form"><div class="accrue-field-amount"><p><label>Loan Amount:</label><input type="text" class="amount" value="0"></p></div><div class="accrue-field-rate"><p><label>Rate (APR):</label><input type="text" class="rate" value="15.5"></p></div><div class="accrue-field-term"><p><label>Term:</label><input type="text" class="term" value="60m"><small>Format: 12m, 36m, 3y, 7y</small></p></div></div><div class="results"><p class="error">Please fill in all fields.</p></div></div>
                        <form action="/" method="post" class="js-loan">
                            <div class="form-block">
                                <label>Цена, BYN</label>
                                <input type="text" placeholder="Сумма кредита" value="0" name="price">
                            </div>
                            <div class="form-block">
                                <label>Первоначальный взнос, BYN</label>
                                <input type="number" placeholder="Первоначальный взнос (руб.)" value="0" name="prepayment" id="prepayment" min="0">
                            </div>
                            <div class="form-block">
                                <label>Ставка в, %</label>
                                <div class="m-select">
                                    <select name="rate" class="" id="rate">
                                        <option value="15.5">Приорбанк 15.5%</option>
                                        <option value="19.9">ВТБ 19.9%</option>
                                        <option value="16">БТА 16%</option>
                                        <option value="16">СтатусБанк 16%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-block">
                                <label>Срок кредита</label>
                                <div class="m-select">
                                    <select name="term" id="term">
                                        <option value="6m">6 месяцев</option>
                                        <option value="12m">1 год</option>
                                        <option value="24m">2 года</option>
                                        <option value="36m">3 года</option>
                                        <option value="48m">4 года</option>
                                        <option value="60m" selected="">5 лет</option>
                                    </select>
                                </div>
                            </div>
                            <div class="b-detail__main-aside-about-call js-loan-results">
                                <p><b><span class="js-per-month">0 </span>
                                        BYN</b> / месяц
                                </p>
                            </div>
                            <button type="submit" class="custom-button">Рассчитать платежи
                                <i class="fas fa-angle-right" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <a href="/documents/spravka-2018.doc" class="download-income hidden-mobile"><i class="fas fa-download mr-2"></i>Справка о доходах</a>
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
                    <div class="contact-block">
                    <span class="email">automechta.by@gmail.com</span>
                    <p>
                        Ежедневно с 10:00 до 18:00
                        <br>
                        г. Минск, ул. Суражская, 8А
                        <br>
                        ст. метро Институт Культуры
                    </p>
                </div>
                </div>
                <div class="b-detail__main">
                    <div class="right_block">
                        <div class="b-detail__main-aside-payment" style="display: none;">
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
                                        <select name="rate" class="m-select" id="rate">
                                            <option value="<?= $appData['prior_bank']?>">Приорбанк <?= $appData['prior_bank']?>%</option>
                                            <option value="<?= $appData['vtb_bank']?>">ВТБ <?= $appData['vtb_bank']?>%</option>
                                            <option value="<?= $appData['bta_bank']?>">БТА <?= $appData['bta_bank']?>%</option>
                                            <option value="<?= $appData['status_bank']?>">СтатусБанк <?= $appData['status_bank']?>%</option>
                                        </select>
                                    <label>Срок кредита</label>
                                        <select name="term" class="m-select" id="term">
                                            <option value="6m">6 месяцев</option>
                                            <option value="12m">1 год</option>
                                            <option value="24m">2 года</option>
                                            <option value="36m">3 года</option>
                                            <option value="48m">4 года</option>
                                            <option value="60m" selected="">5 лет</option>
                                        </select>
                                    <button type="submit" class="btn m-btn">РАССЧИТАТЬ ПЛАТЕЖИ <i
                                                class="fas fa-angle-double-right" aria-hidden="true"></i>
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