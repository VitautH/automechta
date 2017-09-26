<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;

$name = Yii::t('app', 'Update permission');
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
<?= $this->render('_form', ['model' => $model]) ?>

