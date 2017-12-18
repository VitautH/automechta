<?php
use yii\helpers\Html;
use common\models\Product;
use common\models\Specification;
use common\helpers\Url;
/* @var $model Product */

$specs = array_merge($model->getSpecifications(Specification::PRIORITY_HIGH), $model->getSpecifications(Specification::PRIORITY_HIGHEST));
$specs = array_slice($specs, 0, 5);
?>
<div class="b-items__cell">
    <a href="<?= Url::UrlShowProduct($model->id) ?>" class="b-items__cars-one-img">
        <img class='img-responsive hover-light-img' src="<?= $model->getTitleImageUrl(237, 160) ?>" alt="<?= Html::encode($model->i18n()->title) ?>"/>
        <?php if($model->priority == 1): ?>
        <span class="b-items__cars-one-img-type m-premium"></span>
        <?php endif; ?>
        <?php if($model->priority != 1): ?>
        <span class="b-items__cars-one-img-type m-premium"></span>
        <?php endif; ?>
    </a>
    <div class="b-items__cell-info">
        <div class="s-lineDownLeft b-items__cell-info-title">
            <h2 class=""><a href="<?= Url::UrlShowProduct($model->id) ?>"><?= Html::encode($model->getFullTitle()) ?></a></h2>
        </div>
        <div>
            <div class="row m-smallPadding">
                <div class="col-xs-12">
                    <table>
                        <tr>
                            <td>
                                <span class="b-items__cars-one-info-title"><?= Yii::t('app', 'Year') ?></span>
                            </td>
                            <td>
                                <span class="b-items__cars-one-info-value"><?= $model->year ?></span>
                            </td>
                        </tr>
                        <?php foreach ($specs as $productSpec): ?>
                        <?php $spec = $productSpec->getSpecification()->one(); ?>
                        <tr>
                            <td>
                                <span class="b-items__cars-one-info-title"><?= $spec->i18n()->name ?></span>
                            </td>
                            <td>
                                <span class="b-items__cars-one-info-value"><?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <div class="b-items__cell-info-exchange-auction">
                <?php if($model->exchange): ?>
                    <span class="b-items__cars-one-info-title b-items__cell-info-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                <?php endif; ?>
                <?php if($model->auction): ?>
                    <span class="b-items__cars-one-info-title b-items__cell-info-auction"><?= Yii::t('app', 'Auction') ?></span>
                <?php endif; ?>
            </div>
            <h5 class="b-items__cell-info-price"><span><?= Yii::t('app', 'Price') ?>:</span><?= Yii::$app->formatter->asDecimal($model->getByrPrice()) ?> BYN</h5>
            <p class="b-items__cell-info-price-usd"><?= Yii::$app->formatter->asDecimal($model->getUsdPrice()) ?></p>
        </div>
        <!--<a href="<?= Url::UrlShowProduct($model->id) ?>" class="btn m-btn"><?=Yii::t('app', 'VIEW DETAILS') ?><span class="fa fa-angle-right"></span></a>-->
    </div>
</div>