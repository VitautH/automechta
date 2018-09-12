<?php

use common\models\AutoMakes;
use common\models\AutoModels;
use common\models\AutoModification;
use common\models\AutoBody;
use common\helpers\Url;
use common\models\ImageModifications;
use frontend\assets\AppAsset;
use common\models\AutoSearch;

$makeName = AutoMakes::find()->select('name')->where(['id'=>$model->make_id])->one();
$modelName = AutoModels::find()->select('model')->where(['id'=>$model->model_id])->one();
?>
<div class="row">
    <div class="col-md-12">
        <h2>
            <?php echo $makeName->name;?>
            <?php echo $modelName->model;?>
            <?php echo $model->modification_name; ?>
            <?php echo $model->years; ?>
        </h2>
    </div>
</div>
<?php
$imagesModel = ImageModifications::find()->where(['modifications_id' => $model->id])->all();
$imagesCount = ImageModifications::find()->where(['modifications_id' => $model->id])->count();
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
                <a data-fancybox="gallery" rel="group<?php echo $model->id;?>" title="" href="<? echo $image->img_url; ?>" style="display:none;"></a>
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

