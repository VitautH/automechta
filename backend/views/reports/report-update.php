<?php

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use backend\models\Report;
use backend\models\ReportField;
use backend\assets\AppAsset;
use dmstr\web\AdminLteAsset;

$this->registerJsFile('/plugins/datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/plugins/datepicker/datepicker3.css');
$this->registerJsFile('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
$this->registerJs("require(['controllers/report/reports-user']);", \yii\web\View::POS_HEAD);
AppAsset::register($this);
AdminLteAsset::register($this);

$name = 'Редактировать отчёт';
$currentLang = Yii::$app->language;
$this->title = $name;

?>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-4">
            <form action="/reports/report-update" id="report-update-form">
                <div class="box-header">
                    <div class="row">
                        <h3 class="box-title">Редактировать отчёт за <?php
                            echo date('d-m-Y', $model['report_date']);
                            ?></h3>
                    </div>
                </div>
                <?php
                echo Html::hiddenInput( 'Reports[id]', $model['report_id']);
                ?>
                <?php
                foreach ($model['reports'] as $report):
                    ?>
                    <?php
                    switch ($report['report_type_field']) {
                        case "input":
                            ?>
                            <div class="form-group">
                                <label><?php
                                    echo $report['report_field_name'];
                                    ?></label>
                                <?php
                                echo Html::textInput('Reports[report_field][' . $report['report_field_id'] . ']', $report['report'], ['required' => true, 'class' => 'form-control']);
                                ?>
                            </div>
                            <?php
                            break;
                        case "textarea":
                            ?>

                            <div class="form-group">
                                <label><?php
                                    echo $report['report_field_name'];
                                    ?></label>
                                <?php
                                echo Html::textarea('Reports[report_field][' . $report['report_field_id'] . ']', $report['report'], ['rows' => 3, 'class' => 'form-control']);
                                ?>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                <?php
                endforeach;
                ?>
                <div class="form-group">
                    <input type="submit" id="send-report" class="btn btn-app" value="Сохранить">
                </div>
            </form>
        </div>
    </div>
</div>
