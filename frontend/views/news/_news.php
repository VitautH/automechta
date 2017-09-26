<?php
use yii\helpers\Html;
use common\models\Page;
/* @var $model Page */

?>
<div class="row">
    <div class="col-xs-8">
        <header class="b-blog__posts-one-body-head s-lineDownLeft">
            <div class="b-blog__posts-one-body-head-notes">
                <span class="b-blog__posts-one-body-head-notes-note"><span class="fa fa-calendar-o"></span><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                <span class="b-blog__posts-one-body-head-notes-note"><span class="fa fa-eye"></span><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n'=> $model->views]) ?></span>
            </div>
            <h2 class="s-titleDet"><a href="<?= $model->getUrl() ?>"><?= Html::encode($model->i18n()->header) ?></a></h2>
        </header>
    </div>

    <a href="<?= $model->getUrl() ?>" class="col-xs-4 pull-right">
        <img class="img-responsive" src="<?= $model->getTitleImageUrl(235, 211) ?>" alt="<?= $model->i18n()->header ?>" />
    </a>
    <div class="col-xs-8 pull-right">
        <div class="b-blog__posts-one-info">
            <p>
                <?= Html::encode($model->i18n()->description) ?>
            </p>
            <a href="<?= $model->getUrl() ?>" class="btn m-btn m-readMore"><?= Yii::t('app', 'Read More') ?><span class="fa fa-angle-right"></span></a>
        </div>
    </div>
</div>