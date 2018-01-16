<?php
use yii\widgets\ListView;
use common\models\Product;
use common\models\AppData;
use frontend\models\ProductSearchForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $productSpecifications common\models\ProductSpecification[] */
$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);
$this->registerJs("require(['controllers/catalog/create']);", \yii\web\View::POS_HEAD);
$productModel = new Product();
$appData = AppData::getData();
$this->title = Yii::t('app', 'ADD YOUR VEHICLE');
?>

<section class="b-pageHeader" style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class="wow zoomInLeft" data-wow-delay="0.5s">  Новое объявление</h1>
    </div>
</section><!--b-pageHeader-->

<?php
?>
<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            $this->title
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?= Alert::widget() ?>
            </div>
                    <?php if ($form->step == 1): ?>
                            <?= $this->render('_create_step_1', $stepParams) ?>
                        <?php endif; ?>
                    <?php if ($form->step ==  2): ?>
<!--                        --><?php //$formWidget = ActiveForm::begin([
//                            'id' => 'create_product_form',
//                            'action' =>'create-ads/save?id='.$model->id,
//                            'enableAjaxValidation' => true,
//                            'validationUrl' => Url::to(['create-ads/validate']),
//                            'method' =>  'post',
//                            'options' => ['class' => 'create_ads clearfix'],
//                        ]); ?>
                        <?php
                        $stepParams = $_params_;
                      //  $stepParams['formWidget'] = $formWidget;
                        ?>
                        <?= $this->render('_create_step_2', $stepParams) ?>
<!--                        <button type="submit" id="button_publish" class="btn m-btn pull-right wow zoomInUp" data-wow-delay="0.5s">ОПУБЛИКОВАТЬ<span class="fa fa-angle-right"></span></button>-->
<!--                        --><?php //ActiveForm::end(); ?>
                    <?php endif; ?>
        </div>
    </div>