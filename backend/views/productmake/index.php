<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$name = Yii::t('app', 'Menu');
$this->title = $name;
$this->registerJs("require(['controllers/productmake/index']);", \yii\web\View::POS_HEAD);

?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2><?= $name ?></h2>
        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--colored page-header__fab" href="<?= Url::to(['productmake/create']) ?>">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-shadow--2dp">
        <div class="js-tree">

        </div>
    </div>
</div>

