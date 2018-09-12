<?php

use yii\widgets\ListView;
use common\models\Product;
use common\models\AppData;
use frontend\models\ProductSearchForm;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $productSpecifications common\models\ProductSpecification[] */

$this->registerJs("require(['controllers/catalog/create']);", \yii\web\View::POS_HEAD);
$this->registerCssFile('/css/style.css');
AppAsset::register($this);
$productModel = new Product();
$appData = AppData::getData();
$this->title = Yii::t('app', 'ADD YOUR VEHICLE');
?>
<?php if ($form->step == 1): ?>
    <?= $this->render('_create_step_1', $stepParams) ?>
<?php endif; ?>
<?php if ($form->step == 2): ?>

    <? //= Alert::widget() ?>


    <?php
    $stepParams = $_params_;

    ?>
    <?= $this->render('_create_step_2', $stepParams) ?>
<?php endif; ?>
