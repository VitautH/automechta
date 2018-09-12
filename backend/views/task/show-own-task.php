<?php

use backend\models\Tasks;
use common\models\User;
use yii\helpers\Html;

$this->title = 'Задача';
$this->registerJs("require(['controllers/task/own-task']);", \yii\web\View::POS_HEAD);

?>
<div class="modal-block">
    <div class="header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="body">
        <form id="decline-task-form" role="form" action="/task/check-task">
            <?php
            echo Html::input('hidden','id', $task->id);
            echo Html::input('hidden','employee_to', $task->employee_to);
            echo Html::input('hidden', 'status',Tasks::DECLINE_STATUS);
            ?>
            <div class="form-group">
                <label>Причина отклонения (на доработку) задания</label>
                <?php
                echo Html::textarea('comment','',['class'=>'form-control','placeholder'=>'Введите причину отклонения задания ...','rows'=>5,'required'=>'required']);
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Отклонить</button>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Задача № <?php
                    echo $task->id;
                    ?>
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th style="width: 30px">Приоритет</th>
                        <th>Задача</th>
                        <th>Исполнитель</th>
                        <th>Срок исполнения</th>
                        <th>Статус</th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if ($task->priority == Tasks::HIGH_PRIORITY):
                                ?>
                                <span>
                                   Высокий приоритет
                                </span>
                            <?php
                            endif;
                            ?>
                            <?php
                            if ($task->priority == Tasks::LOW_PRIORITY):
                                ?>
                                <span>
                                   Низкий приоритет
                                </span>
                            <?php
                            endif;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $task->title;
                            ?>
                            <br>
                            <?php
                            echo $task->description;
                            ?>
                        </td>
                        <td>
                           Кому: <?php
                            $user = User::findOne($task->created_by);
                            echo $user->first_name . ' ' . $user->last_name;
                            ?>
                            <br>
                         Создана:   (<?php
                            echo date('d-m-Y', $task->created_at);
                            ?>)
                        </td>
                        <td>
                           Выполнить до
                            <?php
                            echo date('d-m-Y', $task->execute_date);
                            ?>
                        </td>
                        <td id="task-<?php echo $task->id;?>-action" class="action">
                            <?php
                            switch ($task->status) {
                                case Tasks::OPEN_STATUS:
                                    echo '<span>Открыта</span>';
                                    break;

                                case Tasks::DURING_STATUS:
                                    echo '<span>Выполняется</span>';
                                    break;

                                case Tasks::EXECUTED_STATUS:
                                    echo '<span>Выполнена</span>
<br>
<div  class="action">
<a  id="approve-task" class="btn btn-app" data-employee_to = "'.$task->employee_to.'" data-action="/task/check-task" data-id="'.$task->id.'" data-status="'.Tasks::CLOSED_STATUS.'">
                <i class="fa fa-play"></i> Одобрить
              </a>
              <a id="decline-task" class="btn btn-app">
                <i class="fa fa-close"></i> Отклонить
              </a>
              </div>';
                                    break;
                                case Tasks::DECLINE_STATUS:
                                    echo '<span>Отклонена (на доработке)</span>';
                                    break;

                                case Tasks::VEREFIED_STATUS:
                                    echo '<span>Проверяется</span>';
                                    break;

                                case Tasks::CLOSED_STATUS:
                                    echo '<span>Задача закрыта</span>';
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
        </div>
    </div>
</div>
