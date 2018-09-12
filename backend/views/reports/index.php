<?

use common\helpers\Url;
use yii\grid\GridView;
use common\models\AuthItem;
use yii\helpers\Html;
use common\models\User;
use backend\assets\AppAsset;
use yii\helpers\ArrayHelper;

$this->title = 'Отчёты';
$this->registerJs("require(['controllers/report/index']);", \yii\web\View::POS_HEAD);
$this->registerJsFile('/plugins/datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/plugins/datepicker/datepicker3.css');
$this->registerJsFile('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);
?>
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Отчёты за <?php echo date('d-m-Y'); ?></h3>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($currentReports as $currentReport):
            $user = User::findOne($currentReport["user"]['user_id']);
            ?>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Задача</th>
                                <th>Значение</th>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($currentReport["user"]['tasks'] as $task):
                                if ($task['report_field'] !== null):
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?>.</td>
                                        <td><?php
                                            echo $task ['report_field'];
                                            ?></td>
                                        <td><?php
                                            echo $task ['report'];
                                            ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                endif;
                            endforeach;

                            foreach ($currentReport["user"]['tasks']['additional_task'] as $task):
                                ?>
                                <tr>
                                    <td><a href="/task/own-task?id=<?php echo $task ['id'];?>">Перейти к задаче</a></td>
                                    <td><?php
                                        echo $task ['report_field'];
                                        ?></td>
                                    <td><?php
                                        echo $task ['report'];
                                        ?></td>
                                </tr>
                                <?php
                                $i++;
                            endforeach;
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Выгрузить отчёт</h3>
        </div>
        <div class="box-body">
            <form action="/reports/search" id="report-search-form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Дата отчёта:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php
                                echo Html::activeInput('text', $modelSearchReport, 'report_date', ['id' => 'datepicker', 'required' => true, 'class' => 'form-control pull-right']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Сотрудник:</label>
                            <?php
                            echo Html::activeDropDownList($modelSearchReport, 'user_id', ArrayHelper::map($employees, 'id', 'name'), ['required' => true, 'class' => 'form-control']);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="submit" id="get-report" class="btn btn-app" value="Выгрузить">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row" id="report">

    </div>
</section>
