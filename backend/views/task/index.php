<?php

use backend\models\Tasks;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Задачи по сотрудникам';
$this->registerJs("require(['controllers/task/own-task']);", \yii\web\View::POS_HEAD);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Задачи по сотрудникам
                </h3>
            </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'priority',
                        'label' => 'Приоритет',
                        'contentOptions' => ['class' => 'auto-width-col center-align'],
                        'headerOptions' => ['style' => 'width: 70px;'],
                        'format' => 'html',
                        'value' => function ($model) {
                            switch ($model->priority) {
                                case Tasks::HIGH_PRIORITY:
                                    return Html::tag('span', 'Высокий приоритет');
                                    break;
                                case Tasks::LOW_PRIORITY:
                                    return Html::tag('span', 'Низкий приоритет');
                                    break;

                            }
                        }
                    ],
                    [
                        'attribute' => 'Задача',
                        'contentOptions' => ['class' => 'auto-width-col center-align'],
                        'headerOptions' => ['style' => 'width: 70px;'],
                        'format' => 'html',
                        'value' => function ($model) {
                            $content = $model->title . '<br>
                            <b>Описание задачи: </b>' . $model->description . '
                            <br>
                            <b>Исправить:</b>
                            ' . $model->comment . '';

                            return $content;
                        }
                    ],
                    [
                        'attribute' => 'Исполнитель',
                        'contentOptions' => ['class' => 'auto-width-col center-align'],
                        'headerOptions' => ['style' => 'width: 70px;'],
                        'format' => 'html',
                        'value' => function ($model) {

                            $user = User::findOne($model->employee_to);
                            $result = $user->first_name . ' ' . $user->last_name . ',<br> выполнить до (' . date('d-m-Y', $model->execute_date) . ')';

                            return $result;
                        }
                    ],
                    [
                        'attribute' => 'Постановщик',
                        'contentOptions' => ['class' => 'auto-width-col center-align'],
                        'headerOptions' => ['style' => 'width: 70px;'],
                        'format' => 'html',
                        'value' => function ($model) {

                            $user = User::findOne($model->created_by);
                            $result = $user->first_name . ' ' . $user->last_name . ',<br> поставлена  (' . date('d-m-Y', $model->created_at) . ')';

                            return $result;
                        }
                    ],
                    [
                        'attribute' => 'Статус',
                        'contentOptions' => ['class' => 'auto-width-col center-align'],
                        'headerOptions' => ['style' => 'width: 70px;'],
                        'format' => 'html',
                        'value' => function ($model) {
                            $date = date('d-m-Y', $model->updated_at);
                            switch ($model->status) {
                                case Tasks::OPEN_STATUS:
                                    $result = '<span>Открыта <br>(' . $date . ')</span>';
                                    break;

                                case Tasks::DURING_STATUS:
                                    $result = '<span>Выполняется <br> (' . $date . ')</span>';
                                    break;

                                case Tasks::EXECUTED_STATUS:
                                    $result = '<span>Выполнена <br> (' . $date . ')</span>';
                                    break;
                                case Tasks::DECLINE_STATUS:
                                    $result = '<span>Отклонена (на доработке) <br>(' . $date . ')</span>';
                                    break;

                                case Tasks::VEREFIED_STATUS:
                                    $result = '<span>Проверяется <br>(' . $date . ')</span>';
                                    break;

                                case Tasks::CLOSED_STATUS:
                                    $result = '<span>Задача закрыта (одобрена) <br>(' . $date . ')</span>';
                                    break;
                            }

                            return $result;
                        }
                    ],

                ],
            ]); ?>

            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
        </div>
    </div>
</div>