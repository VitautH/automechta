<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;
use \common\models\Product;
use \common\models\ProductMake;
use common\models\Complaint;
use yii\widgets\Pjax;
$currentLang = Yii::$app->language;
$this->title = "Жалобы";
?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2>Жалобы</h2>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-shadow--2dp">
        <?php Pjax::begin(['id' => 'model-grid', 'enablePushState' => false]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'attribute' => 'product_id',
                    'format'=>'html',
                    'value'=>function($model){
            return Html::a($model->product_id, '/product/update?id='.$model->product_id);
                    }
                ],
                [
                    'attribute' => 'complaint_type',
                    'format'=>'raw',
                    'value'=>function($model){
                        return Complaint::$type_comlaint[$model->complaint_type];
                    }
                ],
                'complaint_text',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'contentOptions' => ['class' => 'action-column'],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash">Удалить жалобу</span>', $url, [
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