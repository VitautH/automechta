<?

use common\helpers\Url;
use yii\grid\GridView;
use common\models\AuthItem;
use yii\helpers\Html;

$this->title = 'Поля отчётов';
$this->registerJs("require(['controllers/report-field/index']);", \yii\web\View::POS_HEAD);
?>
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Поля</h3>
            <a class="btn btn-app" href="<?= Url::to(['report-field/create']) ?>">
                <i class="fa fa-plus"></i> Добавить
            </a>
        </div>
        <div class="box-body">
            <?php \yii\widgets\Pjax::begin([
                'id' => 'report-field_grid_wrapper',
                'linkSelector' => '#report-field_grid_wrapper a:not(.button-col a)'
            ]); ?>

            <?=
            GridView::widget([
                'id' => 'report-field_grid',
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
                        'attribute' => 'role_id',
                        'label' => 'Роль',
                        'value' => function ($model, $key, $index, $column) {
                            if ($model->role_id == 39) {
                                $role = 'Общее поле';
                            } else {
                                $role = Yii::t('app', AuthItem::find()->where(['id' => $model->role_id])->one()->name);
                            }

                            return $role;
                        },
                    ],

                    [
                        'label' => 'Имя поля',
                        'attribute' => 'name_field',
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
                                        'class' => 'btn btn-default  mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                        'data-delete_url' => Url::to(['report-field/delete', 'id' => $model->id]),
                                        'title' => Yii::t('app', 'Delete'),
                                    ]
                                );
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fa fa-edit"></i>',
                                    Url::to(['report-field/update', 'id' => $model->id]),
                                    [
                                        'class' => 'btn btn-default  mdl-js-button mdl-button--icon mdl-button--colored',
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
</section>
