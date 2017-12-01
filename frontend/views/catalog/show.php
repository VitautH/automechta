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
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model Product */
/* @var $provider yii\data\ActiveDataProvider */

$tableView = filter_var(Yii::$app->request->get('tableView', 'false'), FILTER_VALIDATE_BOOLEAN);
$this->registerJs("require(['controllers/tools/calculator']);", \yii\web\View::POS_HEAD);
$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css");
$this->registerJsFile(
    '@web/js/fotorama.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
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
$uploads = $model->getUploads();
$similarProducts = Product::find()
    ->active()
    ->orderBy('RAND()')
    ->where(['make' => $model->make])
    ->andWhere(['model' => $model->model])
    ->limit(4)->all();
$this->title = Yii::t('app', 'Catalog') . ' | ' . $model->getFullTitle();
$contactForm = new ContactForm();
$contactForm->id = $model->id;
$seller = User::findOne($model->created_by);;
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
                <div class="col-md-2">
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus"></div>
                </div>
                <div class="col-md-3">
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
    <!--b-infoBar-->
    <section class="card_product b-detail">
        <div class="container">
            <header class="b-detail__head s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                <div class="row">
                    <div class="col-xs-12">
                        <?= Alert::widget() ?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="b-detail__head-title">
                            <h1><?= $model->getMake0()->one()->name ?> <?= $model->model ?>, <?= $model->year ?></h1>
                            <h3><?= $model->i18n()->title ?></h3>
                        </div>
                    </div>
            </header>
            <div class="b-detail__main">
                <div class="left_block col-xs-12">
                    <div class="b-detail__head-price">
                        <div class="b-detail__head-price-num">
                            <?= Yii::$app->formatter->asDecimal($model->getByrPrice()) ?> BYN
                            <span class="b-detail__head-price-num-usd"><?= Yii::$app->formatter->asDecimal($model->getUsdPrice()) ?>
                                $</span>
                        </div>
                        <div class="b-detail__head-auction-exchange">
                            <?php if ($model->exchange): ?>
                                <span class="b-detail__head-exchange"><?= Yii::t('app', 'Exchange') ?></span>
                            <?php endif; ?>
                            <?php if ($model->auction): ?>
                                <span class="b-detail__head-auction"><?= Yii::t('app', 'Auction') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <aside class="b-detail__main-aside">
                        <div class="b-detail__main-aside-desc wow zoomInUp hidden-sm hidden-xs"
                             data-wow-delay="0.5s">
                            <?= $this->render('_productDescription', ['model' => $model, 'productSpecificationsMain' => $productSpecificationsMain]) ?>
                        </div>
                            <div class="b-detail__main-aside-about wow zoomInUp hidden-sm hidden-xs"
                                 data-wow-delay="0.5s">
                                <?= $this->render('_sellerData', ['phone' => $phone, 'phone_provider' => $phone_provider, 'phone_2' => $phone_2, 'phone_provider_2' => $phone_provider_2, 'first_name' => $first_name, 'region' => $region]) ?>
                            </div>
                        <?php if ($model->priority == 1): ?>
                            <div class="b-detail__main-aside-aboutCompany wow zoomInUp hidden-sm hidden-xs"
                                 data-wow-delay="0.5s">
                                <?= $this->render('_sellerDataCompany') ?>
                            </div>
                        <?php endif ?>
                    </aside>
                </div>
                <div class="centr_block col-xs-12">
                    <div class="b-detail__main-info">
                        <div class="b-detail__main-info-images wow zoomInUp" data-wow-delay="0.5s">
                            <div class="row m-smallPadding">
                                <div class="col-xs-12 fotorama" data-nav="thumbs" data-allowfullscreen="true"
                                     data-loop="true" data-keyboard="true">
                                    <?php foreach ($uploads as $key => $upload): ?>
                                        <a href="<?= $upload->getThumbnail(800, 460) ?>"
                                           data-thumb="<?= $upload->getThumbnail(115, 85) ?>">
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <br>
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
                    </div>
                    <? $countSpecifications = ProductSpecification::find()->where(['product_id' => $model->id])
                        ->andWhere(['value' => 1])->count();
                    if ($countSpecifications > 0):
                        ?>
                        <div class="b-detail__main-info-extra wow zoomInUp" data-wow-delay="0.5s">
                            <h2 class="s-titleDet"><?= Yii::t('app', 'Additional specifications') ?>:</h2>
                            <div class="row">
                                <?php
                                foreach ($productSpecificationsAdditionalCols as $productSpecificationsAdditionalCol): ?>
                                    <div class="col-md-4 col-xs-3">
                                        <ul>
                                            <?php foreach ($productSpecificationsAdditionalCol as $productSpecificationsAdditional): ?>
                                                <?php $spec = $productSpecificationsAdditional->getSpecification()->one(); ?>
                                                <? if ((int)$productSpecificationsAdditional->value == 1):
                                                    ?>
                                                    <li>
                                                        <span class="fa fa-check"></span><?= $spec->i18n()->name ?>
                                                    </li>
                                                    <?
                                                endif;
                                                ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif;
                    ?>
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

                                <a href="/tools/credit-application?id=<?=$model->id;?>"
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
                                           value="<?= $model->getByrPrice() ?>" name="price" disabled="disabled"/>
                                    <label><?= Yii::t('app', 'Prepayment') ?></label>
                                    <input type="number" placeholder="<?= Yii::t('app', 'Prepayment') ?>"
                                           value="0" name="prepayment" id="prepayment" min="0"
                                           max="<?= $model->getByrPrice() ?>"/>
                                    <label><?= Yii::t('app', 'RATE IN') ?> %</label>
                                    <input type="text" placeholder="<?= Yii::t('app', 'RATE IN') ?> %"
                                           value="<?= $appData['loanRate'] ?>%" name="rate"
                                           disabled="disabled"/>
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

                    <!--                        <div class="row" style="margin-top: 20px;">-->
                    <!--                            <div class="col-md-3">-->
                    <!--                                <!-- Yandex.RTB R-A-248508-1 -->
                    <!--                                <div id="yandex_rtb_R-A-248508-1"></div>-->
                    <!--                                <script type="text/javascript">-->
                    <!--                                    (function (w, d, n, s, t) {-->
                    <!--                                        w[n] = w[n] || [];-->
                    <!--                                        w[n].push(function () {-->
                    <!--                                            Ya.Context.AdvManager.render({-->
                    <!--                                                blockId: "R-A-248508-1",-->
                    <!--                                                renderTo: "yandex_rtb_R-A-248508-1",-->
                    <!--                                                async: true-->
                    <!--                                            });-->
                    <!--                                        });-->
                    <!--                                        t = d.getElementsByTagName("script")[0];-->
                    <!--                                        s = d.createElement("script");-->
                    <!--                                        s.type = "text/javascript";-->
                    <!--                                        s.src = "//an.yandex.ru/system/context.js";-->
                    <!--                                        s.async = true;-->
                    <!--                                        t.parentNode.insertBefore(s, t);-->
                    <!--                                    })(this, this.document, "yandexContextAsyncCallbacks");-->
                    <!--                                </script>-->
                    <!--                            </div>-->
                    <!--                            <div class="col-md-3">-->
                    <!--                                <!-- Yandex.RTB R-A-248508-1 -->
                    <!--                                <div id="yandex_rtb_R-A-248508-1"></div>-->
                    <!--                                <script type="text/javascript">-->
                    <!--                                    (function (w, d, n, s, t) {-->
                    <!--                                        w[n] = w[n] || [];-->
                    <!--                                        w[n].push(function () {-->
                    <!--                                            Ya.Context.AdvManager.render({-->
                    <!--                                                blockId: "R-A-248508-1",-->
                    <!--                                                renderTo: "yandex_rtb_R-A-248508-1",-->
                    <!--                                                async: true-->
                    <!--                                            });-->
                    <!--                                        });-->
                    <!--                                        t = d.getElementsByTagName("script")[0];-->
                    <!--                                        s = d.createElement("script");-->
                    <!--                                        s.type = "text/javascript";-->
                    <!--                                        s.src = "//an.yandex.ru/system/context.js";-->
                    <!--                                        s.async = true;-->
                    <!--                                        t.parentNode.insertBefore(s, t);-->
                    <!--                                    })(this, this.document, "yandexContextAsyncCallbacks");-->
                    <!--                                </script>-->
                    <!--                            </div>-->
                    <!--                            <div class="col-md-3">-->
                    <!--                                <!-- Yandex.RTB R-A-248508-1 -->
                    <!--                                <div id="yandex_rtb_R-A-248508-1"></div>-->
                    <!--                                <script type="text/javascript">-->
                    <!--                                    (function (w, d, n, s, t) {-->
                    <!--                                        w[n] = w[n] || [];-->
                    <!--                                        w[n].push(function () {-->
                    <!--                                            Ya.Context.AdvManager.render({-->
                    <!--                                                blockId: "R-A-248508-1",-->
                    <!--                                                renderTo: "yandex_rtb_R-A-248508-1",-->
                    <!--                                                async: true-->
                    <!--                                            });-->
                    <!--                                        });-->
                    <!--                                        t = d.getElementsByTagName("script")[0];-->
                    <!--                                        s = d.createElement("script");-->
                    <!--                                        s.type = "text/javascript";-->
                    <!--                                        s.src = "//an.yandex.ru/system/context.js";-->
                    <!--                                        s.async = true;-->
                    <!--                                        t.parentNode.insertBefore(s, t);-->
                    <!--                                    })(this, this.document, "yandexContextAsyncCallbacks");-->
                    <!--                                </script>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                </div>
                <!--                    <div class="bottom_block col-xs-12">-->
                <!--                        <div class="b-detail__main-info-extra wow zoomInUp" data-wow-delay="0.5s">-->
                <!--                            <h2 class="s-titleDet">-->
                <? //= Yii::t('app', 'Additional specifications') ?><!--</h2>-->
                <!--                            <div class="row">-->
                <!--                                --><?php
                //                                foreach ($productSpecificationsAdditionalCols as $productSpecificationsAdditionalCol): ?>
                <!--                                    <div class="col-xs-3">-->
                <!--                                        <ul>-->
                <!--                                            --><?php //foreach ($productSpecificationsAdditionalCol as $productSpecificationsAdditional): ?>
                <!--                                                --><?php //$spec = $productSpecificationsAdditional->getSpecification()->one(); ?>
                <!--                                                --><? // if ((int)$productSpecificationsAdditional->value == 1):
                //                                                    ?>
                <!--                                                <li>-->
                <!--                                                    <span class="fa fa-check"></span>--><? //= $spec->i18n()->name ?>
                <!--                                                </li>-->
                <!--                                                    --><? //
                //                                                    endif;
                //                                                    ?>
                <!--                                            --><?php //endforeach; ?>
                <!--                                        </ul>-->
                <!--                                    </div>-->
                <!--                                --><?php //endforeach; ?>
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
            </div>
        </div>
        </div>
    </section><!--b-detail-->
<?php if (!empty($similarProducts)): ?>
    <section class="footer_block m-home">
        <div class="container">
            <h2 class="wow zoomInUp" data-wow-delay="0.5s"><?= Yii::t('app', 'RELATED VEHICLES ON SALE') ?></h2>
            <div class="row">
                <?php foreach ($similarProducts as $similarProduct): ?>
                    <div class="b-featured__item wow rotateIn col-md-3 col-xs-12 col-sm-12" data-wow-delay="0.3s"
                         data-wow-offset="150">
                        <a href="<?= $similarProduct->getUrl() ?>">
                            <span class="m-premium"><?= Yii::t('app', 'On credit') ?></span>
                            <img class="hover-light-img" width="170" height="170"
                                 src="<?= $similarProduct->getTitleImageUrl(640, 480) ?>"
                                 alt="<?= Html::encode($similarProduct->getFullTitle()) ?>"/>
                        </a>
                        <div class="inner_container">
                            <div class="h5">
                                <a
                                        href="<?= $similarProduct->getUrl() ?>"><?= $similarProduct->getFullTitle() ?></a>
                            </div>
                            <div class="b-featured__item-price">
                                <?= Yii::$app->formatter->asDecimal($similarProduct->getByrPrice()) ?> BYN
                            </div>
                            <div class="b-featured__item-price-usd">
                                <?= Yii::$app->formatter->asDecimal($similarProduct->getUsdPrice()) ?> $
                            </div>
                            <div class="clearfix"></div>
                            <?php foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGHEST) as $productSpec): ?>
                                <?php $spec = $productSpec->getSpecification()->one(); ?>
                                <div class="b-featured__item-count" title="<?= $spec->i18n()->name ?>">
                                    <img width="20" src="<?= $spec->getTitleImageUrl(20, 20) ?>"/>
                                    Пробег: <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                </div>
                            <?php endforeach; ?>
                            <ul class="b-featured__item-links">
                                <?php foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGH) as $productSpec): ?>
                                    <?php $spec = $productSpec->getSpecification()->one(); ?>
                                    <li>
                                        <i class="fa fa-square" aria-hidden="true"></i>
                                        <?= Html::encode($productSpec->getFormattedValue()) ?> <?= $spec->i18n()->unit ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section><!--"b-related-->
<?php endif; ?>