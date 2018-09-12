<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\helpers\User as UserHelpers;
use dmstr\widgets\Alert;
use backend\assets\AppAsset;
use backend\models\ReportField;
use backend\models\Tasks;
use backend\models\Employees;
use yii\helpers\ArrayHelper;

$this->title = 'Личный кабинет';
$this->registerJs("require(['controllers/account/setting']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/account/report-form']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/task/add-task']);", \yii\web\View::POS_HEAD);
$this->registerJsFile('/plugins/datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/plugins/datepicker/datepicker3.css');
$this->registerJsFile('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);

$tasks = Tasks::find()->where(['employee_to'=>Yii::$app->user->id])->andWhere(['!=','status',Tasks::DRAFT_STATUS])->orderBy('priority DESC')->addOrderBy('created_at DESC')->asArray()->all();
$tasksCount = count($tasks);
?>
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <?php
                    $avatar = UserHelpers::getAvatar(Yii::$app->user->id, '100px', '100px', '100%', 'profile-user-img img-responsive img-circle');
                    ?>
                    <? if ($avatar == null):

                        $avatar = '<img class="profile-user-img img-responsive img-circle" src="/images/noavatar.png">';

                    endif;
                    ?>
                    <? echo $avatar; ?>


                    <h3 class="profile-username text-center"><?php echo $model->first_name . ' ' . $model->last_name; ?></h3>

                    <p class="text-muted text-center"><?php
                        echo $userRole['name'];
                        ?></p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Личная информация</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#report" data-toggle="tab" aria-expanded="true">Отчёты</a></li>
                    <li class=""><a href="#task" data-toggle="tab" aria-expanded="true">Задачи</a></li>
                    <li class=""><a href="#settings" data-toggle="tab" aria-expanded="true">Настройки</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane  active user-setting" id="report">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-3">
                                <h3 class="box-title">Создать отчёт</h3>
                                </div>
                                <div class="col-md-3">
                                <a href="/reports/report-user">Просмотреть все отчёты</a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <form action="/reports/create" id="report-field-form">
                                    <?php
                                    echo Html::hiddenInput( 'Reports[user_id]', $model->id);
                                    ?>
                                <div class="form-group">
                                    <label>Дата отчёта:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php
                                        echo Html::activeInput('text', $modelReport, 'report_date', ['id' => 'datepicker', 'required' => true, 'class' => 'form-control pull-right']);
                                        ?>
                                    </div>
                                </div>
                                <?php
                            
                                $report_fields = ReportField::find()->where(['role_id' => $userRole['id']])->all();

                                foreach ($report_fields as $report_field):
                                    ?>
                                    <div class="form-group">
                                        <label><?php
                                            echo $report_field->name_field;
                                            ?></label>
                                        <?php
                                        echo Html::activeInput('text', $modelReport,  'report_field[' . $report_field->id . ']', ['required' => true, 'class' => 'form-control']);
                                        ?>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                                <?php
                                $common_report_field = ReportField::find()->where(['id' => 1])->one();
                                ?>
                                <div class="form-group">
                                    <label><?php
                                        echo $common_report_field->name_field;
                                        ?></label>
                                    <?php
                                    echo Html::textarea('Reports[report_field][' . $common_report_field->id . ']', '',['rows' => 3,'class' => 'form-control']);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <input type="submit" id="send-report" class="btn btn-app" value="Сохранить">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane   user-setting" id="task">
                        <div class="row">
                        <div class="col-md-4">
                        <div class="box-header">
                            <h3 class="box-title">Создать задачу</h3>
                        </div>
                        <div class="box-body">
                            <form action="/task/create" id="task-form">
                                <div class="form-group">
                                    <label>Сотруднику *:</label>
                                    <div class="input-group">
                                        <?php
                                        echo Html::activeDropDownList($modelTask,'employee_to',ArrayHelper::map(Employees::getEmployees(),'id',function($model) {
                                            return $model['first_name'].' '.$model['last_name'];
                                        }),['required'=>'required','class'=>'form-control']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Задача (название) *:</label>
                                    <div class="input-group">
                                        <?php
                                        echo Html::activeInput('text',$modelTask,'title',['required'=>'required', 'class'=>'form-control']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Описание задачи:</label>
                                    <div class="input-group">
                                        <?php
                                        echo Html::activeTextarea($modelTask,'description',['placeholder'=>'Введите описание задачи','rows'=>'4','class'=>'form-control']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Приоритет:</label>
                                    <div class="input-group">
                                        <?php
                                        echo Html::activeDropDownList($modelTask,'priority',Tasks::getPriority(),['required'=>'required','class'=>'form-control']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Срок выполнения *:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php
                                        echo Html::activeInput('text', $modelTask, 'execute_date', ['id' => 'execute_date-datepicker', 'required' => true, 'class' => 'form-control pull-right']);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" id="send-report" class="btn btn-app" value="Сохранить">
                                </div>
                            </form>
                        </div>
                        </div>
                            <div class="col-md-8">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body">
<div class="col-md-3">
    <a href="/task/user">Задачи мне</a>
    <?php
    if ($tasksCount >0):
    ?>
    <span style="padding: 2px;" class="label pull-right bg-red"><?php
        echo $tasksCount;
        ?></span>
    <?php
    endif;
    ?>
</div>
                                    <br>
                                    <div class="col-md-3">
                                        <a href="/task">Мои задачи (сотрудникам)</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  user-setting" id="settings">
                        <div class="row">
                            <?= Html::activeHiddenInput($model, 'id') ?>
                            <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
                                <div class="js-dropzone"
                                     data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>">
                                    <div class="dz-default dz-message"><span
                                                class="upload btn m-btn">Выбрать фотографию</span> <span
                                                class="drop">или перетащите изображения для загрзуки сюда</span></div>
                                </div>
                                <div class="hint-upload-photo">
                                    Допускается загрузка 1 фотографии в формате JPG и PNG размером не более 8 МБ.
                                    <br>
                                    Мы не рекомендуем Вам использовать фотошоп, рекламу и чужие
                                    фотографии.
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div id="success"></div>
                        <div class="row">
                            <?= Alert::widget() ?>
                        </div>
                        <?php $formWidget = ActiveForm::begin([
                            'id' => 'account-form',
                            'enableAjaxValidation' => false,

                            'options' => [
                                'class' => 'form-horizontal',
                            ]
                        ]); ?>
                        <div class="form-group">
                            <?= $formWidget->field($model, "username", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                        </div>
                        <div class="form-group">
                            <?= $formWidget->field($model, "email", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                        </div>

                        <div class="form-group">
                            <?= $formWidget->field($model, "first_name", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                        </div>
                        <div class="form-group">
                            <?= $formWidget->field($model, "last_name", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label"
                                   for="user-phone"><?= $model->getAttributeLabel('phone_provider') ?></label>

                            <?= Html::activeDropDownList(
                                $model,
                                'phone_provider',
                                User::getPhoneProviders(),
                                ['class' => 'm-select']) ?>
                        </div>
                        <div class="form-group">
                            <?= $formWidget->field($model, "phone", ['options' => ['class' => 'b-submit__main-element']])
                                ->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Сохранить</button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>