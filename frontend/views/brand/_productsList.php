<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\models\Product;
use common\models\ProductI18n;
use common\models\Specification;
use yii\helpers\StringHelper;
use common\models\User;
/* @var $model Product */

$specs = array_merge($model->getSpecifications(Specification::PRIORITY_HIGH), $model->getSpecifications(Specification::PRIORITY_HIGHEST));
$specs = array_chunk($specs, 2);
if (!isset($specs[0])) {
    $specs[0] = [];
}
if (!isset($specs[1])) {
    $specs[1] = [];
}
if (!isset($specs[2])) {
    $specs[2] = [];
}
?>

<a href="<?= $model->getUrl() ?>" class="b-items__cars-one-img">
    <img src="<?= $model->getTitleImageUrl(267, 180) ?>" alt="<?= Html::encode($model->getFullTitle()) ?>" class="hover-light-img"/>
    <?php if($model->priority == 1): ?>
    <span class="b-items__cars-one-img-type m-premium"></span>
    <?php endif; ?>
    <?php if($model->priority != 1): ?>
    <span class="b-items__cars-one-img-type m-premium"></span>
    <?php endif; ?>
</a>
<div class="b-items__cars-one-info">
    <div class="b-items__cars-one-info-header s-lineDownLeft">
        <h2><a href="<?= $model->getUrl() ?>"><?= Html::encode($model->getFullTitle()) ?></a></h2>
        <?php if($model->exchange): ?>
            <span class="b-items__cars-one-info-title b-items__cell-info-exchange"><?= Yii::t('app', 'Exchange') ?></span>
        <?php endif; ?>
        <?php if($model->auction): ?>
            <span class="b-items__cars-one-info-title b-items__cell-info-auction"><?= Yii::t('app', 'Auction') ?></span>
        <?php endif; ?>
    </div>
    <div class="row s-noRightMargin">
		<div class="col-md-3 col-xs-12">
            <div class="b-items__cars-one-info-price">
                <div class="">
					<div class="b-items__cars-one-info-price-div1">
						<h4><?= Yii::$app->formatter->asDecimal($model->getByrPrice()) ?> BYN</h4>
						<span class="b-items__cell-info-price-usd"><?= Yii::$app->formatter->asDecimal($model->getUsdPrice()) ?> $ </span>
                    </div>
                    <div class="b-items__cars-one-info-price-div2">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-xs-12">
            <div class="m-width row m-smallPadding">
                <div class="col-xs-6">
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
                                <?php foreach ($specs[0] as $productSpec): ?>
                                <tr>
                                    <td>
                                        <?php $spec = $productSpec->getSpecification()->one(); ?>
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
                <?php if (isset($specs[1])): ?>
                <div class="col-xs-6">
                    <div class="row m-smallPadding">
                        <div class="col-xs-12">
                            <table>
                                <?php foreach ($specs[1] as $productSpec): ?>
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
								<?php if (isset($specs[2]) && isset($specs[2][0])): ?>
								<?php $productSpec = $specs[2][0]; ?>
                                <?php $spec = $productSpec->getSpecification()->one(); ?>
                                <tr>
                                    <td>
                                        <span class="b-items__cars-one-info-title"><?= $spec->i18n()->name ?></span>
                                    </td>
                                    <td>
                                        <span class="b-items__cars-one-info-value"><?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?></span>
                                    </td>
                                </tr>
								<?php endif ?>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
        <div class="col-md-12">
            <p class="seller_comment">
            <?= StringHelper::truncate(ProductI18n::findOne(['parent_id'=>$model->id])->seller_comments, 161, '...');//findOne(['parent_id'=>$model->id])->all()); ?>
            </p>
            <span><?= User::getRegions()[$model->region];?></span>
        </div>
    </div>
</div>
