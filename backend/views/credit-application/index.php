<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;
use \common\models\CreditApplication;

$name = Yii::t('app', 'Credit Applications');
$currentLang = Yii::$app->language;
$this->title = $name;
$this->registerJs("require(['controllers/creditApplication/index']);", \yii\web\View::POS_HEAD);
?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2><?= $name ?></h2>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-shadow--2dp">
        <?php \yii\widgets\Pjax::begin([
            'id' => 'credit-application_grid_wrapper',
            'linkSelector' => '#credit-application_grid_wrapper a:not(.button-col a)'
        ]); ?>
        <?=
        GridView::widget([
            'id' => 'credit-application_grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class'=>'mdl-data-table mdl-data-table--no-border mdl-js-data-table'
            ],
            'columns' => [
                [
                    'attribute' => 'name',
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, "name")
                ],
                [
                    'attribute' => 'product',
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, "product")
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model, $key, $index, $column) {
                        return CreditApplication::getStatuses()[$model->status];
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'status', CreditApplication::getStatuses(), ['prompt'=>Yii::t('app', 'Any')]),
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:m:s'],
                    'headerOptions' => ['style' => 'width: 215px;'],
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'created_at')
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{delete}',
                    'contentOptions' => ['class' => 'button-col'],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::button(
                                '<i class="material-icons red-text">delete</i>',
                                [
                                    'class' => 'mdl-button mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                    'data-delete_url' => Url::to(['credit-application/delete', 'id' => $model->id]),
                                    'title' => Yii::t('app', 'Delete'),
                                ]
                            );
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="material-icons teal-text">info</i>',
                                Url::to(['credit-application/view', 'id' => $model->id]),
                                [
                                    'class' => 'mdl-button mdl-js-button mdl-button--icon mdl-button--colored',
                                    'title' => Yii::t('app', 'Edit'),
                                ]
                            );
                        }
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

