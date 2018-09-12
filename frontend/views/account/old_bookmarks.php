<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\Url as UrlProduct;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\models\AppData;
use common\models\Product;
use common\models\User;
use common\widgets\Alert;
use yii\grid\GridView;
use common\models\AuthAssignment;
use frontend\widgets\CustomPager;
use frontend\assets\AppAsset;

$this->title = 'Мои объявления';
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
$this->registerCss("span.update {    
font-size: 12px;
font-weight: bold; }

span.error{
font-size: 12px;
font-weight: bold;
color:red;
}

span.nextUp {
font-size: 12px;
}

a.js-up-row {
color: #f76d2b;
}
", \yii\web\View::POS_HEAD);

$this->registerJs("
 
$( document ).ready(function() {
$('.js-delete-row').on('click',function(e){
e.preventDefault();

var r = confirm('Вы действительно хотите удалить объявление из закладок?');
if (r === true) {
var productId = $(this).data('product');
 $.ajax({
            url:'/bookmarks/delete?id='+productId,
            type: 'GET',
             success: function(data) {
                $('tr[data-key=' + data['id'] + ']').fadeOut();
             }
         });
}
})

});
  

", \yii\web\View::POS_END);

?>
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1><?= $this->title ?></h1>
    </div>
</section><!--b-pageHeader-->

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ЛК</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Закладки <span class="sr-only">(current)</span></a></li>
                <li><a href="/account/index">Мои объявления</a></li>
                <li><a href="/account/setting">Настройки</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <header class="b-contacts__form-header s-lineDownLeft"
                        style="visibility: visible; animation-delay: 0.5s; animation-name: zoomInUp;">
                    <h2 class="s-titleDet">Закладки</h2>
                </header>
                <br>
                <?php \yii\widgets\Pjax::begin([
                    'id' => 'product_grid_wrapper',
                    'linkSelector' => '#producttype_grid_wrapper a:not(.button-col a)'
                ]); ?>
                <?=
                GridView::widget([
                    'id' => 'product_grid',
                    'dataProvider' => $dataProvider,
                    'tableOptions' => [
                        'class' => 'account_table_product table table-condensed',
                        'style' => 'table-layout: fixed;',
                    ],
                    'layout' => "\n{items}\n{pager}",
                    'pager' => [
                        'class' => 'frontend\widgets\CustomPager',
                        'options' => ['class' => 'b-items__pagination-main'],
                        'prevPageCssClass' => 'm-left',
                        'nextPageCssClass' => 'm-right',
                        'activePageCssClass' => 'm-active',
                        'wrapperOptions' => ['class' => 'b-items__pagination wow zoomInUp', 'data-wow-delay' => '0.5s']
                    ],
                    'columns' => [
                        [
                            'value' => function (Product $model, $key, $index, $column) {
                                $foto = Html::img($model->getTitleImageUrl(270, 150));
                                if ($model->status === Product::STATUS_PUBLISHED) {
                                    $foto = Html::a($foto, UrlProduct::UrlShowProduct($model->id), ['class'=>'show-product']);
                                }
                                return $foto;
                            },
                            'format' => 'html',
                            'headerOptions' => ['class' => ''],
                            'filterOptions' => ['class' => ''],
                            'contentOptions' => ['class' => ''],
                        ],
                        [
                            'attribute' => 'Модель',
                            'value' => function (Product $model, $key, $index, $column) {
                                $make = $model->getMake0()->one();
                                return $make->name . ' ' . $model->model;
                            },
                            'headerOptions' => ['class' => ''],
                            'filterOptions' => ['class' => ''],
                            'contentOptions' => ['class' => ''],
                        ],
                        [
                            'attribute' => 'Стоимость',
                            'value' => function (Product $model, $key, $index, $column) {
                                $make = $model->getMake0()->one();
                                return $model->price . ' $';
                            },
                            'headerOptions' => ['class' => ''],
                            'filterOptions' => ['class' => ''],
                            'contentOptions' => ['class' => ''],
                        ],
                        [
                            'attribute' => 'Дата подачи',
                            'value' => function (Product $model, $key, $index, $column) {
                                $make = $model->getMake0()->one();
                                return Yii::$app->formatter->asDate($model->created_at);
                            },
                            'headerOptions' => ['class' => ''],
                            'filterOptions' => ['class' => ''],
                            'contentOptions' => ['class' => ''],
                        ],
                        [
                            'attribute' => 'Дата обновления',
                            'value' => function (Product $model, $key, $index, $column) {
                                $make = $model->getMake0()->one();
                                return Yii::$app->formatter->asDate($model->updated_at);
                            },
                            'headerOptions' => ['class' => ''],
                            'filterOptions' => ['class' => ''],
                            'contentOptions' => ['class' => ''],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{show}{delete}',
                            'contentOptions' => ['class' => 'button-col'],
                            'buttons' => [
                                'show' => function ($url, $model, $key) {
                                    if ($model->status === Product::STATUS_TO_BE_VERIFIED) {
                                        return Html::a('<span class="fa fa-eye"></span>',  UrlProduct::UrlShowPreviewProduct($model->id),
                                            [
                                                'target' => '_blank',
                                                'style' => 'margin-right: 10px',
                                                'title' => 'Предпросмотр',
                                            ]
                                        );
                                    }
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="fa fa-remove"></span>', '#',
                                        [
                                            'class' => 'js-delete-row',
                                            'style' => 'margin-right: 10px',
                                            'data-product' =>$model->id,
                                            'title' => Yii::t('app', 'Delete'),
                                        ]
                                    );
                                },
                            ]
                        ],
                    ]
                ]);
                ?>
                <?php
                \yii\widgets\Pjax::end();
                ?>
                <div class="pagination-block">
                </div>
            </div>
        </div>
    </div>
</section>