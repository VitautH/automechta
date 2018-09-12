<?php

use yii\helpers\Html;
use common\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Menu as MenuModel;
use common\models\AppData;
use yii\widgets\Menu;
use common\models\Product;
use common\models\Specification;
use common\models\Page;
use common\models\User;
use common\helpers\User as UserHelpers;

?>
 <?= $this->render('_new-header'); ?>
    <?= $content ?>
    <?= $this->render('_new-footer'); ?>