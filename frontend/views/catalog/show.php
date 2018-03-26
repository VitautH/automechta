<?php

use common\models\Product;
use common\models\Specification;
use common\models\ProductSpecification;
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
use common\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\City;
use frontend\assets\AppAsset;
use frontend\models\Bookmarks;
use common\models\VideoAuto;

/* @var $this yii\web\View */
/* @var $model Product */
/* @var $provider yii\data\ActiveDataProvider */
//$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);
//$this->registerJsFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');

$this->registerJs("require(['controllers/tools/calculator']);
", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/modal']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/bookmarks']);", \yii\web\View::POS_HEAD);
$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css");
$this->registerCssFile('@web/css/fontawesome-all.min.css');
$this->registerJsFile(
    '@web/js/fotorama.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerCssFile("@web/theme/assets/bxslider/jquery.bxslider.css");

$this->registerJs(" 
   $('.fotorama').fotorama({
        spinner: {
            lines: 13,
            color: 'rgba(0, 0, 0, .75)'
        }
    });
    $(function () {
       $( '#prepayment' ).change(function() {
          var max = parseInt($(this).attr('max'));
          var min = parseInt($(this).attr('min'));
          if ($(this).val() > max)
          {
              $(this).val(max);
          }
          else if ($(this).val() < min)
          {
              $(this).val(min);
          }       
        }); 
    });

   $('#complaint_to').click(function(e){
   $('#complaint_block').toggle();
   
   });

    ", \yii\web\View::POS_END);
AppAsset::register($this);

$appData = AppData::getData();

/*
 * Load data product
 */
$product = json_decode($product);
$this->title = Yii::t('app', 'Catalog') . ' | ' . $product->title;
$contactForm = new ContactForm();
$contactForm->id = $title->id;
$seller = User::findOne($product->created_by);;
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

$this->registerMetaTag([
    'property' => 'og:image',
    'content' => $product->title_image
]);


$metaData = MetaData::getModels($model);
$this->registerMetaData($metaData);

$makeId = ProductMake::find()->where(['product_type' => $product->type])->andWhere(['name' => $product->make])->one()->id;
$videoModel = VideoAuto::find()->where(['type_id' => $product->type])->andWhere(['make_id' => $makeId])
    ->andWhere(['model' => $product->model])->limit(3)->all();

?>
<!-- Разметка с помощью микроданных, созданная Мастером разметки структурированных данных Google. -->
<div class="b-breadCumbs s-shadow">
    <?= Breadcrumbs::widget([
        'links' => [
            [
                'label' => ProductType::getTypesAsArray()[$product->type],
                'url' => Url::UrlBaseCategory($product->type)
            ],
            [
                'label' => $product->make,
                'url' => Url::UrlCategoryBrand($product->type, $product->make)
            ],
            [
                'label' => $product->model,
                'url' => Url::UrlCategoryModel($product->type, $product->make, $product->makeid)
            ],
            $product->title
        ],
        'options' => ['class' => 'container wow zoomInUp', 'ata-wow-delay' => '0.5s'],
        'itemTemplate' => "<li class='b-breadCumbs__page'>{link}</li>\n",
        'activeItemTemplate' => "<li class='b-breadCumbs__page m-active'>{link}</li>\n",
    ]) ?>
</div><!--b-breadCumbs-->
<section class="card_product b-detail">
    <div class="container">
        <header class="b-detail__head s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
            <div class="row">
                <div class="col-xs-12">
                    <?= Alert::widget() ?>
                </div>
            </div>
            <div class="flex-row">
                <?php
                if (Yii::$app->user->isGuest):
                    ?>
                    <a href="#" class="show-modal-login"> <span class="star-ico"> <i
                                    class="far fa-star"></i></span></a>
                <?php
                else:
                    ?>
                    <?php
                    if (Bookmarks::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['product_id' => $product->id])->exists()):
                        ?>
                        <a href="#" title="Удалить из закладок" id="delete-bookmarks" class="bookmarks active"
                           data-product="<?= $product->id; ?>"> <span class="star-ico"> <i
                                        class="far fa-star"></i></span></a>

                    <?php
                    else:
                        ?>
                        <a href="#" title="Добавить в закладки" id="add-bookmarks" class="bookmarks inactive"
                           data-product="<?= $product->id; ?>"> <span class="star-ico"> <i
                                        class="far fa-star"></i></span></a>
                    <?php
                    endif;
                    ?>
                <?php
                endif;
                ?>
                <div itemscope itemtype="http://schema.org/Product" class="b-detail__head-title">
                    <h1 itemprop="name"><?= $product->make ?> <?= $model->model ?>, <?= $model->year ?></h1>
                    <h3><?= $product->short_title ?></h3>
                </div>
            </div>
        </header>
    </div>
    <div class="b-infoBar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span class="b-product-info"><span>№</span> : <?= $product->id ?></span>
                    <span class="b-product-info"><span><?= Yii::t('app', 'Published') ?></span> : <?= Yii::$app->formatter->asDate($product->created_at) ?></span>
                    <span class="b-product-info"><span><?= Yii::t('app', 'Updated') ?></span> : <?= Yii::$app->formatter->asDate($product->updated_at) ?></span>
                    <span class="b-product-info"><span
                                class="fa fa-eye"></span> <?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $views]) ?></span>
                    <? if (Yii::$app->user->can('deleteOwnProduct', ['model' => $product])): ?>
                        <span class="b-product-info edit"><a
                                    href="/update-ads?id=<?= $product->id ?>">Редактировать</a> </span>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--b-infoBar-->

    <div class="b-detail__main">
        <div class="left_block col-xs-12 visible-md visible-lg">
            <div class="b-detail__head-price">
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                     class="b-detail__head-price-num">
                        <span itemprop="price"
                              content="<?= $product->price_byn ?>">  <?= Yii::$app->formatter->asDecimal($product->price_byn) ?> </span>
                    <span itemprop="priceCurrency" content="BYN">BYN </span>
                    <span class="b-detail__head-price-num-usd"><?= Yii::$app->formatter->asDecimal($product->price_usd) ?>
                        $</span>
                </div>
                <div class="b-detail__head-auction-exchange">
                    <?php if ($product->exchange): ?>
                        <span class="b-detail__head-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                    <?php endif; ?>
                    <?php if ($product->auction): ?>
                        <span class="b-detail__head-auction"><?= Yii::t('app', 'Auction') ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <aside class="b-detail__main-aside visible-md visible-lg visible-xl">
                <div itemprop="description" class="b-detail__main-aside-desc">
                    <?= $this->render('_productDescription', ['product' => $product]) ?>
                </div>
                <div class="b-detail__main-aside-about">
                    <?= $this->render('_sellerData', ['phone' => $phone, 'phone_provider' => $phone_provider, 'phone_2' => $phone_2, 'phone_provider_2' => $phone_provider_2, 'phone_3' => $model->phone_3, 'phone_provider_3' => $model->phone_provider_3, 'first_name' => $first_name, 'region' => $product->region, 'city' => $product->city_id]) ?>
                </div>
                <?php if ($product->priority == 1): ?>
                    <div class="b-detail__main-aside-aboutCompany">
                        <?= $this->render('_sellerDataCompany') ?>
                    </div>
                <?php endif ?>
            </aside>
            <div class="col-md-12 complaint_container">
                <?php Pjax::begin(['enablePushState' => false]); ?>
                <span class="complaint" id="complaint_to">Пожаловаться на объявление</span>
                <div id="complaint_block">
                    <?= Html::beginForm(['/catalog/complaint'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
                    <?
                    $modelComplain = new Product();
                    $modelComplain->setScenario(Product::SCENARIO_COMPLAIN);
                    ?>
                    <?= Html::hiddenInput('id', $product->id) ?>
                    <?= Html::dropDownList('complaint_type', Complaint::$type_comlaint, Complaint::$type_comlaint) ?>
                    <?= Html::textarea('complaint_text', '', ['rows' => '6', 'placeholder' => 'Введите текст жалобы']) ?>
                    <?= Html::submitButton('Отправить', ['class' => 'btn m-btn m-btn-dark']) ?>
                    <?= Html::endForm() ?>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
        <div class="centr_block col-xs-12">
            <div class="b-detail__main-info">
                <div class="b-detail__main-info-images">
                    <div class="row m-smallPadding">
                        <div class="col-xs-12 fotorama" data-nav="thumbs" data-allowfullscreen="true"
                             data-loop="true" data-keyboard="true"
                             data-click="true"
                             data-swipe="true"
                             data-width="100%"
                             data-minwidth="355">
                            <?
                            if (($product->video !== null) && ($product->video !== '')):
                                ?>
                                <a href="<?= $product->video ?>"
                                   data-video="true">
                                </a>
                            <?
                            endif;
                            ?>
                            <?php foreach ($product->image as $image): ?>
                                <a itemprop="image" href="<?= $image->full ?>"
                                   data-thumb="<?= $image->thumbnail ?>">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="left_block">
                        <div class="b-detail__head-price visible-xs visible-sm">
                            <div class="b-detail__head-price-num">
                                <?= Yii::$app->formatter->asDecimal($product->price_byn) ?> BYN
                                <span class="b-detail__head-price-num-usd"><?= Yii::$app->formatter->asDecimal($product->price_usd) ?>
                                    $</span>
                            </div>
                            <div class="b-detail__head-auction-exchange">
                                <?php if ($product->exchange): ?>
                                    <span class="b-detail__head-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                                <?php endif; ?>
                                <?php if ($product->auction): ?>
                                    <span class="b-detail__head-auction"><?= Yii::t('app', 'Auction') ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <noindex>
                    <div itemprop="description"
                         class="description-mobile-block b-detail__main-aside-desc visible-xs visible-sm">
                        <?= $this->render('_productDescription', ['product' => $product]) ?>
                    </div>
                    <div class="seller-mobile-block b-detail__main-aside-desc visible-xs visible-sm">
                        <?= $this->render('_sellerMobileData', ['appData' => $appData, 'product' => $product, 'phone' => $phone, 'phone_provider' => $phone_provider, 'phone_2' => $phone_2, 'phone_provider_2' => $phone_provider_2, 'phone_3' => $model->phone_3, 'phone_provider_3' => $model->phone_provider_3, 'first_name' => $first_name, 'region' => $product->region, 'city' => $product->city_id]) ?>
                    </div>
                </noindex>
                <div class="b-detail__main-info-text">
                    <div class="b-detail__main-aside-about-form-links">
                        <a href="#" class="j-tab m-active s-lineDownCenter"
                           data-to='#info1'><?= Yii::t('app', 'Seller comments') ?></a>
                        <a href="#" class="j-tab s-lineDownCenter"
                           data-to='#info2'><?= Yii::t('app', 'All about credit') ?></a>
                    </div>
                    <div id="info1">
                        <?= Html::encode($product->seller_comments) ?>
                    </div>
                    <div id="info2">
                        <?= $appData['allAboutCredit'] ?>
                    </div>
                </div>
            </div>
            <?
            if (count($product->spec_additional) > 0):
                ?>
                <div class="b-detail__main-info-extra">
                    <h2 class="s-titleDet"><?= Yii::t('app', 'Additional specifications') ?>:</h2>
                    <div class="row">
                        <?php
                        foreach ($product->spec_additional as $spec_additional): ?>
                            <div class="col-md-4 col-xs-3">
                                <ul>
                                    <li><span class="fa fa-check"></span><?= $spec_additional->name ?>
                                    </li>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 social-container">
                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                <script src="//yastatic.net/share2/share.js"></script>
                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,twitter"></div>
            </div>
            <br>
            <div class="clearfix"></div>
            <div class="col-md-12 video_block">
                <noindex>
                    <h3>Интересные видео</h3>
                    <?php
                    foreach ($videoModel as $video):
                        ?>
                        <iframe class="col-md-4" width="240" height="120"
                                src="https://www.youtube.com/embed/<? echo $video->video_url; ?>?rel=0" frameborder="0"
                                allow="autoplay; encrypted-media" allowfullscreen></iframe>

                    <?php
                    endforeach;
                    ?>
                </noindex>
            </div>
            <div class="col-md-12 complaint_container hidden-md hidden-lg">
                <?php Pjax::begin(['id' => 'complaint-phone', 'enablePushState' => false]); ?>
                <span class="complaint" id="complaint_to_mobile">Пожаловаться на объявление</span>
                <div id="complaint_block_mobile">
                    <?= Html::beginForm(['/catalog/complaint'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
                    <?
                    $modelComplain = new Product();
                    $modelComplain->setScenario(Product::SCENARIO_COMPLAIN);
                    ?>
                    <?= Html::hiddenInput('id', $product->id) ?>
                    <?= Html::dropDownList('complaint_type', Complaint::$type_comlaint, Complaint::$type_comlaint) ?>
                    <?= Html::textarea('complaint_text', '', ['rows' => '6', 'placeholder' => 'Введите текст жалобы']) ?>
                    <?= Html::submitButton('Отправить', ['class' => 'btn m-btn m-btn-dark']) ?>
                    <?= Html::endForm() ?>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
        <div class="right_block col-xs-12">
            <div class="b-items__aside">
                <div class="b-detail__main-aside-about visible-md visible-lg visible-xl">
                    <div class="b-detail__main-aside-about-call b-detail__main-aside-about-call--narrow">
                        <h3>Консультация по кредиту:</h3>
                        <div>
 <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[$appData['phone_credit_provider_1']], ['style' => 'height:22px']) ?>
        </span>
                            <a href="tel:<?= $appData['phone_credit_1'] ?>"><?= $appData['phone_credit_1'] ?></a>
                            <br>
                            <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[$appData['phone_credit_provider_2']], ['style' => 'height:22px']) ?>
        </span>
                            <a href="tel:<?= $appData['phone_credit_2'] ?>"><?= $appData['phone_credit_2'] ?></a>
                            <br>
                            <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[$appData['phone_credit_provider_3']], ['style' => 'height:22px']) ?>
        </span>
                            <a href="tel:<?= $appData['phone_credit_3'] ?>"><?= $appData['phone_credit_3'] ?></a>
                        </div>

                        <p>Пн-Вс : 10:00 - 18:00 <br> Без выходных</p>

                        <hr>

                        <div class="b-items__aside-sell">

                            <h2><i class="fa fa-podcast" aria-hidden="true"></i>ЗАЯВКА НА КРЕДИТ</h2>

                            <p>
                                Заполните анкету и мы <br> свяжемся с Вами <br> в кратчайшие сроки
                            </p>

                            <a href="/tools/credit-application?id=<?= $product->id; ?>"
                               class="btn m-btn">Заполнить <i class="fa fa-angle-double-right"
                                                              aria-hidden="true"></i></a>

                        </div>

                    </div>
                </div>
                <div class="spravka-btn">
                    <a href="/documents/spravka-2018.doc">Справка о доходах</a>
                </div>
                <div class="b-detail__main-aside-payment">
                    <h2 class="s-titleDet"><?= Yii::t('app', 'CAR PAYMENT CALCULATOR') ?></h2>
                    <div class="b-detail__main-aside-payment-form">
                        <div class="calculator-loan" style="display: none;"></div>
                        <form action="/" method="post" class="js-loan">
                            <label><?= Yii::t('app', 'ENTER LOAN AMOUNT') ?></label>
                            <input type="text" placeholder="<?= Yii::t('app', 'LOAN AMOUNT') ?>"
                                   value="<?= $product->price_byn ?>" name="price" disabled="disabled"/>
                            <label><?= Yii::t('app', 'Prepayment') ?></label>
                            <input type="number" placeholder="<?= Yii::t('app', 'Prepayment') ?>"
                                   value="0" name="prepayment" id="prepayment" min="0"
                                   max="<?= $product->price_byn ?>"/>
                            <label><?= Yii::t('app', 'RATE IN') ?> %</label>
                            <div class="s-relative">
                                <select name="rate" class="m-select" id="rate">
                                    <option value="<?= $appData['prior_bank'] ?>">
                                        Приорбанк <?= $appData['prior_bank'] ?>%
                                    </option>
                                    <option value="<?= $appData['vtb_bank'] ?>">ВТБ <?= $appData['vtb_bank'] ?>%
                                    </option>
                                    <option value="<?= $appData['bta_bank'] ?>">БТА <?= $appData['bta_bank'] ?>%
                                    </option>
                                    <option value="<?= $appData['status_bank'] ?>">
                                        СтатусБанк <?= $appData['status_bank'] ?>%
                                    </option>
                                </select>
                                <span class="fa fa-caret-down"></span>
                            </div>
                            <label><?= Yii::t('app', 'LOAN TERM') ?></label>
                            <div class="s-relative">
                                <select name="term" class="m-select" id="term">
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
                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            </button>
                        </form>
                        <div class="js-loan-results">
                            <div>
                                <span class="js-per-month"> </span>
                                <span>BYN в месяц</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info_credit">
                    <?= $appData['credit_information'] ?>
                </div>

            </div>
        </div>
    </div>

</section>
<!--b-detail-->
<section class="similar_ads footer_block m-home">
    <div class="container">
        <?php
        if (!empty($product->similar)): ?>
        <div class="row">
            <div class="col-md-12">
                <h2>
                    <?= Yii::t('app', 'RELATED VEHICLES ON SALE') ?>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($product->similar as $similarProduct): ?>
                    <div class="col-md-3 b-featured__item  visible-md visible-lg visible-xl">
                        <a href="<?= Url::UrlShowProduct($similarProduct->id) ?>">
                            <span class="m-premium"></span>
                            <img class="hover-light-img" width="170" height="170"
                                 src="<?= $similarProduct->main_image_url ?>"
                                 alt="<?= Html::encode($similarProduct->full_title) ?>"/>
                        </a>
                        <div class="inner_container">
                            <div class="h5">
                                <a
                                        href="<?= Url::UrlShowProduct($similarProduct->id) ?>"><?= $similarProduct->full_title ?></a>
                            </div>
                            <div class="b-featured__item-price">
                                <?= Yii::$app->formatter->asDecimal($similarProduct->price_byn) ?> BYN
                            </div>
                            <div class="b-featured__item-price-usd">
                                <?= Yii::$app->formatter->asDecimal($similarProduct->price_usd) ?> $
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($similarProduct->spec as $i => $productSpec): ?>
                                <?php if ($productSpec->get_title_image_url != ''): ?>
                                    <div class="b-featured__item-count" title="<?= $productSpec->name ?>">
                                        <img width="20" src="<?= $productSpec->get_title_image_url ?>"/>
                                        Пробег: <?= Html::encode($productSpec->value) ?> <?= $productSpec->unit ?>
                                    </div>
                                <?php
                                    //ToDo: Переписать!!!
                                endif;
                                if ($i == 0):
                                    ?>
                                    <ul class="b-featured__item-links">
                                <?
                                endif;
                                ?>
                                <li>
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                    <?= Html::encode($productSpec->priority_hight->value) ?> <?= $productSpec->priority_hight->unit ?>
                                </li>
                                <?php
                                if ($i == 3):
                                    ?>
                                    </ul>
                                <?
                                endif;
                                ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <noindex>
                        <div class="b-items__cars-one visible-xs visible-sm " data-key="<?= $product->id ?>">
                            <div class="visible-sm visible-xs  b-items__cars-one-info-header s-lineDownLeft">
                                <h2>
                                    <a href="<?= Url::UrlShowProduct($similarProduct->id) ?>"><?= Html::encode($similarProduct->full_title) ?></a>
                                    <?php if ($similarProduct->exchange): ?>
                                        <span class="b-items__cars-one-info-title b-items__cell-info-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                                    <?php endif; ?>
                                </h2>
                            </div>
                            <div class="photo_mobile_block visible-sm visible-xs col-xs-4 col-sm-6">
                                <a href="<?= Url::UrlShowProduct($similarProduct->id) ?>"
                                   class="b-items__cars-one-img">
                                    <img src="<?= $similarProduct->main_image_url ?>"
                                         alt="<?= Html::encode($similarProduct->full_title) ?>"
                                         class="hover-light-img"/>
                                    <?php if ($similarProduct->priority == 1): ?>
                                        <span class="b-items__cars-one-img-type m-premium"></span>
                                    <?php endif; ?>
                                    <?php if ($similarProduct->priority != 1): ?>
                                        <span class="b-items__cars-one-img-type m-premium"></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="spec_mobile_block col-xs-8 col-sm-6 visible-sm visible-xs">
                                <div class="price_mobile_block">
                                    <h4 class="b-items__cell-info-price-byn"><?= Yii::$app->formatter->asDecimal($similarProduct->price_byn) ?>
                                        BYN</h4>
                                    <span class="b-items__cell-info-price-usd"><?= Yii::$app->formatter->asDecimal($similarProduct->price_usd) ?>
                                        $ </span>
                                    <?php if ($similarProduct->auction): ?>
                                        <span class="b-items__cars-one-info-title b-items__cell-info-auction"><?= Yii::t('app', 'Auction') ?></span>
                                    <?php endif; ?>
                                </div>
                                <?= $similarProduct->year ?>,
                                <?php foreach ($similarProduct->spec as $i => $productSpec) {
                                    echo Html::encode($productSpec->value) . ' ';
                                    echo $productSpec->unit . ', ';
                                    echo Html::encode($productSpec->priority_hight->value) . ' ';
                                    echo $productSpec->priority_hight->unit;
                                }
                                ?>
                                <br>
                                <span class="city_block_mobile"><?= City::getCityName($similarProduct->city_id); ?></span>
                            </div>
                        </div>
                    </noindex>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    </div>
    </div>
    </div>
</section><!--"b-related-->

