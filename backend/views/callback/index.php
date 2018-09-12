<?

use common\helpers\Url;
use yii\grid\GridView;
use common\models\AuthItem;
use yii\helpers\Html;
use common\models\Callback;

$this->title = 'Обратный звонок';
$this->registerJs("require(['controllers/callback/index']);", \yii\web\View::POS_HEAD);
?>
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <?php \yii\widgets\Pjax::begin([
                'id' => 'callback_grid_wrapper',
                'linkSelector' => '#callback_grid_wrapper a:not(.button-col a)'
            ]); ?>
            <?=
            GridView::widget([
                'id' => 'callback-field_grid',
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'role' => 'grid',
                    'class' => 'table table-bordered table-striped dataTable mdl-js-data-table'
                ],
                'rowOptions' => ['role' => 'row', 'class' => 'odd'],
                'columns' => [
                    [
                        'attribute' => 'id',
                    ],
                    [
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function ($model) {
                            switch ($model->viewed) {
                                case Callback::VIEWED:
                                    $result = 'Просмотренный';
                                    break;
                                case Callback::NO_VIEWED:
                                    $result = 'Новый';
                                    break;
                            }

                            return $result;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'Имя',
                    ],

                    [
                        'label' => 'Телефон',
                        'attribute' => 'phone',
                    ],
                    [
                        'label' => 'Дата',
                        'attribute' => 'created_at',
                        'value' => function ($model) {
                            $date = date('d-m-Y H:i:s', $model->created_at);
                            return $date;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{delete}',
                        'contentOptions' => ['class' => 'button-col'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                if ($model->viewed == Callback::NO_VIEWED) {
                                    return Html::button(
                                        '<i class="fa  fa-eye"></i>',
                                        [
                                            'class' => 'btn btn-default  mdl-js-button mdl-button--icon mdl-button--accent change-status',
                                            'data-status_url' => Url::to(['callback/status', 'id' => $model->id]),
                                            'title' => Yii::t('app', 'Просмотреть'),
                                        ]
                                    );
                                }
                            },
                             'delete' => function ($url, $model, $key) {
                                return Html::button(
                                    '<i class="fa fa-trash"></i>',
                                    [
                                        'class' => 'btn btn-default  mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                        'data-delete_url' => Url::to(['callback/delete', 'id' => $model->id]),
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
</section>
