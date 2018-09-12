<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use common\models\Uploads;

$this->registerJs("require(['controllers/mailing-lists/create']);", \yii\web\View::POS_HEAD);
$name = Yii::t('app', 'Изменить рассылку');
$this->title = $name;
?>
    <div class="mdl-grid page-header mdl-shadow--2dp">
        <div class="mdl-cell mdl-cell--12-col">
            <?= Breadcrumbs::widget([
                'links' => Yii::$app->menu->getBreadcrumbs()
            ]) ?>
            <h2><?= $name ?></h2>
        </div>
    </div>
<?= $this->render('_form', $_params_) ?>