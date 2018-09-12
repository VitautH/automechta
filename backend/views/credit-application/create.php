<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 24.02.2018
 * Time: 21:48
 */

/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;

$this->registerJs("require(['controllers/tools/creditApplication']);", \yii\web\View::POS_HEAD);
$name = Yii::t('app', 'Создать заявку на кредит');
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