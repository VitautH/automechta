<?php

use yii\helpers\Html;
use common\models\Page;

/* @var $model Page */


?>
<?php

if (($index === 0) && (!empty($model->getTitleImage()))) {
    ?>
    <div class="container">
        <div class="row">
            <div class="first-news col-lg-9 hidden-mobile">
                <div class="row">
                    <div class="col-lg-6 no-padding">
                        <div class="image"
                             style="background: url(<?php echo $model->getTitleImage(); ?>) no-repeat center;">

                        </div>
                    </div>
                    <div class="col-lg-6 no-padding">
                        <div class="content">
                            <h3>
                                <?php
                                echo $model->i18n()->header;
                                ?>
                            </h3>

                            <p>
                                <?php echo Html::encode($model->i18n()->description); ?>
                            </p>
                            <a class="custom-button" href="<?php echo $model->getUrl(); ?>">Читать <i
                                        class="ml-2 fas fa-angle-right"></i> </a>

                            <div class="bottom">
  <span class="b-blog__posts-one-body-head-notes-note"><i
              class="fas fa-calendar-o"></i><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                                <span class="b-blog__posts-one-body-head-notes-note"><i
                                            class="fas fa-eye"></i><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="ads col-lg-3 hidden-mobile">

            </div>
        </div>
    </div>

    <?php
}
if (($index >0) && ($index < 9) && (!empty($model->getTitleImage()))) :
    ?>
    <?php

    if ($index === 1):

    ?>
    <div class="container">
    <div class="row other-news news-row">
        <?php
        endif;
        ?>
        <div class="col-3 hidden-mobile">
            <div class="news-item">
                <a href="<?php echo $model->getUrl(); ?>">
                    <div class="news-image"
                         style="background: url(<?php echo $model->getTitleImage(); ?>) no-repeat center;">

                    </div>
                </a>
                <div class="news-description">
                    <a href="<?php echo $model->getUrl(); ?>">
                        <h3> <?php
                            echo $model->i18n()->header;
                            ?></h3>
                    </a>
                    <p> <?php echo Html::encode($model->i18n()->description); ?></p>
                    <div class="bottom">
  <span class="b-blog__posts-one-body-head-notes-note"><i
              class="fas fa-calendar-o"></i><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                        <span class="b-blog__posts-one-body-head-notes-note"><i
                                    class="fas fa-eye"></i><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>

                    </div>
                </div>
            </div>
        </div>
        <?php
if ($index === 4):
 ?>

    </div>
  <div class="row other-news news-row">
    <?php
endif;
    ?>
    <?php
    if ($index === 8):
    ?>

        </div>
        </div>
        <?php
    endif;
        ?>
    <?php
endif;
if ($index >8):
    ?>
    <div class="container">
        <div class="row hidden-mobile">

            <div class="col-lg-9 col-12 all-news">
                <div class="row">
                    <div class="col-lg-3  no-padding">
                        <a href="<?php echo $model->getUrl(); ?>">
                            <div class="image"
                                 style="background: url(<?php echo $model->getTitleImage(); ?>) no-repeat center;">

                            </div>
                        </a>
                    </div>
                    <div class="col-lg-9   no-padding">
                        <div class="content">
                            <a href="<?php echo $model->getUrl(); ?>"><h3>  <?php
                                    echo $model->i18n()->header;
                                    ?></h3>
                            </a>
                            <p>
                                <?php echo Html::encode($model->i18n()->description); ?>
                            </p>


                            <div class="bottom">
  <span class="b-blog__posts-one-body-head-notes-note"><i
              class="fas fa-calendar-o"></i><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                                <span class="b-blog__posts-one-body-head-notes-note"><i
                                            class="fas fa-eye"></i><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="ads col-lg-3">

            </div>
        </div>
        <div class="row hidden-desktop">
            <div class="col-12 all-news-mobile">
                <a href="<?php echo $model->getUrl(); ?>">
                    <div class="image"
                         style="background: url(<?php echo $model->getTitleImage(); ?>) no-repeat center;">

                    </div>
                </a>
                <div class="content">
                    <a href="<?php echo $model->getUrl(); ?>"><h3>  <?php
                            echo $model->i18n()->header;
                            ?></h3>
                    </a>
                    <p>
                        <?php echo Html::encode($model->i18n()->description); ?>
                    </p>


                    <div class="bottom">
  <span class="b-blog__posts-one-body-head-notes-note"><i
              class="fas fa-calendar-o"></i><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                        <span class="b-blog__posts-one-body-head-notes-note"><i
                                    class="fas fa-eye"></i><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
endif;
?>