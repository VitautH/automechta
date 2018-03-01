<?php
use yii\helpers\Html;
use common\models\Page;

/* @var $model Page */
?>
    <header class="b-blog__posts-one-body-head">
        <div class="b-blog__posts-one-body-head-notes">
                <span class="b-blog__posts-one-body-head-notes-note"><span
                            class="fa fa-calendar-o"></span><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
            <span class="b-blog__posts-one-body-head-notes-note"><span
                        class="fa fa-eye"></span><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>
        </div>
        <h2 class="s-titleDet s-title"><a href="<?= $model->getUrl() ?>"><?= Html::encode($model->i18n()->header) ?></a>
        </h2>
    </header>
    <?php
    if (!empty($model->getTitleImage())):
        ?>
        <div class="col-md-12">
            <a href="<?= $model->getUrl() ?>">
                <img class="img-responsive" src="<?= $model->getTitleImage(235, 211) ?>"
                     alt="<?= $model->i18n()->header ?>"/>
            </a>
        </div>
        <?php
    endif;
    ?>
    <div class="col-md-12 b-blog__posts-one-info">
        <p>
            <?= Html::encode($model->i18n()->description) ?>
            <a href="<?= $model->getUrl() ?>" class="m-readMore"><?= Yii::t('app', 'Read More') ?><span
                        class="fa fa-angle-double-right"></span></a>
        </p>
    </div>