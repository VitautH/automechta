<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use kartik\tabs\TabsX;

$name = Yii::t('app', 'Application data');
$this->title = $name;

$this->registerJs("require(['controllers/appdata/update']);", \yii\web\View::POS_HEAD);

?>
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Настройки</a></li>
                <li><a href="#tab_2" data-toggle="tab">Настройки по кредитам</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php  echo $this->render('_formMainSetting', $_params_);
                    ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <?php  echo  $this->render('_formCreditSetting', $_params_);
                    ?>
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
</div>