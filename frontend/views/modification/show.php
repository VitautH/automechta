<?php

use common\models\AutoMakes;
use common\models\ImageModifications;
use frontend\assets\AppAsset;

$this->registerJs("require(['controllers/modification/index']);", \yii\web\View::POS_HEAD);
$this->registerJsFile("/js/modernizm.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/owl.carousel.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/owl.lazyload.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/owl.support.modernizr.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/owl.css');
$this->registerCssFile('@web/css/owl-theme.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css');
$this->registerCssFile('@web/theme/css/catalog.css');
$this->registerCssFile('@web/css/modification-index-style.css');
?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><a href="/catalog">Энциклопедия автомобилей<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><a href="/catalog/<?php echo $markSlug; ?>"><?php echo $markName; ?><i
                            class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><a href="/catalog/<?php echo $markSlug; ?>/<?php echo $modelSlug; ?>"><?php echo $modelName; ?><i
                            class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2"><? echo $modificationName; ?></span></li>
        </ul>
    </div>
</div>
<div class="container">
    <div class="logo-row row">
        <div class="col-lg-4">
                                                    <span class="brand-img "
                                                          style="background-image: url('/theme/images/logoAutoMain/<?php echo $logo; ?>');"></span>
            <span class="brand-name"><?php echo $markName . ' ' . $modelName . ' ' . $modificationName; ?></span>

        </div>
    </div>
</div>
<div class="container">
    <?php
    $imagesModel = ImageModifications::find()->where(['modifications_id' => $model->modification_id])->all();
    $imagesCount = ImageModifications::find()->where(['modifications_id' => $model->modification_id])->count();
    if ($imagesCount > 0):
        if ($imagesCount > 6) {
            $desctopCountImage = 6;
        } else {
            $desctopCountImage = $imagesCount;
        }
        $this->registerJs(" 
 $('.carousel-small-" . $model->id . "').owlCarousel({
    loop:false,
    margin:10,
    autoWidth:true,
    touchDrag:true,
    mouseDrag:true,
    dots:true,
     items:" . $imagesCount . ",
    responsive:{
         240:{
                items:1
            },
            360:{
                items:2
            },
              600:{
               items:" . ($desctopCountImage - 2) . "
            },
            900:{
               items:" . $desctopCountImage . "
            }
        }
         });
         
           ", \yii\web\View::POS_END);
        AppAsset::register($this);
        ?>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="carousel-small-<?php echo $model->id; ?> owl-carousel owl-theme">
                    <?php

                    foreach ($imagesModel as $image):
                        ?>
                        <div>
                            <a data-fancybox="gallery" href="<? echo $image->img_url; ?>">
                                <img width="139" height="100" src="<? echo $image->img_url; ?>"/>
                            </a>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
    <div class="catalog-content row">
        <div class="col-md-12">
            <?php echo $model->specification; ?>
        </div>
    </div>
</div>
