<?php

use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

$this->registerJs("require(['controllers/tools/calculator']);", \yii\web\View::POS_HEAD);

$appData = AppData::getData();
?>
<div class="d-flex justify-content-center b-detail__main-aside-payment">
    <div class="col-sm-12 col-md-5 inner">
    <h2 class="s-titleDet">Кредитный калькулятор</h2>
    <div class="b-detail__main-aside-payment-form">
        <div class="calculator-loan" style="display: none;"></div>
        <form action="/" method="post" class="js-loan">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Цена, BYN</label>
                    <input class="form-control" type="text" placeholder="5000"
                           value="<?= $product->price_byn ?>" name="price"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Первоначальный взнос, BYN</label>
                    <input class="form-control" type="number" placeholder="0"
                           value="0" name="prepayment" id="prepayment" min="0"
                           max="<?= $product->price_byn ?>"/>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Ставка в %</label>
                <select class="form-control" name="rate"  id="rate">
                    <option value="<?= $appData['prior_bank']?>">Приорбанк <?= $appData['prior_bank']?>%</option>
                    <option value="<?= $appData['vtb_bank']?>">ВТБ <?= $appData['vtb_bank']?>%</option>
                    <option value="<?= $appData['bta_bank']?>">БТА <?= $appData['bta_bank']?>%</option>
                    <option value="<?= $appData['idea_bank']?>">ИдеяБанк <?= $appData['idea_bank']?>%</option>
                    <option value="<?= $appData['status_bank']?>">СтатусБанк <?= $appData['status_bank']?>%</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress2">Срок кредита</label>
                <select name="term" class="form-control" id="term">
                    <option value="6m"><?= Yii::t('app', '6 month') ?></option>
                    <option value="12m"><?= Yii::t('app', 'One year') ?></option>
                    <option value="24m"><?= Yii::t('app', '2 years') ?></option>
                    <option value="36m"><?= Yii::t('app', '3 years') ?></option>
                    <option value="48m"><?= Yii::t('app', '4 years') ?></option>
                    <option value="60m"
                            selected><?= Yii::t('app', '5 years') ?></option>
                </select>
            </div>
            </div>
            <button class="custom-button" type="submit"><?= Yii::t('app', 'ESTIMATE PAYMENT') ?>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </button>
            <div class="form-row">
            <div class="d-flex justify-content-center row js-loan-results">
            <span class="js-per-month"> </span>
                    <p> BYN в месяц</p>
            </div>
            </div>
        </form>
    </div>
</div>
</div>