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
                'id',
                [
                    'attribute' => 'type_id',
                    'label'=>'Тип',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return ProductType::getType($model->type_id);
                    },
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'type_id', $typesList),
                ],
                [
                    'attribute' => 'make_id',
                    'label'=>'Марка',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return ProductMake::find()->select('name')->where(['id' => $model->make_id])->andWhere(['product_type' => $model->type_id])->one()->name;
                    },
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'make_id', $makesList),
                ],
                [
                    'attribute' => 'model',
                    'label'=>'Модель',
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'model')
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