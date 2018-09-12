<?php

use backend\models\Tasks;
use common\models\User;

$this->title = 'Задача';
$this->registerJs("require(['controllers/task/user-task']);", \yii\web\View::POS_HEAD);

?>
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
                        <th>Поставлена</th>
                        <th>Исполнить до</th>
                        <th>Действия</th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if ($task->priority == Tasks::HIGH_PRIORITY):
                                ?>
                                <i class="icon fa fa-warning" style="color: red;font-size: 18px;margin-right: 5px;"></i>
                                <span>
                                    Срочно выполнить
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
                            <b>Описание задачи: </b>  <?php
                            echo $task->description;
                            ?>
                            <br>
                            <b>Исправить:</b>
                            <?php
                            echo $task->comment;
                            ?>
                        </td>
                        <td>
                            От <?php
                            $user = User::findOne($task->created_by);
                            echo $user->first_name . ' ' . $user->last_name;
                            ?>
                            (<?php
                            echo date('d-m-Y', $task->created_at);
                            ?>)
                        </td>
                        <td>
                            Исполнить до
                            <?php
                            echo date('d-m-Y', $task->execute_date);
                            ?>
                        </td>
                        <td id="task-<?php echo $task->id;?>-action" class="action">
                            <?php
                            switch ($task->status) {
                                case Tasks::OPEN_STATUS:
                                    echo '<a href="#" data-url="/task/change-status?task=' . $task->id . '&status='.Tasks::DURING_STATUS.'" class="task-action open-task btn btn-app">
                <i class="fa fa-play"></i> Выполнять
              </a>';
                                    break;

                                case Tasks::DURING_STATUS:
                                    echo '<a href="#"  data-url="/task/change-status?task=' . $task->id . '&status='.Tasks::EXECUTED_STATUS.'" class="task-action during-task btn btn-app">
                <i class="fa fa-save"></i> Завершить
              </a>';
                                    break;

                                case Tasks::EXECUTED_STATUS:
                                    echo '<span>Выполнена. Ожидает проверки</span>';
                                    break;

                                case Tasks::VEREFIED_STATUS:
                                    echo '<span>Проверяется</span>';
                                    break;

                                case Tasks::CLOSED_STATUS:
                                    echo '<span>Выполнена. Задача закрыта</span>';
                                    break;
                                case Tasks::DECLINE_STATUS:
                                    echo '<span>На доработке</span><br><a href="#" data-status="'.Tasks::DURING_STATUS.'" data-url="/task/change-status?task=' . $task->id . '&status='.Tasks::DURING_STATUS.'" class="task-action open-task btn btn-app">
                <i class="fa fa-play"></i> Выполнять
              </a>';
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
