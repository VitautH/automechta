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

$name = 'Отчёты пользователя';
$currentLang = Yii::$app->language;
$this->title = $name;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <span><?= Yii::$app->session->getFlash('success') ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <?=
            GridView::widget([
                'id' => 'report-user_grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'role' => 'grid',
                    'class' => 'table table-bordered table-striped dataTable mdl-js-data-table'
                ],
                'rowOptions' => ['role' => 'row', 'class' => 'odd'],
                'columns' => [
                    [
                        'label' => 'Дата отчёта',
                        'value' => function ($model, $key, $index, $column) {
                            return date('d-m-Y', $model->report_date);
                        },
                        'filter' => Html::activeInput('text', $searchModel, 'report_date', ['id' => 'datepicker'])
                    ],
                    [
                        'label' => 'Значения',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $column) {
                            $reports = Report::find()->where(['report_id' => $model->id])->all();
                            $html = '<ol>';
                            foreach ($reports as $report) {
                                $html .= '<li>' . ReportField::findOne($report->report_field)->name_field . ': ' . $report->report . '</li>';
                            }
                            $html .= '</ol>';

                            return $html;

                        },
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'contentOptions' => ['class' => 'button-col'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fa fa-edit"></i>',
                                    Url::to(['reports/report-update', 'id' => $model->id]),
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
        </div>
    </div>
</div>
