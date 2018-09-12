<?php

use yii\helpers\Html;
use  common\helpers\Url;
use yii\helpers\StringHelper;
use common\models\ProductMake;
use common\models\Specification;

switch ($type) {
    case 'CompanyCars':
        $urlTo = '/cars/company';
        break;
    case 'PrivateCars':
        $urlTo = '/cars';
        break;
    case 'Motos':
        $urlTo = '/moto';
        break;
    case 'Boat':
        $urlTo = '/boat';
        break;
}

?>
<div class="carousel slide hidden-mobile" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
        <div id="carousel-<?php echo $type; ?>" class="row carousel-row">
            <?php foreach ($carousels as $carousel):
                if (($type != 'Boat') || ($type != 'Motos')) {
                    /*
                    * Specification
                    */
                    $productSpecifications = $carousel->getSpecifications();
                    $productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
                        $specification = $productSpec->getSpecification()->one();
                        return $specification->type != Specification::TYPE_BOOLEAN;
                    });
                    $productSpecificationsMain = array_values($productSpecificationsMain);
                    $productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
                        $specification = $productSpec->getSpecification()->one();
                        return $specification->type == Specification::TYPE_BOOLEAN;
                    });
                    $productSpecificationsAdditional = array_values($productSpecificationsAdditional);
                    foreach ($productSpecificationsAdditional as $key => $productSpecification) {
                        $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
                    }

                    /*
                    * Main Specification
                    */
                    $carouselSpec = [];
                    foreach ($productSpecificationsMain as $i => $productSpec) {
                        $spec = $productSpec->getSpecification()->one();
                        $carouselSpec [$i] ['name'] = $spec->i18n()->name;
                        $carouselSpec [$i] ['format'] = $productSpec->getFormattedValue();
                        $carouselSpec [$i] ['unit'] = $spec->i18n()->unit;
                    }
                }

                if ($type == 'Boat') {
                    $url = Url::UrlShowProductBoat($carousel->id);
                    $makeName = ProductMake::findOne($carousel->make)->name;
                    $title = $makeName . ' ' . $carousel->year . ' г.в.';
                } else {
                    $url = Url::UrlShowProduct($carousel->id);
                    $title = $carousel->getFullTitle();
                }
                if ($type == 'CompanyCars') {
                    $image = $carousel->getFullImage();

                } else {
                    $image = $carousel->getTitleImageUrl(768, 453);
                }
                ?>
                <div class="carousel-item">
                    <div class="carousel-image">
                        <a href="<?= $url; ?>">
                            <img src="<?php echo $image; ?>"
                                 alt="<?= Html::encode($title) ?>">
                        </a>
                    </div>
                    <div class="car-description">
                        <h5><a href="<?= $url; ?>"><?= $title ?></a>
                        </h5>
                        <?php
                        if (($type !== 'Boat') || ($type !== 'Motos')) :
                            ?>
                            <span class="specifications">
                                                 <?php echo $carouselSpec[2]['format']; ?> см<sup>3</sup>,
                                <?php echo $carouselSpec[4]['format']; ?>,
                                <?php echo $carouselSpec[6]['format']; ?>,
                                <?php echo $carouselSpec[1]['format']; ?>
                                            </span>
                        <?php
                        endif
                        ?>
                        <p><?= StringHelper::truncate($carousel->i18n()->seller_comments, 60, '...'); ?></p>
                        <span class="price-rb"><?= Yii::$app->formatter->asDecimal($carousel->getByrPrice()) ?>
                            BYN</span><span
                                class="price-dol"><?= Yii::$app->formatter->asDecimal($carousel->getUsdPrice()) ?>
                            $</span>
                    </div>
                </div>
            <?
            endforeach;
            ?>

        </div>
    </div>
</div>
<div class="<?php if ($type == 'CompanyCars') {
    echo 'carousel-CompanyCars';
}; ?> carousel  hidden-desktop">
    <div class="carousel-inner">
        <div class="row carousel-row">
            <?php foreach ($carousels as $carousel):
                if (($type != 'Boat') || ($type != 'Motos')) {
                    /*
                    * Specification
                    */
                    $productSpecifications = $carousel->getSpecifications();
                    $productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
                        $specification = $productSpec->getSpecification()->one();
                        return $specification->type != Specification::TYPE_BOOLEAN;
                    });
                    $productSpecificationsMain = array_values($productSpecificationsMain);
                    $productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
                        $specification = $productSpec->getSpecification()->one();
                        return $specification->type == Specification::TYPE_BOOLEAN;
                    });
                    $productSpecificationsAdditional = array_values($productSpecificationsAdditional);
                    foreach ($productSpecificationsAdditional as $key => $productSpecification) {
                        $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
                    }

                    /*
                    * Main Specification
                    */
                    $carouselSpec = [];
                    foreach ($productSpecificationsMain as $i => $productSpec) {
                        $spec = $productSpec->getSpecification()->one();
                        $carouselSpec [$i] ['name'] = $spec->i18n()->name;
                        $carouselSpec [$i] ['format'] = $productSpec->getFormattedValue();
                        $carouselSpec [$i] ['unit'] = $spec->i18n()->unit;
                    }
                }

                if ($type == 'Boat') {
                    $url = Url::UrlShowProductBoat($carousel->id);
                    $makeName = ProductMake::findOne($carousel->make)->name;
                    $title = $makeName . ' ' . $carousel->year . ' г.в.';
                } else {
                    $url = Url::UrlShowProduct($carousel->id);
                    $title = $carousel->getFullTitle();
                }

                if ($type == 'CompanyCars') {
                    $image = $carousel->getFullImage();

                } else {
                    $image = $carousel->getTitleImageUrl(768, 453);
                }
                ?>
                <div class="carousel-item">
                    <div class="carousel-image">
                        <a href="<?= $url; ?>">
                            <img src="<?php echo $image; ?>" alt="<?= $title; ?>">
                        </a>
                    </div>
                    <div class="car-description">
                        <h5><a href="<?= $url; ?>"><?= $title; ?></a>
                        </h5>

                        <?php if (($type !== 'Boat') || ($type !== 'Motos')):
                            ?>
                            <span class="specifications">
                            <?php echo $carouselSpec[2]['format']; ?> см<sup>3</sup>,
                                <?php echo $carouselSpec[4]['format']; ?>,
                                <?php echo $carouselSpec[6]['format']; ?>,
                                <?php echo $carouselSpec[1]['format']; ?>
                                            </span>
                        <?php
                        endif;
                        ?>
                        <p><?= StringHelper::truncate($carousel->i18n()->seller_comments, 60, '...'); ?></p>
                        <span class="price-rb"><?= Yii::$app->formatter->asDecimal($carousel->getByrPrice()) ?>
                            BYN</span><span
                                class="price-dol"><?= Yii::$app->formatter->asDecimal($carousel->getUsdPrice()) ?>
                            $</span>
                    </div>
                </div>
            <?
            endforeach;
            ?>
        </div>
    </div>
</div>
<div class="row justify-content-center mt-3">
    <div class="col-12 col-lg-3">
        <a href="<?= Url::to([$urlTo]); ?>" class="show-more">Показать больше <i
                    class="fas fa-chevron-right ml-2"></i></a>
    </div>
</div>