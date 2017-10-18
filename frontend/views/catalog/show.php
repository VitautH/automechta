<?php
use common\models\Product;
use common\models\Specification;
use common\models\ProductType;
use common\models\ProductMake;
use common\models\AppData;
use common\models\User;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\ContactForm;
use common\widgets\Alert;
use yii\captcha\Captcha;
use common\models\MetaData;
use yii\widgets\Pjax;
use common\models\Complaint;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model Product */
/* @var $provider yii\data\ActiveDataProvider */

$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);

$this->registerJs("require(['controllers/catalog/show']);", \yii\web\View::POS_HEAD);
$this->registerCssFile("@web/css/jquery.fancybox.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$this->registerJsFile("//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js");
$this->registerJsFile(
    '@web/js/jquery.fancybox.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$appData = AppData::getData();
$uploads = $model->getUploads();
$similarProducts = Product::find()
    ->active()
    ->orderBy('RAND()')
    ->where('make=:make or (year>:year_from and year<:year_to)', [':make' => $model->make, 'year_from' => ($model->year - 1), 'year_to' => ($model->year + 1)])
    ->limit(4)->all();

$this->title = Yii::t('app', 'Catalog') . ' | ' . $model->getFullTitle();
$contactForm = new ContactForm();
$contactForm->id = $model->id;
$seller = User::findOne($model->created_by);

if (empty($model->phone)) {
    $phone = $seller->phone;
    $phone_provider = $seller->phone_provider;
} else {
    $phone = $model->phone;
    $phone_provider = $model->phone_provider;
}

if (empty($model->phone_2)) {
    $phone_2 = $seller->phone_2;
    $phone_provider_2 = $seller->phone_provider_2;
} else {
    $phone_2 = $model->phone_2;
    $phone_provider_2 = $model->phone_provider_2;
}

if (empty($model->first_name)) {
    $first_name = $seller->first_name;
} else {
    $first_name = $model->first_name;
}
if (empty($model->region)) {
    $region = $seller->region;
} else {
    $region = $model->region;
}


$productSpecifications = $model->getSpecifications();

$productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
    $specification = $productSpec->getSpecification()->one();
    return $specification->type != Specification::TYPE_BOOLEAN;
});
$productSpecificationsMain = array_values($productSpecificationsMain);

$productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
    $specification = $productSpec->getSpecification()->one();
    return $specification->type == Specification::TYPE_BOOLEAN;
});
$productSpecificationsAdditional = array_values($productSpecificationsAdditional);


foreach ($productSpecificationsAdditional as $key => $productSpecification) {
    $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
}

$metaData = MetaData::getModels($model);

$this->registerMetaData($metaData);

$productMakeId = ProductMake::find()->where(['and', ['depth' => 2], ['name' => $model->model], ['product_type' => $model->type]])->one()->id;

?>
<section class="b-pageHeader"
         style="background: url(<?= $appData['headerBackground']->getAbsoluteUrl() ?>) center;">
    <div class="container">
        <h1 class="wow zoomInLeft" data-wow-delay="0.5s"> <?= $model->getFullTitle() ?></h1>
    </div>
