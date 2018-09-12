<?php

use yii\widgets\ListView;
use common\models\AppData;
use common\models\Page;
use yii\widgets\Breadcrumbs;
use frontend\controllers\NewsController;
use frontend\widgets\ChildPagination;
use yii\helpers\Html;
use Yii;
use common\helpers\Url;


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
$this->registerCssFile('/css/news-style.css');

$popularNews = Page::find()->active()->news()->orderBy('views DESC')->limit(2)->all();
$latestNews = Page::find()->active()->news()->orderBy('id DESC')->limit(3)->all();
$newsWithoutImage = Page::find()->andWhere(['main_image' => null])->active()->news()->offset($offset)->limit($limit)->orderBy('id desc')->all();
$this->title = 'Авто новости';
?>
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
                <li><span class="no-link ml-lg-2">Новости</span></li>
            </ul>
        </div>
    </div>
    <div class="header hidden-mobile">
        <div class="container">
            <div class="row">
                <h3>Автоновости</h3>
            </div>
        </div>
    </div>
<?php
foreach ($models as $i => $model):
    if ($i === 0):
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
                    <!-- Yandex.RTB R-A-288803-1 -->
                    <div id="yandex_rtb_R-A-288803-1"></div>
                    <script type="text/javascript">
                        (function(w, d, n, s, t) {
                            w[n] = w[n] || [];
                            w[n].push(function() {
                                Ya.Context.AdvManager.render({
                                    blockId: "R-A-288803-1",
                                    renderTo: "yandex_rtb_R-A-288803-1",
                                    async: true
                                });
                            });
                            t = d.getElementsByTagName("script")[0];
                            s = d.createElement("script");
                            s.type = "text/javascript";
                            s.src = "//an.yandex.ru/system/context.js";
                            s.async = true;
                            t.parentNode.insertBefore(s, t);
                        })(this, this.document, "yandexContextAsyncCallbacks");
                    </script>
                </div>
            </div>
        </div>
    <?
    endif;
    ?>
    <?php
    if (($i > 0) && ($i < 9) && (!empty($model->getTitleImage()))) :
        if ($i === 1):
            ?>

            <div class="container  hidden-mobile">
            <div class="row other-news news-row ">
            <div class="col-12">
            <div class="row">
        <?php
        endif;
        ?>
        <div class="col-3">
            <a class="item" href="<?php echo $model->getUrl(); ?>">
            <div class="news-item">

                    <div class="news-image"
                         style="background: url(<?php echo $model->getTitleImage(); ?>) no-repeat center;">

                    </div>

                <div class="news-description">

                        <h3> <?php
                            echo $model->i18n()->header;
                            ?></h3>
                    
                    <p> <?php echo Html::encode($model->i18n()->description); ?></p>
                    <div class="bottom">
  <span class="b-blog__posts-one-body-head-notes-note"><i
              class="fas fa-calendar-o"></i><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                        <span class="b-blog__posts-one-body-head-notes-note"><i
                                    class="fas fa-eye"></i><?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>

                    </div>
                </div>
            </div>
            </a>
        </div>
        <?php
        if ($i === 8):
            ?>
            </div>
            </div>
            </div>
            </div>
        <?php
        endif;
        ?>
    <?php
    endif;
    ?>
<?php
endforeach;
?>

<div class="container hidden-mobile">
      <div class="row">
                        <div class="col-12 col-lg-9">
<?php
foreach ($models as $i=>$model):
    ?>
    <?php
    if(($i >8 ) && (!empty($model->getTitleImage()))):
        ?>
        <div class="all-news">
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
        <?php
endif;
    ?>
<?php
endforeach;
?>
                        </div>
          <div class="col-lg-3">

          </div>
      </div>
</div>

<div class="container hidden-desktop">
<?php
foreach ($models as $i => $model):
?>
    <?php
if(!empty($model->getTitleImage())):
    ?>
    <?php
if ($i == 4):
    ?>
    <div class="row">
    <!-- Yandex.RTB R-A-288803-2 -->
    <div id="yandex_rtb_R-A-288803-2"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-288803-2",
                    renderTo: "yandex_rtb_R-A-288803-2",
                    async: true
                });
            });
            t = d.getElementsByTagName("script")[0];
            s = d.createElement("script");
            s.type = "text/javascript";
            s.src = "//an.yandex.ru/system/context.js";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(this, this.document, "yandexContextAsyncCallbacks");
    </script>
</div>
    <?php
            endif;
    ?>
    <?php
    if ($i == 8):
        ?>
    <div class="row">
    <!-- Yandex.RTB R-A-288803-2 -->
    <div id="yandex_rtb_R-A-288803-2"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-288803-2",
                    renderTo: "yandex_rtb_R-A-288803-2",
                    async: true
                });
            });
            t = d.getElementsByTagName("script")[0];
            s = d.createElement("script");
            s.type = "text/javascript";
            s.src = "//an.yandex.ru/system/context.js";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(this, this.document, "yandexContextAsyncCallbacks");
    </script>
    </div>
    <?php
    endif;
    ?>
    <div class="row">
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
    <?php
endif;
    ?>
<?php
endforeach;

?>
</div>
<div class="container">
    <nav class="pagination">
        <?php if ($currentPage != 1): ?>
            <a rel="canonical" data-page="<? echo $currentPage - 1; ?>" class="hidden-mobile prev-button"
               href="<?= Url::current(['page' => $currentPage - 1]) ?>">Предыдущая</a>
            <a rel="canonical" data-page="<? echo $currentPage - 1; ?>" class="button-mobile-prev custom-button hidden-desktop prev-button"
               href="<?= Url::current(['page' => $currentPage - 1]) ?>"><i class="ml-1 fas fa-arrow-left"></i></a>
        <?php
        endif;
        ?>
        <div class="hidden-mobile">
            <?php
            echo ChildPagination::widget([
                'pagination' => $pages,
                'maxButtonCount' => 4,
                'options' => ['class' => 'b-items__pagination-main'],
                'prevPageCssClass' => 'd-none',
                'activePageCssClass' => 'page-link active',
                'pageCssClass' => 'page-link',
                'disabledPageCssClass' => 'd-none',
            ]);
            ?>
        </div>
        <div class="hidden-desktop">
            <span class="count_pages"> <?= $currentPage; ?> из <?= $lastPage; ?></span>
        </div>
        <?php if ($currentPage < $lastPage): ?>
            <a rel="canonical" data-page="<?php echo $currentPage + 1; ?>" class="hidden-mobile next-button"
               href="<?= Url::current(['page' => $currentPage + 1]) ?>">Следующая страница <i class="ml-1 fas fa-arrow-right"></i></a>
            <a rel="canonical" data-page="<?php echo $currentPage + 1; ?>" class="button-mobile-next custom-button hidden-desktop next-button"
               href="<?= Url::current(['page' => $currentPage + 1]) ?>">Следующая страница <i class="ml-1 fas fa-arrow-right"></i></a>
        <?php
        endif;
        ?>
    </nav>
</div>