<?php
use yii\helpers\Html;
use common\models\ProductMake;
use common\models\Product;
use common\models\Specification;

$this->registerJs("require(['controllers/site/productList']);", \yii\web\View::POS_HEAD);

$topMakers = ProductMake::find()->top(1)->limit(8)->all();
if (!isset($currentMaker)) {
    $currentMaker = $topMakers[0];
}
?>

<section class="b-auto">
    <div class="container js-productlist">
        <h2 class="s-title wow zoomInRight" data-wow-delay="0.3s" data-wow-offset="100"><?= Yii::t('app', 'BEST OFFERS') ?></h2>
        <div class="row">
            <div class="col-xs-5 col-sm-4 col-md-3">
                <aside class="b-auto__main-nav wow zoomInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                    <ul>
                        <?php foreach($topMakers as $key => $topMaker): ?>
                            <li <?php if($key === 0):?>class="active"<?php endif;?> >
                                <a href="#" data-make-id="<?= $topMaker->id ?>" class="js-select-maker"><?= $topMaker->name ?><span class="fa fa-angle-right"></span></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </aside>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-7">
                <div class="b-auto__main">
                    <div class="col-md-11 col-md-offset-1 col-xs-12">
                        <a href="#" class="b-auto__main-toggle s-lineDownCenter m-active j-tab wow zoomInLeft" data-wow-delay="0.3s" data-wow-offset="100" data-to="#first"><?= Yii::t('app', 'BEST ADVERTISEMENTS') ?></a>
                        <a href="#" class="b-auto__main-toggle j-tab wow zoomInRight" data-wow-delay="0.3s" data-wow-offset="100" data-to="#second"><?= Yii::t('app', 'BEST OFFERS FROM AUTOCLUB') ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row m-margin js-productlist-first" id="first">
                        <?php
                        $products = Product::find()->active()->lowPriority()->limit(6)->andWhere('make=:make', [':make'=>$currentMaker->id])->all();
                        ?>
                        <?php foreach($products as $product): ?>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="b-auto__main-item" data-wow-delay="0.3s" data-wow-offset="100">
                                    <a href="<?= $product->getUrl() ?>">
                                        <img class="hover-light-img img-responsive" src="<?= $product->getTitleImageUrl(186, 113) ?>" alt="<?= Html::encode($product->getFullTitle()) ?>" />
                                    </a>

                                    <h2><a href="<?= $product->getUrl() ?>"><?= Html::encode($product->getFullTitle()) ?></a></h2>
                                    <div class="b-auto__main-item-info">
                                        <span class="m-price">
                                            <?= Yii::$app->formatter->asDecimal($product->getByrPrice()) ?> BYN
                                        </span>
                                        <?php foreach($product->getSpecifications(Specification::PRIORITY_HIGHEST) as $productSpec): ?>
                                            <?php $spec = $productSpec->getSpecification()->one(); ?>
                                            <span class="m-number">
                                            <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>" />
                                                <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="b-featured__item-links m-auto">
                                        <?php foreach($product->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                            <?php $spec = $productSpec->getSpecification()->one(); ?>
                                            <a href="#" title="<?= $spec->i18n()->name ?>"><?= Html::encode($productSpec->value) ?> <?= $spec->i18n()->unit ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row m-margin js-productlist-second" id="second">
                        <?php
                            $products = Product::find()->active()->highPriority()->limit(6)->andWhere('make=:make', [':make'=>$currentMaker->id])->all();
                        ?>
                        <?php foreach($products as $product): ?>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="b-auto__main-item wow slideInUp" data-wow-delay="0.3s" data-wow-offset="100">
                                    <a style="display: block;" href="<?= $product->getUrl() ?>">
                                        <img class="hover-light-img img-responsive" src="<?= $product->getTitleImageUrl(270, 175) ?>" alt="<?= Html::encode($product->getFullTitle()) ?>" />
                                    </a>
                                    <h2><a href="<?= $product->getUrl() ?>"><?= Html::encode($product->getFullTitle()) ?></a></h2>
                                    <div class="b-auto__main-item-info">
                                        <span class="m-price">
                                            <?= Yii::$app->formatter->asDecimal($product->getByrPrice()) ?> BYN
                                        </span>
                                        <?php foreach($product->getSpecifications(Specification::PRIORITY_HIGHEST) as $productSpec): ?>
                                        <?php $spec = $productSpec->getSpecification()->one(); ?>
                                        <span class="m-number">
                                            <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>" />
                                            <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="b-featured__item-links m-auto">
                                        <?php foreach($product->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                            <?php $spec = $productSpec->getSpecification()->one(); ?>
                                            <a href="#" title="<?= $spec->i18n()->name ?>"><?= Html::encode($productSpec->value) ?> <?= $spec->i18n()->unit ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!--b-auto-->
