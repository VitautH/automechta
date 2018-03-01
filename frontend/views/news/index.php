<?php
use yii\widgets\ListView;
use common\models\AppData;
use common\models\Page;
use yii\widgets\Breadcrumbs;
use frontend\controllers\NewsController;
use yii\helpers\Html;
use Yii;

/* @var $this frontend\components\View */
/* @var $provider yii\data\ActiveDataProvider */

/*
 * Block News without image
 * Pagination
 */
$params = Yii::$app->request->get();
$limit = NewsController::PAGE_SIZE;
if (isset($params['page'])) {
    $page = intval($params['page']);
    if ($page == 1) {
        $offset = 0;
    } else {
        $offset = NewsController::PAGE_SIZE * ($page - 1);
    }
} else {
    $offset = 0;
}

$appData = AppData::getData();
$popularNews = Page::find()->active()->news()->orderBy('views DESC')->limit(2)->all();
$latestNews = Page::find()->active()->news()->orderBy('id DESC')->limit(3)->all();
$newsWithoutImage = Page::find()->andWhere(['main_image' => null])->active()->news()->offset($offset)->limit($limit)->orderBy('id desc')->all();
$this->title = 'Авто новости';

?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class="">Автоновости  в Беларуси</h1>
    </div>
</section><!--b-pageHeader-->
<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            Yii::t('app', 'News')
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<div class="b-blog s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="b-blog__posts">
                    <?php
                    echo ListView::widget([
                        'options' => ['class' => 'b-blog__posts'],
                        'dataProvider' => $provider,
                        'layout' => "{items}\n{pager}",
                        'itemOptions' => ['class' => 'b-blog__posts-one'],
                        'pager' => [
                            'class' => 'frontend\widgets\CustomPager',
                            'options' => ['class' => 'b-items__pagination-main'],
                            'prevPageCssClass' => 'm-left',
                            'nextPageCssClass' => 'm-right',
                            'activePageCssClass' => 'm-active',
                            'wrapperOptions' => ['class' => 'b-items__pagination']
                        ],
                        'itemView' => '_news',
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <aside class="b-blog__aside">
                    <?php
                    foreach ($newsWithoutImage as $news):
                        ?>
                        <div class="b-blog__posts-one_right">
                            <header class="b-blog__posts-one-body-head">
                                <div class="b-blog__posts-one-body-head-notes">
                <span class="b-blog__posts-one-body-head-notes-note"><span
                            class="fa fa-calendar-o"></span><?= Yii::$app->formatter->asDate($news->created_at) ?></span>
                                    <span class="b-blog__posts-one-body-head-notes-note"><span
                                                class="fa fa-eye"></span><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $news->views]) ?></span>
                                </div>
                                <h2 class="s-titleDet s-title"><a
                                            href="<?= $news->getUrl() ?>"><?= Html::encode($news->i18n()->header) ?></a>
                                </h2>
                            </header>
                            <div class="col-md-12 b-blog__posts-one-info">
                                <p>
                                    <?= Html::encode($news->i18n()->description) ?>
                                    <a href="<?= $news->getUrl() ?>"
                                       class="m-readMore"><?= Yii::t('app', 'Read More') ?><span
                                                class="fa fa-angle-double-right"></span></a>
                                </p>
                            </div>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </aside>
            </div>
        </div>
    </div>
</div><!--b-blog-->