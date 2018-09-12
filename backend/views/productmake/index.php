<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$name = 'Марки';
$this->title = $name;
$this->registerJs("require(['controllers/productmake/index']);", \yii\web\View::POS_HEAD);

?>
<div class="row">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $name;?></h3>
            <a class="btn btn-app" href="<?= Url::to(['productmake/create']) ?>">
                <i class="fa fa-plus"></i> Добавить
            </a>
        </div>
    </div>
</div>
<div class="row">
        <!-- /.box-header -->
        <div class="js-tree">
    </div>
</div>
