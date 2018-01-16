<?php

/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use common\models\AppData;

$this->title = Yii::t('app', 'Your ad is saved');
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
?>
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= Yii::t('app', 'Ad is saved') ?></h1>
    </div>
</section><!--b-pageHeader-->

<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            Yii::t('app', 'Saved')
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->

<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                    <h2 class="s-titleDet"><?= $this->title ?></h2>
                </header>
                <p class=" wow zoomInUp" data-wow-delay="0.5s">
                    <?= Yii::t('app', 'Your ad is saved and will be published after validation')?>.<br>
                    <?= Yii::t('app', 'Published announcements are available for editing in your account')?>.<br>
                </p>
                <p class=" wow zoomInUp" data-wow-delay="0.5s">
                    <?= Yii::t('app', 'Thank you')?>.<br>
                </p>
            </div>
            <div class="col-xs-6 wow zoomInUp" data-wow-delay="0.5s">
                <header class="b-contacts__form-header s-lineDownLeft">
                    <h2 class="s-titleDet"><?= Yii::t('app', 'Go to') ?></h2>
                </header>
                <a href="/cars" class="btn m-btn m-btn-dark">
                    <?= Yii::t('app', 'Catalog') ?> <span class="fa fa-angle-right"></span>
                </a>
                <a href="/account" class="btn m-btn m-btn-dark">
                    <?= Yii::t('app', 'Account') ?> <span class="fa fa-angle-right"></span>
                </a>
            </div>
        </div>
    </div>
</section>

