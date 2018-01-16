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

$product = json_decode($product);
/* @var $this yii\web\View */
/* @var $model Product */
/* @var $provider yii\data\ActiveDataProvider */
$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);
$this->registerJs("require(['controllers/tools/calculator']);
$(document).ready(function(){
$('#complaint_to_mobile').click(function(){
$('#complaint_block_mobile').toggle();
});
 var owl = $('#carousel-small-2');
 owl.owlCarousel({
 responsiveClass:true,
    responsive:{
    items:4,
            nav:true,
             loop:true,
              margin:20,
          
        0:{
            items:1,
            nav:true,
            loop:true,
              
        },
        600:{
            items:3,
            nav:true,
            loop:true,
             
        },
        1000:{
            items:4,
            nav:true,
            loop:true,
              },
        2000:{
            items:4,
            nav:true,
            loop:true,
              }
    }
})
owl.owlCarousel();
// Go to the next item
$('.owl-next').click(function() {
    owl.trigger('next.owl.carousel');
})
// Go to the previous item
$('.owl-prev').click(function() {
    // With optional speed parameter
    // Parameters has to be in square bracket '[]'
    owl.trigger('prev.owl.carousel', [300]);
})
});
", \yii\web\View::POS_HEAD);
$this->registerCss("
.owl-nav {
display:none;
}
");
$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css");
$this->registerJsFile(
    '@web/js/fotorama.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/owl.carousel.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile("@web/theme/assets/bxslider/jquery.bxslider.css");
$this->registerCssFile("@web/theme/assets/owl-carousel/owl.carousel.css");
    $this->registerCssFile("@web/theme/assets/owl-carousel/owl.theme.css");

$this->registerJs("    $('.fotorama').fotorama({
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
    ", \yii\web\View::POS_END);
$appData = AppData::getData();
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


$metaData = MetaData::getModels($model);
$this->registerMetaData($metaData);

?>
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
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="b-detail__head-title">
                            <h1><?= $product->make ?> <?= $model->model ?>, <?= $model->year ?></h1>
                            <h3><?= $product->short_title ?></h3>
                        </div>
                    </div>
                </div>
            </header>
        </div>
            <div class="b-infoBar">
                <div class="container">
                    <div class="row wow zoomInUp" data-wow-delay="0.5s">
                        <div class="col-md-12">
                            <span class="b-product-info"><span>№</span> : <?= $product->id ?></span>
                            <span class="b-product-info"><span><?= Yii::t('app', 'Published') ?></span> : <?= Yii::$app->formatter->asDate($product->created_at) ?></span>
                            <span class="b-product-info"><span><?= Yii::t('app', 'Updated') ?></span> : <?= Yii::$app->formatter->asDate($product->updated_at) ?></span>
                            <span class="b-product-info"><span
                                        class="fa fa-eye"></span> <?= Yii::t('app', '{n,plural,=0{# Views} =1{# View} one{# View} other{# Views}}', ['n' => $views]) ?></span>
                          <?  if (Yii::$app->user->can('deleteOwnProduct', ['model' => $product])):?>
                              <span class="b-product-info edit"><a href="/update-ads?id=<?=$product->id?>">Редактировать</a> </span>
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
                    <aside class="b-detail__main-aside">
                        <div class="b-detail__main-aside-desc wow zoomInUp"
                             data-wow-delay="0.5s">
                            <?= $this->render('_productDescription', ['product' => $product]) ?>
                        </div>
                        <div class="b-detail__main-aside-about wow zoomInUp"
                             data-wow-delay="0.5s">
                            <?= $this->render('_sellerData', ['phone' => $phone, 'phone_provider' => $phone_provider, 'phone_2' => $phone_2, 'phone_provider_2' => $phone_provider_2, 'first_name' => $first_name, 'region' => $product->region, 'city' => $product->city_id]) ?>
                        </div>
                        <?php if ($product->priority == 1): ?>
                            <div class="b-detail__main-aside-aboutCompany wow zoomInUp"
                                 data-wow-delay="0.5s">
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
                        <div class="b-detail__main-info-images wow zoomInUp" data-wow-delay="0.5s">
                            <div class="row m-smallPadding">
                                <div class="col-xs-12 fotorama" data-nav="thumbs" data-allowfullscreen="true"
                                     data-loop="true" data-keyboard="true"
                                     data-click="true"
                                     data-swipe="true">
                                    <?php foreach ($product->image as $image): ?>
                                        <a href="<?= $image->full ?>"
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
                        <div class="wow zoomInUp b-detail__main-aside-desc hidden-md hidden-lg"
                             data-wow-delay="0.5s">
                            <?= $this->render('_productDescription', ['product' => $product]) ?>
                        </div>
                        <div class="wow zoomInUp b-detail__main-aside-desc hidden-md hidden-lg"
                             data-wow-delay="0.5s">
                            <?= $this->render('_sellerData', ['phone' => $phone, 'phone_provider' => $phone_provider, 'phone_2' => $phone_2, 'phone_provider_2' => $phone_provider_2, 'first_name' => $first_name, 'region' => $product->region, 'city' => $product->city_id]) ?>
                        </div>
                        <div class="b-detail__main-info-text wow zoomInUp" data-wow-delay="0.5s">
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
                        <div class="b-detail__main-info-extra wow zoomInUp" data-wow-delay="0.5s">
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
                        <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus"></div>
                    </div>
                    <div class="col-md-12 complaint_container hidden-md hidden-lg">
                        <?php Pjax::begin(['id' => 'complaint-phone','enablePushState' => false]); ?>
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
                        <div class="b-detail__main-aside-about wow zoomInUp" data-wow-delay="0.5s">

                            <h3>Консультация по кредиту:</h3>

                            <div class="b-detail__main-aside-about-call b-detail__main-aside-about-call--narrow">

                                <span class="fa fa-phone"></span>

                                <div><a href="tel:<?= $appData['phone'] ?>"><?= $appData['phone'] ?></a></div>

                                <p>Пн-Вс : 10:00 - 18:00 <br> Без выходных</p>

                            </div>
                            <hr>

                            <div class="b-items__aside-sell wow zoomInUp" data-wow-delay="0.3s">

                                <h2><i class="fa fa-podcast" aria-hidden="true"></i>ЗАЯВКА НА КРЕДИТ</h2>

                                <p>
                                    Заполните анкету и мы <br> свяжемся с Вами <br> в кратчайшие сроки
                                </p>

                                <a href="/tools/credit-application?id=<?= $product->id; ?>"
                                   class="btn m-btn">Заполнить <i class="fa fa-angle-double-right"
                                                                  aria-hidden="true"></i></a>

                            </div>

                        </div>
                        <div class="b-detail__main-aside-payment wow zoomInUp" data-wow-delay="0.5s">
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
                                            <option value="14">Приорбанк 14%</option>
                                            <option value="22">ВТБ 22%</option>
                                            <option value="14.5">БТА 14,5%</option>
                                            <option value="16.8">СтатусБанк 16,8%</option>
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
                                <div class="b-detail__main-aside-about-call js-loan-results">
                                    <div><span class="js-per-month"> </span>
                                        BYN
                                        <p>в месяц</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info_credit">
                            <h2>Кредит</h2>
                            <span>от 3 месяцев до 5 лет</span>
                            <hr>
                            <ul>
                                <li>
                                    <div> С досрочным погашением</div>
                                </li>
                                <li>
                                    <div> Без справки о доходах</div>
                                </li>
                                <li>
                                    <div> Без первеночального взноса и поручителей</div>
                                </li>
                                <li>
                                    <div> Без привязки к курсу валют</div>
                                </li>

                            </ul>
                            <span class="trade_in"><b>Ваш старый автомобиль в зачёт!</b></span>
                            <p>*Если сумма кредита перевышает 5000 руб. потребуется справка о доходах за 3
                                месяца.</p>
                        </div>

                    </div>
                </div>
            </div>

    </section>
    <!--b-detail-->
<?php
if (count($product->similar) > 0): ?>
    <section class="footer_block m-home">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'RELATED VEHICLES ON SALE') ?>
                        <div class="owl-controls clickable js-featured-vehicles-caruosel-nav-2 featured-vehicles-controls hidden-sm hidden-xs col-md-2 col-md-offset-6 col-xs-offset-0 col-xs-offset-0 col-xs-3 col-sm-3">
                            <div class="owl-buttons ">
                                <div class="owl-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
                                <div class="owl-next" style="margin-left: 0 !important;"><i class="fa fa-chevron-right"
                                                                                            aria-hidden="true"></i></div>
                            </div>
                        </div>
                    </h2>
                    <div id="carousel-small-2" class="owl-card owl-carousel js-featured-vehicles-caruosel-2" data-items="4"
                         data-navigation="true" data-auto-play="true" data-stop-on-hover="true" data-items-desktop="4"
                         data-items-desktop-small="1" data-items-tablet="2" data-items-tablet-small="1">
                        <?php foreach ($product->similar as $similarProduct): ?>
                            <div class="b-featured__item wow rotateIn col-md-3 col-xs-12 col-sm-12" data-wow-delay="0.3s"
                                 data-wow-offset="150">
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
                        <?php endforeach; ?>
                    </div>
                    <div class="owl-controls clickable js-featured-vehicles-caruosel-nav-2 featured-vehicles-controls hidden-md hidden-lg col-md-2 col-md-offset-6 col-xs-offset-0 col-xs-offset-0 col-xs-3 col-sm-3">
                        <div class="owl-buttons ">
                            <div class="owl-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
                            <div class="owl-next" style="margin-left: 0 !important;"><i class="fa fa-chevron-right"
                                                                                        aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--"b-related-->
<?php endif; ?>