</section><!--b-pageHeader-->
<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => ProductType::getTypesAsArray()[$model->type],
                'url' => '/brand/' . $model->type
            ],
            [
                'label' => $model->getMake0()->one()->name,
                'url' => '/brand/' . $model->type . '/' . $model->getMake0()->one()->name
            ],
            [
                'label' => $model->model,
                'url' => '/brand/' . $model->type . '/' . $model->getMake0()->one()->name . '/' . $productMakeId
            ],
            $model->getFullTitle()
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<div class="b-infoBar">
    <div class="container">
        <div class="row wow zoomInUp" data-wow-delay="0.5s">
            <div class="col-md-7">
                <span class="b-product-info"><span>№</span> : <?= $model->id ?></span>
                <span class="b-product-info"><span><?= Yii::t('app', 'Published') ?></span> : <?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                <span class="b-product-info"><span><?= Yii::t('app', 'Updated') ?></span> : <?= Yii::$app->formatter->asDate($model->updated_at) ?></span>
                <span class="b-product-info"><span
                            class="fa fa-eye"></span> <?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $model->views]) ?></span>
            </div>
            <div class="col-md-3 col-md-offset-2">
                <?php Pjax::begin(['enablePushState' => false]); ?>
                <span class="complaint" id="complaint_to">Пожаловаться на объявление</span>
                <div id="complaint_block">
                    <?= Html::beginForm(['/catalog/complaint'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
                    <?
                    $modelComplain = new Product();
                    $modelComplain->setScenario(Product::SCENARIO_COMPLAIN);
                    ?>
                    <?= Html::hiddenInput('id', $model->id) ?>
                    <?= Html::dropDownList('complaint_type', Complaint::$type_comlaint, Complaint::$type_comlaint) ?>
                    <?= Html::textarea('complaint_text', '', ['rows' => '6', 'placeholder' => 'Введите текст жалобы']) ?>
                    <?= Html::submitButton('Отправить', ['class' => 'btn m-btn m-btn-dark']) ?>
                    <?= Html::endForm() ?>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
</div><!--b-infoBar-->

<section class="b-detail s-shadow">
    <div class="container">
        <header class="b-detail__head s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
            <div class="row">
                <div class="col-xs-12">
                    <?= Alert::widget() ?>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <div class="b-detail__head-title">
                        <h1><?= $model->getMake0()->one()->name ?> <?= $model->model ?>, <?= $model->year ?></h1>
                        <h3><?= $model->i18n()->title ?></h3>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="b-detail__head-price">
                        <div class="b-detail__head-price-num">
                            <?php if ($model->exchange): ?>
                                <span class="b-detail__head-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                            <?php endif; ?>
                            <?php if ($model->auction): ?>
                                <span class="b-detail__head-auction"><?= Yii::t('app', 'Auction') ?></span>
                            <?php endif; ?>
                            <?= Yii::$app->formatter->asDecimal($model->getByrPrice()) ?> BYN<br>
                            <span class="b-detail__head-price-num-usd"><?= Yii::$app->formatter->asDecimal($model->getUsdPrice()) ?></span>
                        </div>
                        <div class="b-detail__head-auction-exchange">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="b-detail__main">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <div class="b-detail__main-info">
                        <div class="b-detail__main-info-images wow zoomInUp" data-wow-delay="0.5s">
                            <div class="row m-smallPadding">
                                <div class="col-xs-12">
                                    <ul  class="gallery b-detail__main-info-images-big bxslider enable-bx-slider"
                                        data-pager-custom="#bx-pager" data-mode="horizontal" data-pager-slide="true"
                                        data-mode-pager="vertical" data-pager-qty="5">
                                        <?php foreach ($uploads as $upload): ?>
                                            <li class="s-relative">
                                                <a data-fancybox="gallery" href="<?= $upload->getImage() ?>" data-fancybox
                                                   data-caption="<?= $model->i18n()->title ?>">
                                                    <div class="zoom"><span class="glyphicon glyphicon-zoom-in" style="
    color: #e0e24e;
    text-align: center;
    display: block;
    font-size: 30px;
"></span></div>   <img src="<?= $upload->getThumbnail(770, 420) ?>"
                                                         alt="<?= $model->i18n()->title ?>"/>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="col-xs-12 pagerSlider pagerVertical">
                                    <div class="b-detail__main-info-images-small" id="bx-pager">
                                        <?php foreach ($uploads as $key => $upload): ?>
                                            <a href="#" data-slide-index="<?= $key ?>"
                                               class="b-detail__main-info-images-small-one">
                                                <img class="img-responsive"
                                                     src="<?= $upload->getThumbnail(115, 85) ?>"
                                                     alt="<?= $model->i18n()->title ?>"/>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wow zoomInUp b-detail__main-aside-desc hidden-md hidden-lg"
                             data-wow-delay="0.5s">
                            <?= $this->render('_productDescription', ['model' => $model, 'productSpecificationsMain' => $productSpecificationsMain]) ?>
                        </div>
                        <div class="wow zoomInUp b-detail__main-aside-desc hidden-md hidden-lg"
                             data-wow-delay="0.5s">
                            <?= $this->render('_sellerData', ['phone' => $phone, 'phone_provider' => $phone_provider, 'phone_2' => $phone_2, 'phone_provider_2' => $phone_provider_2, 'first_name' => $first_name, 'region' => $region]) ?>
                        </div>
                        <div class="b-detail__main-info-text wow zoomInUp" data-wow-delay="0.5s">
                            <div class="b-detail__main-aside-about-form-links">
                                <a href="#" class="j-tab m-active s-lineDownCenter"
                                   data-to='#info1'><?= Yii::t('app', 'Seller comments') ?></a>
                                <a href="#" class="j-tab s-lineDownCenter"
                                   data-to='#info2'><?= Yii::t('app', 'All about credit') ?></a>
                            </div>
                            <div id="info1">
                                <?= Html::encode($model->i18n()->seller_comments) ?>
                            </div>
                            <div id="info2">
                                <?= $appData['allAboutCredit'] ?>
                            </div>
                        </div>
                        <div class="b-detail__main-info-extra wow zoomInUp" data-wow-delay="0.5s">
                            <h2 class="s-titleDet"><?= Yii::t('app', 'Additional specifications') ?></h2>
                            <div class="row">
                                <?php foreach ($productSpecificationsAdditionalCols as $productSpecificationsAdditionalCol): ?>
                                    <div class="col-xs-4">
                                        <ul>
                                            <?php foreach ($productSpecificationsAdditionalCol as $productSpecificationsAdditional): ?>
                                                <?php $spec = $productSpecificationsAdditional->getSpecification()->one(); ?>
                                                <li>
                                                    <span class="fa <?= $productSpecificationsAdditional->value == '1' ? 'fa-check' : 'fa-close' ?>"></span><?= $spec->i18n()->name ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <aside class="b-detail__main-aside">
                        <div class="b-detail__main-aside-desc wow zoomInUp hidden-sm hidden-xs"
                             data-wow-delay="0.5s">
                            <?= $this->render('_productDescription', ['model' => $model, 'productSpecificationsMain' => $productSpecificationsMain]) ?>
                        </div>
                        <?php if ($model->priority != 1): ?>
                            <div class="b-detail__main-aside-about wow zoomInUp hidden-sm hidden-xs"
                                 data-wow-delay="0.5s">
                                <?= $this->render('_sellerData', ['phone' => $phone, 'phone_provider' => $phone_provider, 'phone_2' => $phone_2, 'phone_provider_2' => $phone_provider_2, 'first_name' => $first_name, 'region' => $region]) ?>
                            </div>
                        <?php endif ?>
                        <div class="b-detail__main-aside-about wow zoomInUp" data-wow-delay="0.5s">
                            <h2 class="s-titleDet"><?= Yii::t('app', 'ASK A QUESTION ABOUT THIS VEHICLE') ?></h2>
                            <div class="b-detail__main-aside-about-call">
                                <span class="fa fa-phone"></span>
                                <div><a href="tel:<?= $appData['phone'] ?>"><?= $appData['phone'] ?></a></div>
                                <p>Пн-Вс : 10:00 - 18:00 Без выходных</p>
                            </div>
                            <div class="b-items__aside-sell wow zoomInUp" data-wow-delay="0.3s">
                                <div class="b-items__aside-sell-img">
                                    <h3><?= Yii::t('app', 'Online credit application') ?></h3>
                                </div>
                                <div class="b-items__aside-sell-info">
                                    <p>
                                        <?= Yii::t('app', 'You can fill out an application for a loan on our website. The application will be considered employees of the company in the shortest time.') ?>
                                    </p>
                                    <a href="/tools/credit-application"
                                       class="btn m-btn btn-credit"><?= Yii::t('app', 'Fill application') ?><span
                                                class="fa fa-angle-right"></span></a>
                                </div>
                            </div>
                            <div class="b-detail__main-aside-payment wow zoomInUp" data-wow-delay="0.5s">
                                <h2 class="s-titleDet"><?= Yii::t('app', 'CAR PAYMENT CALCULATOR') ?></h2>
                                <div class="b-detail__main-aside-payment-form">
                                    <div class="calculator-loan" style="display: none;"></div>
                                    <form action="/" method="post" class="js-loan">
                                        <label><?= Yii::t('app', 'ENTER LOAN AMOUNT') ?></label>
                                        <input type="text" placeholder="<?= Yii::t('app', 'LOAN AMOUNT') ?>"
                                               value="<?= $model->getByrPrice() ?>" name="price"/>
                                        <label><?= Yii::t('app', 'RATE IN') ?> %</label>
                                        <input type="text" placeholder="<?= Yii::t('app', 'RATE IN') ?> %"
                                               value="<?= $appData['loanRate'] ?>%" name="rate"
                                               disabled="disabled"/>
                                        <label><?= Yii::t('app', 'LOAN TERM') ?></label>
                                        <div class="s-relative">
                                            <select name="term" class="m-select">
                                                <option value="6m"><?= Yii::t('app', '6 month') ?></option>
                                                <option value="12m"><?= Yii::t('app', 'One year') ?></option>
                                                <option value="24m"><?= Yii::t('app', '2 years') ?></option>
                                                <option value="36m"><?= Yii::t('app', '3 years') ?></option>
                                                <option value="48m"><?= Yii::t('app', '4 years') ?></option>
                                                <option value="60m"
                                                        selected><?= Yii::t('app', '5 years') ?></option>
                                            </select>
                                            <span class="fa fa-caret-down"></span>
                                        </div>
                                        <button type="submit"
                                                class="btn m-btn"><?= Yii::t('app', 'ESTIMATE PAYMENT') ?>
                                            <span class="fa fa-angle-right"></span></button>
                                    </form>
                                </div>
                                <div class="b-detail__main-aside-about-call js-loan-results">
                                    <span class="fa fa-calculator"></span>
                                    <div><span class="js-per-month"></span> BYN
                                        <p><?= Yii::t('app', 'PER MONTH') ?></p>
                                    </div>
                                    <p>&nbsp;</p>
                                    <!--<p><?= Yii::t('app', 'Total Payments') ?>: <span class="js-total-payments"></span></p>-->
                                </div>
                            </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section><!--b-detail-->
<?php if (!empty($similarProducts)): ?>
    <section class="b-related m-home">
        <div class="container">
            <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'RELATED VEHICLES ON SALE') ?></h2>
            <div class="row">
                <?php foreach ($similarProducts as $similarProduct): ?>
                    <?php $priorityHighestSpecs = $similarProduct->getSpecifications(Specification::PRIORITY_HIGHEST); ?>
                    <div class="col-md-3 col-xs-6 similar-product">
                        <div class="b-auto__main-item wow zoomInLeft" data-wow-delay="0.5s">
                            <a href="<?= $similarProduct->getUrl() ?>">
                                <img class="hover-light-img" src="<?= $similarProduct->getTitleImageUrl(270, 180) ?>"
                                     alt="<?= Html::encode($similarProduct->i18n()->title) ?>"/>
                            </a>
                            <!--<div class="b-world__item-val">
                                <span class="b-world__item-val-title"><?= Yii::t('app', 'Published') ?> : <?= Yii::$app->formatter->asDate($similarProduct->created_at) ?></span>
                            </div>-->
                            <h2>
                                <a href="<?= $similarProduct->getUrl() ?>"><?= Html::encode($similarProduct->getFullTitle()) ?></a>
                            </h2>
                            <div class="b-auto__main-item-info">
                                <span class="m-price">
                                    <?= Yii::$app->formatter->asDecimal($similarProduct->getByrPrice()) ?> BYN
                                    <span class="m-price-usd">(<?= Yii::$app->formatter->asDecimal($similarProduct->getUsdPrice()) ?>
                                        )</span>
                                </span>
                                <?php if (count($priorityHighestSpecs) > 0): ?>
                                    <?php foreach ($priorityHighestSpecs as $productSpec): ?>
                                        <?php $spec = $productSpec->getSpecification()->one(); ?>
                                        <span class="m-number">
                                        <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>"/>
                                            <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                    </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="m-number">&nbsp;
                                    </span>
                                <?php endif; ?>
                                <div class="b-featured__item-links m-auto">
                                    <?php foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                        <?php $spec = $productSpec->getSpecification()->one(); ?>
                                        <a title="<?= $spec->i18n()->name ?>"
                                           href="#"><?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section><!--"b-related-->
<?php endif; ?>