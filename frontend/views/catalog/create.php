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
        <h1 class="wow zoomInLeft" data-wow-delay="0.5s"></h1>
        <div class="b-pageHeader__search wow zoomInRight" data-wow-delay="0.5s">
            <h3><?= Yii::t('app', 'Add Your Vehicle In Our Listings') ?></h3>
        </div>
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

<div class="b-submit">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?= Alert::widget() ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                <aside class="b-submit__aside">
                    <div class="b-submit__aside-step <?php if ($form->step == 1): ?>m-active<?php endif; ?> wow zoomInUp" data-wow-delay="0.5s">
                        <h3><?= Yii::t('app', 'Step') ?> 1</h3>
                        <div class="b-submit__aside-step-inner clearfix <?php if ($form->step == 1): ?>m-active<?php endif; ?>">
                            <div class="b-submit__aside-step-inner-icon">
                                <span class="fa fa-car"></span>
                            </div>
                            <div class="b-submit__aside-step-inner-info">
                                <h4><?= Yii::t('app', 'Select type') ?></h4>
                                <p><?= Yii::t('app', 'Select type of your vehicle') ?></p>
                                <?php if ($form->step == 1): ?>
                                <div class="b-submit__aside-step-inner-info-triangle"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($form->step <= 2): ?>
                    <div class="b-submit__aside-step <?php if ($form->step == 2): ?>m-active<?php endif; ?> wow zoomInUp" data-wow-delay="0.5s">
                    <?php endif; ?>
                    <?php if ($form->step >2): ?>
                    <a href="/catalog/update?id=<?= $model->id ?>" class="b-submit__aside-step <?php if ($form->step == 2): ?>m-active<?php endif; ?> wow zoomInUp" data-wow-delay="0.5s">
                    <?php endif; ?>
                        <h3><?= Yii::t('app', 'Step') ?> 2</h3>
                        <div class="b-submit__aside-step-inner clearfix <?php if ($form->step == 2): ?>m-active<?php endif; ?>">
                            <div class="b-submit__aside-step-inner-icon">
                                <span class="fa fa-list-ul"></span>
                            </div>
                            <div class="b-submit__aside-step-inner-info">
                                <h4><?= Yii::t('app', 'Select details') ?></h4>
                                <p><?= Yii::t('app', 'Choose vehicle specifications') ?></p>
                                <?php if ($form->step == 2): ?>
                                    <div class="b-submit__aside-step-inner-info-triangle"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php if ($form->step <= 2): ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($form->step > 2): ?>
                    </a>
                    <?php endif; ?>
                    <?php if ($form->step <= 3): ?>
                    <div class="b-submit__aside-step <?php if ($form->step == 3): ?>m-active<?php endif; ?> wow zoomInUp" data-wow-delay="0.5s">
                    <?php endif; ?>
                    <?php if ($form->step > 3): ?>
                    <a href="/catalog/uploads?id=<?= $model->id ?>" class="b-submit__aside-step <?php if ($form->step == 3): ?>m-active<?php endif; ?> wow zoomInUp" data-wow-delay="0.5s">
                    <?php endif; ?>
                        <h3><?= Yii::t('app', 'Step') ?> 3</h3>
                        <div class="b-submit__aside-step-inner clearfix <?php if ($form->step == 3): ?>m-active<?php endif; ?>">
                            <div class="b-submit__aside-step-inner-icon">
                                <span class="fa fa-photo"></span>
                            </div>
                            <div class="b-submit__aside-step-inner-info">
                                <h4><?= Yii::t('app', 'Photos') ?></h4>
                                <p><?= Yii::t('app', 'Add images of vehicle') ?></p>
                                <?php if ($form->step == 3): ?>
                                    <div class="b-submit__aside-step-inner-info-triangle"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php if ($form->step <= 3): ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($form->step > 3): ?>
                    </a>
                    <?php endif; ?>
                    <div class="b-submit__aside-step <?php if ($form->step == 4): ?>m-active<?php endif; ?> wow zoomInUp" data-wow-delay="0.5s">
                        <h3><?= Yii::t('app', 'Step') ?> 4</h3>
                        <div class="b-submit__aside-step-inner clearfix <?php if ($form->step == 4): ?>m-active<?php endif; ?>">
                            <div class="b-submit__aside-step-inner-icon">
                                <span class="fa fa-user"></span>
                            </div>
                            <div class="b-submit__aside-step-inner-info">
                                <h4><?= Yii::t('app', 'Contact details') ?></h4>
                                <p><?= Yii::t('app', 'Leave your contact details.') ?></p>
                                <?php if ($form->step == 4): ?>
                                    <div class="b-submit__aside-step-inner-info-triangle"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                <div class="b-submit__main">
                    <?php if ($form->step == 1 || $form->step == 2): ?>
                        <?php $formWidget = ActiveForm::begin([
                            'id' => 'create_product_form',
                            'enableAjaxValidation' => true,
                            'validationUrl' => Url::to(['catalog/validate']),
                            'method' => $form->step == 1 ? 'get' : 'post',
                            'options' => ['class' => 's-submit clearfix create-product-form'],
                        ]); ?>
                          <?php
                              $stepParams = $_params_;
                              $stepParams['formWidget'] = $formWidget;
                          ?>
                            <?php if ($form->step == 1): ?>
                                <?= $this->render('_create_step_1', $stepParams) ?>
                            <?php endif; ?>
                            <?php if ($form->step == 2): ?>
                                <?= $this->render('_create_step_2', $stepParams) ?>
                            <?php endif; ?>
                            <button type="submit" class="btn m-btn pull-right wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'Next') ?><span class="fa fa-angle-right"></span></button>
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>


                    <?php if ($form->step == 3): ?>
                        <?php $formWidget = ActiveForm::begin([
                            'id' => 'add_product_photos',
                            'enableAjaxValidation' => true,
                            'options' => ['class' => 's-submit clearfix'],
                        ]); ?>
                        <?php
                        $stepParams = $_params_;
                        $stepParams['formWidget'] = $formWidget;
                        ?>
                        <?= $this->render('_create_step_3', $stepParams) ?>
                        <button type="submit" class="btn m-btn pull-right wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'Next') ?><span class="fa fa-angle-right"></span></button>
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>


                    <?php if ($form->step == 4): ?>
                        <?php $formWidget = ActiveForm::begin([
                            'id' => 'contact_details',
                            'enableAjaxValidation' => true,
                            'options' => ['class' => 's-submit clearfix'],
                        ]); ?>
                        <?php
                        $stepParams = $_params_;
                        $stepParams['formWidget'] = $formWidget;
                        ?>
                        <?= $this->render('_create_step_4', $stepParams) ?>
                        <button type="submit" class="btn m-btn pull-right wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'Next') ?><span class="fa fa-angle-right"></span></button>
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div><!--b-submit-->