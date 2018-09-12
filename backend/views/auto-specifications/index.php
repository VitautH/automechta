<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;
use \common\models\ProductType;
use \common\models\ProductMake;
use common\models\AutoMakes;
use common\models\AutoRegions;
use yii\widgets\Pjax;

$this->title = "Спецификации";

?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2>Видео</h2>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-shadow--2dp">
        <?php Pjax::begin(['id' => 'model-grid', 'enablePushState' => false]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'attribute' => 'region_id',
                    'label'=>'Регион',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return AutoRegions::findOne($model->region_id)->region_name;
                    },
                ],
                [
                    'attribute' => 'make_id',
                    'label'=>'Марка',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return AutoMakes::findOne($model->make_id)->name;
                    },
                   // 'filter' => MdlHtml::activeDropDownList($searchModel, 'product_type', $typesList),
                ],
                [
                    'attribute' => 'model',
                    'label'=>'Модель',
                    'format' => 'raw',
                   // 'filter' => MdlHtml::activeDropDownList($searchModel, 'product_make', $makesList),
                ],
                [
                    'attribute' => 'years',
                    'label'=>'Год',
                   // 'filter' => MdlHtml::activeInput('text', $searchModel, 'model')
                ],
                [
                    'attribute' => 'modification',
                    'label'=>'Модификация',
                   // 'filter' => MdlHtml::activeInput('text', $searchModel, 'year')
                ],

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'contentOptions' => ['class' => 'action-column'],
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="material-icons teal-text">info</i>',
                                Url::to(['auto-specifications/view', 'id' => $model->id]),
                                [
                                    'class' => 'mdl-button mdl-js-button mdl-button--icon mdl-button--colored',
                                    'title' => Yii::t('app', 'Show'),
                                ]
                            );
                        }
                    ],
                ],
            ],
        ]); ?>
        <?php
        Pjax::end();
        ?>
    </div>
</div>