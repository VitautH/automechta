<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\PageSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \common\helpers\MdlHtml;
use \common\models\CreditApplication;
use yii\widgets\MaskedInput;

$name = Yii::t('app', 'Credit Applications');
$currentLang = Yii::$app->language;
$this->title = $name;
$this->registerJs("require(['controllers/creditApplication/index']);", \yii\web\View::POS_HEAD);
?>
<div class="row">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Заявки на кредит</h3>
            <a class="btn btn-app" href="<?= Url::to(['credit-application/create']) ?>">
                <i class="fa fa-plus"></i> Добавить
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="box">
        <div class="box-body">
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
                    'role' => 'grid',
                    'class' => 'table-responsive table table-bordered table-striped dataTable mdl-js-data-table'
                ],
                'rowOptions' => ['role' => 'row', 'class' => 'odd'],
                'columns' => [
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{delete}{is_arrive}{is_phoned}',
                        'contentOptions' => ['class' => 'button-col'],
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::button(
                                    '<i class="fa fa-trash"></i>',
                                    [
                                        'class' => 'btn btn-default mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                        'data-delete_url' => Url::to(['credit-application/delete', 'id' => $model->id]),
                                        'title' => Yii::t('app', 'Delete'),
                                    ]
                                );
                            },
                            'view' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fa fa-eye"></i>',
                                    Url::to(['credit-application/view', 'id' => $model->id]),
                                    [
                                        'class' => 'btn btn-default mdl-js-button mdl-button--icon mdl-button--colored',
                                        'title' => Yii::t('app', 'Edit'),
                                    ]
                                );
                            },
                            'is_arrive' => function ($url, $model, $key) {
                                if ($model->is_arrive == CreditApplication::ARRIVED) {
                                    return Html::button(
                                        '<i class="fa  fa-check-circle"></i>',
                                        [
                                            'class' => 'btn btn-default mdl-js-button mdl-button--icon  button-arrive status-arrived',
                                            'data-is_arrive' => Url::to(['credit-application/isarrive', 'status'=> CreditApplication::ARRIVED,'id' => $model->id]),
                                            'title' => 'Приехал',
                                        ]);
                                } else {
                                    return Html::button(
                                        '<i class="fa  fa-check-circle"></i>',
                                        [
                                            'class' => 'btn btn-default mdl-js-button mdl-button--icon button-arrive status-no_arrived',
                                            'data-is_arrive' => Url::to(['credit-application/isarrive', 'status'=> CreditApplication::NO_ARRIVED,'id' => $model->id]),
                                            'title' => 'Не приехал',
                                        ]);
                                }
                            },
                             'is_phoned' => function ($url, $model, $key) {
                                if ($model->is_phoned == CreditApplication::PHONED) {
                                    return Html::button(
                                        '<i class="fa  fa-phone"></i>',
                                        [
                                            'class' => 'btn btn-default mdl-js-button mdl-button--icon  button-phone status-phoned',
                                            'data-is_phone' => Url::to(['credit-application/isphone', 'status'=> CreditApplication::PHONED,'id' => $model->id]),
                                            'title' => 'Дозвон',
                                        ]);
                                } else {
                                    return Html::button(
                                        '<i class="fa  fa-phone"></i>',
                                        [
                                            'class' => 'btn btn-default mdl-js-button mdl-button--icon button-phone status-no_phoned',
                                            'data-is_phone' => Url::to(['credit-application/isphone', 'status'=> CreditApplication::NO_PHONED,'id' => $model->id]),
                                            'title' => 'Не дозвон',
                                        ]);
                                }
                            }
                        ]
                    ],
                    [
                        'attribute' => 'name',
                        // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        // 'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, "name")
                    ],
                    [
                        'attribute' => 'lastname',
                        //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        //'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, "lastname")
                    ],
                    [
                        'attribute' => 'firstname',
                        //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        //'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, "firstname")
                    ],
                    [
                        'attribute' => 'phone',
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MaskedInput::widget([
                            'class' => 'mdl-textfield__input',
                            'model' => $searchModel,
                            'name' => 'CreditApplicationSearch[phone]',
                            'mask' => '+375 (99) 999-99-99',
                            'value' => $searchModel->phone
                        ])

                    ],
                    [
                        'attribute' => 'product',
                        // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'contentOptions' => ['style' => 'width:150px;display: block;word-wrap: break-word;padding: 0;font-size: 12px;'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, "product")
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model, $key, $index, $column) {
                            return CreditApplication::getStatuses()[$model->status];
                        },
                        //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        //'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'status', CreditApplication::getStatuses(), ['prompt' => Yii::t('app', 'Any')]),
                    ],
                    [
                        'attribute' => 'date_arrive',
                        'format' => ['date', 'php:Y-m-d H:m:s'],
                        //'headerOptions' => ['style' => 'width: 215px;'],
                        'contentOptions' => ['style' => 'width:120px;display: block;word-wrap: break-word;padding: 0;font-size: 12px;'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('date', $searchModel, 'date_arrive')
                    ],
                    [
                        'attribute' => 'is_arrive',
                        'label' => 'Приехал ?',
                        'value' => function ($model, $key, $index, $column)  {
                            if ($model->is_arrive == CreditApplication::ARRIVED) {
                                return 'Да';
                            } else {
                                return 'Нет';
                            }
                        },
                        // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        // 'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'is_arrive', CreditApplication::getStatusArrive(), ['prompt' => Yii::t('app', 'Any')]),
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:Y-m-d H:m:s'],
                        // 'headerOptions' => ['style' => 'width: 215px;'],
                        //'contentOptions' => ['class' => 'auto-width-col center-align'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'created_at')
                    ],
                ]
            ]);
            ?>
            <?php
            \yii\widgets\Pjax::end();
            ?>
        </div>
    </div>
</div>

