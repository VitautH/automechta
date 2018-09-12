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
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
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
        <div class="col-12 pl-0">
            <div class="cars-modification-list">
                <?php
                foreach ($models as $model):
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
                        $remainder = null;
                       if ($imagesCount >5){
                           $remainder = ($imagesCount - 5 );
                       }
                        $this->registerJs(" 
                               $('a[rel=group".$model->id."]').fancybox();", \yii\web\View::POS_END);
                            ?>
                        <div class="row mt-3">
                            <?php
                            foreach ($imagesModel as $i=>$image):

                            if ($i ==0):
                            ?>
                            <div class="col-lg-7 col-12">
                                <a data-fancybox="gallery" id="main-fullimage-gallery<?php echo $model->id;?>" rel="group<?php echo $model->id;?>" title="" href="<? echo $image->img_url; ?>">
                                    <div class="main-image" id="main-image-gallery<?php echo $model->id;?>" style="background-image: url('<? echo $image->img_url; ?>');">
                                          <span class="fullscreen">
                                                    <i class="fas fa-arrows-alt"></i>
                                                </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 ml-lg-1 col-12  ml-0 mt-lg-0 mt-3">
                                <div class="row">
                                    <?php
                                    endif;
                                    if (($i > 0) && ($i <=4)):
                                        ?>
                                        <?php
                                        $hiddenMobile= null;
                                        if ($i ==4){
                                            $hiddenMobile = 'hidden-mobile';
                                        }
                                        ?>

                                        <div class="col-lg-6 col-4 <?php echo $hiddenMobile;?>">
                                            <div data-groupgallery="gallery<?php echo $model->id;?>" data-image="<? echo $image->img_url; ?>" class="thumb-image" style="background-image: url('<? echo $image->img_url; ?>');">
                                                <?php
                                                if (($i ==4) && ($remainder !==null)):
                                                    ?>
                                                    <span class="more_photo hidden-mobile">
                                        </span>
                                                    <span class="count-balance-photo">  + <?php echo $remainder;?> фото </span>

                                                <?php
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    <?php

                                    endif;
                                    ?>

                                    <?php
                                    //  if ($i > 0):

                                    ?>
                                    <a data-fancybox="gallery" rel="group<?php echo $model->id;?>" title="" href="<? echo $image->img_url; ?>" style="display:none;"></a>
                                    <?php
                                    // endif;
                                    ?>
                                    <?php

                                    endforeach;
                                    ?>
                                </div>
                            </div>

                        </div>


                    <?php
                        endif;
                        ?>

                    <div id="block-<?php echo $model->id; ?>" class="row justify-content-center mt-1 mb-4">
                        <div class="col-12 col-lg-3">
                            <a href="#" id="<?php echo $model->id; ?>"
                               data-url="/modification/load-modification?id=<?php echo $model->id; ?>" class="more custom-button red-button">Показать <?php
                                echo AutoSearch::getCountModifications($model->id);
                                ?>
                                модификаций </a>
                        </div>
                    </div>

                        <?php
                    } else {
                        ?>
                        <?php
                        $imagesModel = ImageModifications::find()->where(['modifications_id' => $model->id])->all();
                        $imagesCount = ImageModifications::find()->where(['modifications_id' => $model->id])->count();
                        if ($imagesCount > 0):
                            $remainder = null;
                            if ($imagesCount >5){
                                $remainder = ($imagesCount - 5 );
                            }
                            $this->registerJs(" 
                               $('a[rel=group".$model->id."]').fancybox();", \yii\web\View::POS_END);
                            ?>
                            <div class="row mt-3">
                                <?php
                                foreach ($imagesModel as $i=>$image):

                                if ($i ==0):
                                ?>
                                <div class="col-lg-7 col-12">
                                    <a data-fancybox="gallery" id="main-fullimage-gallery<?php echo $model->id;?>" rel="group<?php echo $model->id;?>" title="" href="<? echo $image->img_url; ?>">
                                        <div class="main-image" id="main-image-gallery<?php echo $model->id;?>" style="background-image: url('<? echo $image->img_url; ?>');">
                                          <span class="fullscreen">
                                                    <i class="fas fa-arrows-alt"></i>
                                                </span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 ml-lg-1 col-12  ml-0 mt-lg-0 mt-3">
                                    <div class="row">
                                        <?php
                                        endif;
                                        if (($i > 0) && ($i <=4)):
                                            ?>
                                            <?php
                                            $hiddenMobile= null;
                                            if ($i ==4){
                                                $hiddenMobile = 'hidden-mobile';
                                            }
                                            ?>

                                            <div class="col-lg-6 col-4 <?php echo $hiddenMobile;?>">
                                                <div data-groupgallery="gallery<?php echo $model->id;?>" data-image="<? echo $image->img_url; ?>" class="thumb-image" style="background-image: url('<? echo $image->img_url; ?>');">
                                                    <?php
                                                    if (($i ==4) && ($remainder !==null)):
                                                        ?>
                                                        <span class="more_photo hidden-mobile">
                                        </span>
                                                        <span class="count-balance-photo">  + <?php echo $remainder;?> фото </span>

                                                    <?php
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        <?php

                                        endif;
                                        ?>

                                        <?php
                                        //  if ($i > 0):

                                        ?>
                                        <a data-fancybox="gallery" rel="group<?php echo $model->id;?>" title="" href="<? echo $image->img_url; ?>" style="display:none;"></a>
                                        <?php
                                        // endif;
                                        ?>
                                        <?php

                                        endforeach;
                                        ?>
                                    </div>
                                </div>

                            </div>

                        <?php
                        endif;
                        ?>
                <div class="row">
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
</div>