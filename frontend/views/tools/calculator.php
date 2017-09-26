<?php
use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Page */
/* @var $provider yii\data\ActiveDataProvider */

$this->registerJs("require(['controllers/tools/calculator']);", \yii\web\View::POS_HEAD);

$appData = AppData::getData();
$this->title = 'Кредитный калькулятор';
?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= $this->title ?></h1>
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
            <div class="col-md-8 col-xs-12 col-md-offset-2">
                <div class="b-article__main">
                    <div class="b-blog__posts-one">
                        <div class="row m-noBlockPadding">
                            <div class="col-sm-11 col-xs-12">
                                <div class="b-detail__main-aside payment-calculator-page">
                                    <div class="b-detail__main-aside-about wow zoomInUp" data-wow-delay="0.5s">
                                        <div class="b-detail__main-aside-payment wow zoomInUp" data-wow-delay="0.5s">
                                            <div class="b-detail__main-aside-payment-form">
                                                <div class="calculator-loan" style="display: none;"> </div>
                                                <form action="/" method="post" class="js-loan">
                                                    <label><?= Yii::t('app', 'LOAN AMOUNT') ?> $</label>
                                                    <input type="text" placeholder="<?= Yii::t('app', 'LOAN AMOUNT') ?>" value="1000" name="price" />
                                                    <label><?= Yii::t('app', 'RATE IN') ?> %</label>
                                                    <input type="text" placeholder="<?= Yii::t('app', 'RATE IN') ?> %" value="<?= $appData['loanRate'] ?>%" name="rate" />
                                                    <label><?= Yii::t('app', 'LOAN TERM') ?></label>
                                                    <div class="s-relative">
                                                        <select name="term" class="m-select">
                                                            <option value="6m"><?= Yii::t('app', '6 month') ?></option>
                                                            <option value="12m"><?= Yii::t('app', 'One year') ?></option>
                                                            <option value="24m"><?= Yii::t('app', '2 years') ?></option>
                                                            <option value="36m"><?= Yii::t('app', '3 years') ?></option>
                                                            <option value="48m" selected><?= Yii::t('app', '4 years') ?></option>
                                                        </select>
                                                        <span class="fa fa-caret-down"></span>
                                                    </div>
                                                    <button type="submit" class="btn m-btn"><?= Yii::t('app', 'ESTIMATE PAYMENT') ?><span class="fa fa-angle-right"></span></button>
                                                </form>
                                            </div>
                                            <div class="b-detail__main-aside-about-call js-loan-results">
                                                <span class="fa fa-calculator"></span>
                                                <div>$ <span class="js-per-month"></span> <p><?= Yii::t('app', 'PER MONTH') ?></p></div>
                                                <p>&nbsp;</p>
                                                <p style="display: none;"><?= Yii::t('app', 'Total Payments') ?>: <span class="js-total-payments"></span></p>
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
    </div>
</section><!--b-article-->
