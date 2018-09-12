<?php
use common\models\Page;
use common\models\AppData;
use common\models\MetaData;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this frontend\components\View */
/* @var $model Page */
/* @var $provider yii\data\ActiveDataProvider */


$appData = AppData::getData();
$popularNews = Page::find()->active()->news()->orderBy('views DESC')->limit(2)->all();
$metaData = MetaData::getModels($model);
$this->title= $model->i18n()->header;
$this->registerCssFile('/css/news-style.css');
?>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><a href="/news">Новости<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2"><?= $model->i18n()->header ?></span></li>
        </ul>
    </div>
</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="news">
                    <div class="b-blog__posts-one">
                        <div class="m-noBlockPadding">
                                <div class="b-blog__posts-one-body">
                                    <header class="b-blog__posts-one-body-head">
                                        <h3 class="s-titleDet s-title"><?= $model->i18n()->header ?></h3>
                                        <div class="b-blog__posts-one-body-head-notes">
                                            <span class="b-blog__posts-one-body-head-notes-note"><i
                                                        class="fas fa-calendar-o"></i><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                                            <span class="b-blog__posts-one-body-head-notes-note"><i
                                                        class="fas fa-eye"></i><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>

                                        </div>
                                    </header>
                                    <div class="b-blog__posts-one-body-main">
                                        <?php
                                        if ($model->i18n->main_image !== null):
                                            ?>
                                            <div class="b-blog__posts-one-body-main-img">
                                                <img class="img-responsive"
                                                     src="<?= $model->getTitleImageUrl(750, 300) ?>"
                                                     alt="<?= $model->i18n()->header ?>"/>
                                            </div>
                                            <?php
                                        endif;
                                        ?>
                                    </div>
                                    <div class="b-blog__posts-one-body-why">
                                        <p>
                                            <?= $model->i18n()->content ?>
                                        </p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 hidden-mobile">

            </div>
        </div>
    </div>