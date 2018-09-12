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
use common\models\VideoAuto;
use yii\widgets\Pjax;

$this->title = "Видео";

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
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'product_id',
                    'label'=>'Объявление',
                    'format' => 'html',
                    'value' => function ($model) {
                        return Html::a('№ '.$model->product_id,'/product/update?id='.$model->product_id);
                    },
                ],
                [
                    'attribute' => 'product_type',
                    'label'=>'Тип',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return ProductType::getType($model->product_type);
                    },
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'product_type', $typesList),
                ],
                [
                    'attribute' => 'product_make',
                    'label'=>'Марка',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return ProductMake::find()->select('name')->where(['id' => $model->product_make])->andWhere(['product_type' => $model->product_type])->one()->name;
                    },
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'product_make', $makesList),
                ],
                [
                    'attribute' => 'model',
                    'label'=>'Модель',
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'model')
                ],
                [
                    'attribute' => 'year',
                    'label'=>'Год',
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'year')
                ],
                [
                    'attribute' => 'video_url',
                    'label'=>'Видео',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<iframe width="220" height="140" src="https://www.youtube.com/embed/' . $model->video_url . '?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
                    },
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'video_url')
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'contentOptions' => ['class' => 'action-column'],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash">Удалить видео</span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-pjax' => '#model-grid',
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php
        Pjax::end();
        ?>
    </div>
</div>