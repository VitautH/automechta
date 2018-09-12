<?php

use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\MdlHtml;
use common\models\AuthAssignment;

/* @var $this yii\web\View */
$name = Yii::t('app', 'Users');
$this->title = $name;
$this->registerJs("require(['controllers/users/index']);", \yii\web\View::POS_HEAD);
?>

<div class="row">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $name;?></h3>
            <a class="btn btn-app" href="<?= Url::to(['users/create']) ?>">
                <i class="fa fa-plus"></i> Добавить
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
        <?php \yii\widgets\Pjax::begin([
            'id' => 'user_grid_wrapper',
            'linkSelector' => '#user_grid_wrapper a:not(.button-col a)'
        ]); ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'role' => 'grid',
                'class' => 'table table-bordered table-striped dataTable mdl-js-data-table'
            ],
            'rowOptions' => ['role' => 'row', 'class' => 'odd'],
            'columns' => [
                [
                    'attribute' => 'id',
                    //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                   //// 'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    //'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'id')
                ],
                [
                    'attribute' => 'status',
                   // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                   // 'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                   // 'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'format' => 'raw',
                    'value' => function ($data) {
                        $status = AuthAssignment::find()->select('item_name')->where(['user_id' => $data->id])->one();
                        switch ($status->item_name) {
                            case 'RegisteredUnconfirmed':
                                return 'Не подтверждён';
                                break;
                            case 'Registered':
                                return 'Подтверждён';
                                break;
                        }
                    }

                ],
                [
                    'attribute' => 'username',
                    //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    //'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    //'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'username')
                ],
                [
                    'attribute' => 'email',
                   // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                  //  'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                 //   'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'email')
                ],
                [
                    'attribute' => 'phone',
                   // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                   // 'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                   // 'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'phone')
                ],
                [
                    'attribute' => 'phone_2',
                    //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    //'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                   // 'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'phone_2')
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:m:s'],
                   // 'headerOptions' => ['style' => 'width: 215px;'],
                   // 'contentOptions' => ['class' => 'auto-width-col center-align'],
                   // 'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'created_at')
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'contentOptions' => ['class' => 'button-col'],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::button(
                                '<i class="fa fa-trash"></i>',
                                [
                                    'class' => 'btn btn-default mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                    'data-delete_url' => Url::to(['users/delete', 'id' => $model->id]),
                                    'title' => Yii::t('app', 'Delete'),
                                ]
                            );
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="fa fa-edit"></i>',
                                Url::to(['users/update', 'id' => $model->id]),
                                [
                                    'class' => 'btn btn-default mdl-js-button mdl-button--icon mdl-button--colored',
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
        $this->registerJs('componentHandler.upgradeDom();');
        \yii\widgets\Pjax::end();
        ?>
    </div>
</div>
</div>

