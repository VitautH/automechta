<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\models\User;
use common\widgets\Alert;
use yii\grid\GridView;
use common\models\AuthAssignment;
use frontend\widgets\CustomPager;
use frontend\assets\AppAsset;
use yii\widgets\ListView;

$this->title = 'Поиск';
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
$this->registerJs("require(['controllers/modification/searchForm']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/modification/index']);", \yii\web\View::POS_HEAD);
$this->registerJsFile("/js/modernizm.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/owl.carousel.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/owl.css');
$this->registerCssFile('@web/theme/css/catalog.css');
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css');
$this->registerCssFile('@web/css/modification-index-style.css');
?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Энциклопедия автомобилей</span></li>
        </ul>
    </div>
</div>
<div class="bg-row">
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="block-title-banner">
            <div class="row justify-content-center">
            <h2>Энциклопедия автомобилей</h2>
            </div>
            <div class="row justify-content-center">
            <span class="count-modification">Найдено <?php echo $_params_["total"];?> модификаций</span>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <?= $this->render('_searchForm', $_params_) ?>
        </div>
    </div>
</div>
</div>
        <div class="container">
            <div class="models">
                <div class="col-12 pl-0">
                    <div class="cars-modification-list">
                <?php


                        echo ListView::widget([
                    'options' => ['tag' => 'div','class' => 'b-blog__posts'],
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'itemOptions' => ['class' => ''],
                    'pager' => [
                        'class' => 'frontend\widgets\ChildPagination',
                        'maxButtonCount' => 4,
                        'options' => ['class' => 'pagination'],
                        'prevPageCssClass' => 'd-none',
                        'activePageCssClass' => 'page-link active',
                        'pageCssClass' => 'page-link',
                        'disabledPageCssClass' => 'd-none',
                    ],
                    'itemView' => '_itemSearch',
                ]);
                ?>
                    </div>
                </div>
            </div>
        </div>
</div>