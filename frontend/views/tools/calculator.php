<?php
use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Page */
/* @var $provider yii\data\ActiveDataProvider */

\Yii::$app->view->registerMetaTag([
    'name' => 'robots',
    'content' => 'noindex, nofollow'
]);

$this->registerJs("require(['controllers/tools/calculator']);", \yii\web\View::POS_HEAD);

$appData = AppData::getData();
$this->title = 'Кредитный калькулятор';
?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1><?= $this->title ?></h1>
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
</div><!--b-breadCumbs-->

<section class="b-article">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12 col-md-offset-2 col-xs-offset-0">
                        <div class="row m-noBlockPadding">
                                <div class="b-detail__main">
                                    <div class="right_block" style="position: relative;
    width: 400px;
    top: 40px;
    left: 30%;">
                                <div class="b-detail__main-aside-payment wow zoomInUp" data-wow-delay="0.5s">
                                    <h2 class="s-titleDet"><?= Yii::t('app', 'CAR PAYMENT CALCULATOR') ?></h2>
                                    <div class="b-detail__main-aside-payment-form">
                                        <div class="calculator-loan" style="display: none;"></div>
                                        <form action="/" method="post" class="js-loan">
                                            <label><?= Yii::t('app', 'ENTER LOAN AMOUNT') ?></label>
                                            <input type="text" placeholder="<?= Yii::t('app', 'LOAN AMOUNT') ?>"
                                                   value="<?= $product->price_byn ?>" name="price"/>
                                            <label><?= Yii::t('app', 'Prepayment') ?></label>
                                            <input type="number" placeholder="<?= Yii::t('app', 'Prepayment') ?>"
                                                   value="0" name="prepayment" id="prepayment" min="0"
                                                   max="<?= $product->price_byn ?>"/>
                                            <label><?= Yii::t('app', 'RATE IN') ?> %</label>
                                            <div class="s-relative">
                                                <select name="rate" class="m-select" id="rate">
                                                    <option value="<?= $appData['prior_bank']?>">Приорбанк <?= $appData['prior_bank']?>%</option>
                                                    <option value="<?= $appData['vtb_bank']?>">ВТБ <?= $appData['vtb_bank']?>%</option>
                                                    <option value="<?= $appData['bta_bank']?>">БТА <?= $appData['bta_bank']?>%</option>
                                                    <option value="<?= $appData['idea_bank']?>">ИдеяБанк <?= $appData['idea_bank']?>%</option>
                                                    <option value="<?= $appData['status_bank']?>">СтатусБанк <?= $appData['status_bank']?>%</option>
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
</section><!--b-article-->
