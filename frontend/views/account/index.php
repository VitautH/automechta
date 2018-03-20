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
$this->registerJs("require(['controllers/account/actionAds']);", \yii\web\View::POS_HEAD);

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
                <li><a href="/account/bookmarks">Закладки</a></li>
                <li class="active"><a href="#">Мои объявления <span class="sr-only">(current)</span></a></li>
                <li><a href="/account/setting">Настройки</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<section class="b-contacts s-shadow">
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
                        <span class="sr-only">Error:</span>
                НА ВАШ E-MAIL ОТПРАВЛЕНО ПИСЬМО С ССЫЛКОЙ ДЛЯ ПОДТВЕРЖДЕНИЯ РЕГИСТРАЦИИ
                   <br> Пожалуйста, активируйте регистрацию, перейдя по ссылке в письме, отправленном на ваш e-mail

                </div>
          <?php
          endif;
            ?>
            <div class="col-md-12">
                <header class="b-contacts__form-header s-lineDownLeft"
                        style="visibility: visible; animation-delay: 0.5s; animation-name: zoomInUp;">
                    <h2 class="s-titleDet">Мои объявления</h2>
                </header>
                <p class="hint-block">Объявление может быть поднято не чаще чем один раз в 24 часа.</p>
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
                            'class' => 'yii\grid\CheckboxColumn',
                          'checkboxOptions' => function($model, $key, $index, $widget) {
                     if ($model->updated_at >= (time() - (1 * 24 * 60 * 60))) {
                         return ["disabled"=>"true"];
                     }
                          }
                        ],
                        [
                            'value' => function (Product $model, $key, $index, $column) {
                                $foto = Html::img($model->getTitleImageUrl(267,180));
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
                            'template' => '{show}{update}{delete}{up}',
                            'contentOptions' => ['class' => 'button-col'],
                            //'headerOptions' => ['style' => 'width: 400;'],
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="fa fa-remove"></span>', '#',
                                        [
                                            'class' => 'js-delete-row',
                                            'style' => 'margin-right: 10px',
                                            'data-delete_url' => Url::to(['account/delete-product', 'id' => $model->id]),
                                            'title' => Yii::t('app', 'Delete'),
                                        ]
                                    );
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<span class="fa fa-edit"></span>',
                                        Url::to(['/update-ads', 'id' => $model->id]),
                                        [
                                            'style' => 'margin-right: 10px',
                                            'title' => Yii::t('app', 'Edit'),
                                        ]
                                    );
                                },
                                'up' => function ($url, $model, $key) {
                                    if ($model->updated_at < (time() - (1 * 24 * 60 * 60))) {
                                        $result = Html::a('<span class="">UP</span>', '#',
                                            [
                                                'class' => 'js-up-row',
                                                'id' => $model->id,
                                                'data-up_url' => Url::to(['account/up-product', 'id' => $model->id]),
                                                'title' => 'Поднять объявление',
                                            ]
                                        );
                                    } else {
                                        $timeToUp = $model->updated_at + (1 * 24 * 60 * 60);
                                        $result = Html::a('<span style="opacity: 0.5;" class="">UP</span>', '#',
                                            [
                                                'onclick' => 'return false;',
                                                'title' => 'Может быть поднято ' . Yii::$app->formatter->asDatetime($timeToUp),
                                                'class' => 'js-up-disabled',
                                            ]
                                        );
                                        $now = new DateTime();
                                        $timeLeft =  explode('/',Yii::$app->formatter->asDuration(($timeToUp - $now->getTimestamp()),'/'));

                                        $result .= '<br><span class="nextUp">Следующее обновление через ' .$timeLeft[0] . '</span>';
                                    }
                                    return $result;
                                },
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
                            ]
                        ],
                    ]
                ]);
                ?>
                <?php
                \yii\widgets\Pjax::end();
                ?>
                <label>Выберите действие:</label>
                <select name="action" id="action">
                    <option value="up">Поднять</option>
                </select>
                <button id="apply" name="apply">Применить</button>
                <div class="pagination-block">
                    <a href="/create-ads" class="btn m-btn m-btn-dark create-ads-button">
                        <span class="fa fa-plus"></span>
                        ПОДАТЬ ОБЪЯВЛЕНИЕ
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>