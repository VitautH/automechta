<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use common\models\Uploads;
$name = Yii::t('app', 'Update product');
$this->title = $name;

$this->registerJs("require(['controllers/product/create']);", \yii\web\View::POS_HEAD);
?>

<?= $this->render('_form', $_params_) ?>

