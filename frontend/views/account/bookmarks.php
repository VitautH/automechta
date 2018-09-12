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
use yii\widgets\LinkSorter;

$this->title = 'Закладки';
$this->params['breadcrumbs'][] = $this->title;
$appData = AppData::getData();
$this->registerJs("require(['controllers/account/actionAds']);", \yii\web\View::POS_HEAD);
$this->registerJsFile("/js/account-sort.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/account.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/css/account-style.css');
AppAsset::register($this);

?>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2">Личный кабинет</span></li>
        </ul>
    </div>
</div>
<div class="container">
    <nav>
        <ul class="nav nav-tabs row left-content-between" id="myTab" role="tablist">
            <li class="nav-item col-lg-2 p-0">
                <a class="nav-link" href="/account/index">Мои объявления</a>
            </li>
            <li class="nav-item col-lg-2 p-0">
                <a class="nav-link active" href="/account/bookmarks">Закладки</a>
            </li>
            <li class="nav-item col-lg-2 p-0">
                <a class="nav-link" href="/account/setting">Настройки</a>
            </li>
        </ul>
    </nav>
</div>

<div class="container">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="row">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <span><?= Yii::$app->session->getFlash('success') ?></span>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <?php
        $status = AuthAssignment::find()->select('item_name')->where(['user_id' => $model->id])->one();

        if ($status->item_name == 'RegisteredUnconfirmed'):
            ?>
            <div class="alert alert-danger col-md-12" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Ошибка:</span>
                НА ВАШ E-MAIL ОТПРАВЛЕНО ПИСЬМО С ССЫЛКОЙ ДЛЯ ПОДТВЕРЖДЕНИЯ РЕГИСТРАЦИИ
                <br> Пожалуйста, активируйте регистрацию, перейдя по ссылке в письме, отправленном на ваш e-mail

            </div>
        <?php
        endif;
        ?>
    </div>
    <div class="row">
        <div class="col-12 col-lg-9">
<!--            <div class="sorter">-->
<!--                <span>Сортировать по:</span>-->
<!--                --><?//= LinkSorter::widget([
//                    'sort' => $sort,
//                    'attributes' => [
//                        'price',
//                        'created_at',
//                    ]
//                ]);
//
//                ?>
<!--            </div>-->
        </div>
    <div class="container-ads">
        <div class="row">
            <div class="col-lg-12 col-12">
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
                    ],
                    'layout' => "\n{items}\n{pager}",
                    'pager' => [
                        'class' => 'frontend\widgets\ChildPagination',
                        'maxButtonCount' => 4,
                        'options' => ['class' => 'pagination'],
                        'prevPageCssClass' => 'd-none',
                        'activePageCssClass' => 'page-link active',
                        'pageCssClass' => 'page-link',
                        'disabledPageCssClass' => 'd-none',
                    ],
                    'columns' => [
                        [
                            'value' => function (Product $model, $key, $index, $column) {
                                $foto = Html::img($model->getTitleImageUrl(270, 150));
                                if ($model->status === Product::STATUS_PUBLISHED) {
                                    $foto = Html::a($foto, UrlProduct::UrlShowProduct($model->id), ['class'=>'image-ads show-product']);
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
                            'template' => '{delete}',
                            'contentOptions' => ['class' => 'button-col'],
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<i class="fas fa-remove"></i>', '#',
                                        [
                                            'class' => 'js-delete-bookmarks-row',
                                            'style' => 'margin-right: 10px',
                                            'data-product' =>$model->id,
                                            'data-delete_url'=>Url::to(['/bookmarks/delete', 'id' => $model->id]),
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
            </div>
        </div>
    </div>
</div>
</div>
