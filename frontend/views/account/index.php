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

$this->title = Yii::t('app', 'Account');
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

var r = confirm('Вы действительно хотите удалить объявление?');
if (r == true) {
var delete_url = $(this).data('delete_url');
  $.ajax({
            url: delete_url,
            type: 'POST',
             success: function(data) {
                $('tr[data-key=' + data['id'] + ']').fadeOut();
             }
         });
}
})
$('.js-up-row').on('click',function(e){
e.preventDefault();
var up_url = $(this).data('up_url');
  $.ajax({
            url: up_url,
            type: 'POST',
             success: function(data) {
              if(data['status']=='success'){
              $('<br><span class=\"update\">Объявление поднято</span>').insertAfter('#'+data['id']);
              $('#'+data['id']).fadeOut();
              }
              if(data['status']=='failed'){
              $('<br><span class=\"error\">Извините, Вы не можете поднять объявление</span>').insertAfter('#'+data['id']); 
              $('#'+data['id']).fadeOut();
              }
             }
         });
})
});
", \yii\web\View::POS_END);

?>
<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class=" wow zoomInLeft" data-wow-delay="0.3s"><?= $this->title ?></h1>
    </div>
</section><!--b-pageHeader-->

<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            $this->title
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<section class="b-contacts s-shadow">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s"
                        style="visibility: visible; animation-delay: 0.5s; animation-name: zoomInUp;">
                    <h2 class="s-titleDet"><?= Yii::t('app', 'Your ads') ?></h2>
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
                        'class' => 'table table-condensed',
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
                <div style="text-align: right;">
                    <a href="/create-ads" class="btn m-btn m-btn-dark">
                        Добавить авто <span class="fa fa-angle-right"></span>
                    </a>
                </div>
            </div>
            <div class="col-xs-4">
                <?= Alert::widget() ?>
                <div class="b-contacts__form">
                    <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                        <h2 class="s-titleDet"><?= Yii::t('app', 'User data') ?></h2>
                    </header>
                    <div id="success"></div>
                    <?php $formWidget = ActiveForm::begin([
                        'id' => 'account-form',
                        'options' => [
                            'class' => 's-form wow zoomInUp',
                            'data-wow-delay' => '0.5s',
                        ]
                    ]); ?>
                    <?= $formWidget->field($model, "first_name", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                        ->textInput(['maxlength' => true, 'class' => '']) ?>
                    <?= $formWidget->field($model, "last_name", ['options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']])
                        ->textInput(['maxlength' => true, 'class' => '']) ?>
                    <label class="control-label" for="user-phone"><?= $model->getAttributeLabel('region') ?></label>
                    <div class='s-relative'>
                        <?= Html::activeDropDownList(
                            $model,
                            'region',
                            User::getRegions(),
                            ['class' => 'm-select']) ?>
                        <span class="fa fa-caret-down"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <?= $formWidget->field($model, "phone", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => '']) ?>
                        </div>
                        <div class="col-xs-5">
                            <label class="control-label"
                                   for="user-phone"><?= $model->getAttributeLabel('phone_provider') ?></label>
                            <div class='s-relative'>
                                <?= Html::activeDropDownList(
                                    $model,
                                    'phone_provider',
                                    User::getPhoneProviders(),
                                    ['class' => 'm-select']) ?>
                                <span class="fa fa-caret-down"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <?= $formWidget->field($model, "phone_2", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => '']) ?>
                        </div>
                        <div class="col-xs-5">
                            <label class="control-label"
                                   for="user-phone"><?= $model->getAttributeLabel('phone_provider') ?></label>
                            <div class='s-relative'>
                                <?= Html::activeDropDownList(
                                    $model,
                                    'phone_provider_2',
                                    User::getPhoneProviders(),
                                    ['class' => 'm-select']) ?>
                                <span class="fa fa-caret-down"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn m-btn" name="contact-button"><?= Yii::t('app', 'Save') ?><span
                                    class="fa fa-angle-right"></span></button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>