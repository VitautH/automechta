<?php

use common\models\AutoMakes;
use common\models\AutoModification;
use common\models\AutoBody;
use common\helpers\Url;
use common\models\ImageModifications;
use frontend\assets\AppAsset;
use common\models\AutoSearch;

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
            <li><span class="no-link ml-lg-2"><?php echo $modelName; ?></span></li>
        </ul>
    </div>
</div>
<div class="container">
    <div class="logo-row row">
        <div class="col-lg-3">
                                                    <span class="brand-img "
                                                          style="background-image: url('/theme/images/logoAutoMain/<?php echo $logo; ?>');"></span>
            <span class="brand-name"><?php echo $markName . ' ' . $modelName; ?></span>

        </div>
    </div>
</div>

<div class="container">
    <div class="models">
        <div class="col-lg-12">
            <div class="cars-modification-list">
                <?php
                foreach ($models

                as $model):
                if (!empty($model->modification_name) || !empty($model->years)) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2> <?php echo $model->modification_name; ?>
                            <?php echo $model->years; ?>
                        </h2>
                    </div>
                </div>
                <?php
                $imagesModel = ImageModifications::find()->where(['modifications_id' => $model->id])->all();
                $imagesCount = ImageModifications::find()->where(['modifications_id' => $model->id])->count();
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
                <div class="row">

                    <?php

                    foreach ($imagesModel as $i => $image):
                        if ($i == 0):
                            ?>
                            <div class="col-lg-7">
                                <a data-fancybox="gallery" href="<? echo $image->img_url; ?>">
                                    <img width="100%" height="100" src="<? echo $image->img_url; ?>"/>
                                </a>
                            </div>
                            <div class="col-lg-4">
                            <div class="row">
                        <?php
                        endif;
                        ?>
                        <?php
                        if (($i > 0) && ($i < 7)):
                            ?>

                            <div class="col-lg-2">
                                <a data-fancybox="gallery" href="<? echo $image->img_url; ?>">
                                    <img width="139" height="100" src="<? echo $image->img_url; ?>"/>
                                </a>
                            </div>
                        <?php
                        endif;
                        ?>
                        </div>
                        </div>
                    <?php


                    endforeach;
                    ?>
                </div>
            </div>
            <?php
            endif;
            ?>

            <div class="more" id="<?php echo $model->id; ?>"
                 data-url="/modification/load-modification?id=<?php echo $model->id; ?>">Показать <?php
                echo AutoSearch::getCountModifications($model->id);
                ?>
                модификаций
            </div>

            <?php
            } else {
            ?>
            <?php
            $imagesModel = ImageModifications::find()->where(['modifications_id' => $model->id])->all();
            $imagesCount = ImageModifications::find()->where(['modifications_id' => $model->id])->count();
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
            <div class="row">

                <?php

                foreach ($imagesModel

                as $i => $image):
                if ($i == 0):
                    ?>
                    <div class="col-lg-7">
                        <a data-fancybox="gallery" href="<? echo $image->img_url; ?>">
                            <img width="100%" height="350" src="<? echo $image->img_url; ?>"/>
                        </a>
                    </div>

                <?php
                endif;
                ?>
                <?php
                if (($i > 0) && ($i < 7)):
                if ($i == 1):
                ?>
                <div class="col-lg-4">
                    <div class="row">
                        <?php
                        endif;
                        ?>
                        <div class="col-lg-2">
                            <a data-fancybox="gallery" href="<? echo $image->img_url; ?>">
                                <img width="139" height="100" src="<? echo $image->img_url; ?>"/>
                            </a>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php


        endforeach;
        ?>
    </div>
    <?php
    endif;
    ?>
    <div class="table-responsive">
        <table class="sublist table">
            <thead>
            <tr>
                <td>Модификация</td>
                <td>Год выпуска:</td>
                <td>Двигатель</td>
                <td>Привод</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $modifications = AutoModification::find()->where(['modification_id' => $model->id])->all();
            foreach ($modifications as $modification):
                ?>
                <tr>
                    <td><a href="<?php echo Url::current(); ?>/<?php echo $modification->id; ?>">
                            <?php echo $modification->modification_name; ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $modification->years; ?>
                    </td>
                    <td>
                        <?php echo $modification->engine; ?>
                    </td>
                    <td>
                        <?php echo $modification->drive_unit; ?>
                    </td>
                </tr>

            <?php
            endforeach;
            ?>
            </tbody>
        </table>
    </div>
    <?php
    }
    ?>
    <?php
    endforeach;
    ?>
</div>
</div>
</div>
</div>