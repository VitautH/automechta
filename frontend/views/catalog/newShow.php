<?php

use common\models\Product;
use common\models\Specification;
use common\models\ProductSpecification;
use common\models\ProductType;
use common\models\ProductMake;
use common\models\AppData;
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\ContactForm;
use common\models\MetaData;
use common\models\Complaint;
use common\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\City;
use frontend\assets\AppAsset;
use frontend\models\Bookmarks;
use common\models\ProductVideo;
use common\models\AutoMakes;
use common\models\AutoModels;
use common\models\AutoModifications;
use common\models\AutoBody;
use common\models\ImageModifications;
use common\models\AutoSearch;
use common\models\Region;
use common\models\CreditApplication;

$this->registerJs("require(['controllers/modification/index']);", \yii\web\View::POS_HEAD);
$this->registerJsFile("/js/modernizm.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("require(['controllers/catalog/modal']);", \yii\web\View::POS_HEAD);
$this->registerJs("require(['controllers/catalog/bookmarksCard']);", \yii\web\View::POS_HEAD);

$this->registerCssFile("@web/css/slick-theme.css");

$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.5.2/fotorama.css");
$this->registerCssFile('@web/css/catalog-style.css');
$this->registerCssFile('@web/css/card-style.css');
$this->registerJsFile("http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("require(['controllers/catalog/card']);", \yii\web\View::POS_END);
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css');
$this->registerJs("$('a[rel=groupMainProduct]').fancybox();", \yii\web\View::POS_END);
$this->registerJs(" 
    $(function () {
       $('.fotorama').fotorama({
        spinner: {
            lines: 13,
            color: 'rgba(0, 0, 0, .75)'
        }
    });
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
    }); ", \yii\web\View::POS_HEAD);
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

$videoModel = ProductVideo::find()->where(['product_id' => $product->id])->limit(3)->all();

if ($product->type == ProductType::CARS) {

    /*
   * Specification
   */
    $autoBody = $product->spec[3]->format;
    $door = $product->spec[7]->format;
    /*
     * End Specification
     */


    $autoMakes = AutoMakes::find()->where(['like', 'name', $product->make])->one();
    $makeSlug = $autoMakes->slug;
    $makerId = $autoMakes->id;
    $autoModels = AutoModels::find()->where(['like', 'make_id', $makerId])->andWhere(['like', 'model', $product->model])->one();
    $modelSlug = $autoModels->slug;
    $modelId = $autoModels->id;
    $modificationName = ProductMake::findOne($product->makeid)->modification_name;

    if ($modelId == null) {
        $model_name = ProductMake::findOne($product->makeid)->model_name;
        $autoModels = AutoModels::find()->where(['make_id' => $makerId])->andWhere(['model' => $model_name])->one();
        $modelId = $autoModels->id;
        $modelSlug = $autoModels->slug;
    }
    $query = AutoModifications::find()->where(['model_id' => $modelId]);

    if (!empty($autoBody) && $autoBody !== null) {
        $query->andFilterWhere(['like', 'modification_name', $autoBody]);
    }

    if ($modificationName != null) {
        if (!empty($autoBody) && $autoBody !== null) {
            $query->andFilterWhere(['like', 'modification_name', $autoBody]);
        } else {
            $query->andFilterWhere(['like', 'modification_name', $modificationName]);
        }
    }

    $query->andWhere(['<=', 'yearFrom', $model->year]);
    $query->andFilterWhere(['or', ['>=', 'yearTo', $model->year], ['yearTo' => 'н.в.']]);


    if (($autoBody != 'седан') && ($door >= 3)) {
        $query->andFilterWhere(['like', 'modification_name', $door . ' дв.']);
    }

    $count = $query->count();
    if ($count == 0) {
        unset($query);
        $query = AutoModifications::find();
        $query->where(['model_id' => $modelId]);

        $query->andWhere(['modification_name' => null]);
        $query->andWhere(['yearFrom' => null]);
        $query->andWhere(['yearTo' => null]);
    }

    $modifications = $query->all();

} else {
    $modifications = null;
}

$product->price_byn = Product::getByrPriceProduct($product->id);
$product->price_usd = Product::getUsdPriceProduct($product->id);


$region = Region::getRegionName($product->region);
$city = City::getCityName($product->city_id);

$this->registerJs(" 
    $(function () {
       $('input[name=\"price\"]').val('" . $product->price_byn . "');
    }); ", \yii\web\View::POS_HEAD);
AppAsset::register($this);


switch ($product->type){
    case ProductType::CARS:
        $nameProductType = 'автомобилей';
        break;
    case ProductType::MOTO:
        $nameProductType = 'мотоциклов';
        break;
    case ProductType::ATV:
        $nameProductType = 'квадроциклов';
        break;
    case ProductType::SCOOTER:
        $nameProductType = 'скутеров';
        break;
}
?>
<div class="fixed-contacts hidden-desktop">
    <div class="row m-0">
        <div class="col-10">
            <button id="call-to-client"><i class="fas fa-phone mr-2"></i>Позвонить</button>
        </div>
        <div class="col-2 pl-0">
            <a href="/tools/callback">
                <button><i class="fas fa-comment"></i></button>
            </a>
        </div>
    </div>
</div>
<div class="modal-overlay open-modal" style="display: none;">
    <div class="modal-contact" style="display: none;">
        <h2>Контактные данные</h2>
        <p><i class="far fa-user mr-2"></i><?php echo $first_name; ?><span><?php echo $city; ?>
                , <?php echo $region; ?></span></p>
        <? if (!empty($phone)): ?>
            <p class="m-0"> <?= Html::img(User::getPhoneProviderIcons()[$phone_provider], ['class' => 'mr-2']) ?><a
                        href="tel:<?php echo $phone; ?>"> <?php echo $phone; ?></a></p>
        <?php endif; ?>
        <? if (!empty($phone_2)): ?>
            <p class="m-0"><?= Html::img(User::getPhoneProviderIcons()[$phone_provider_2], ['class' => 'mr-2']) ?><a
                        href="tel:<?php echo $phone_2; ?>"> <?php echo $phone_2; ?></a></p>
        <?php endif; ?>
        <? if (!empty($phone_3)): ?>
            <p class="m-0"><?= Html::img(User::getPhoneProviderIcons()[$phone_provider_3], ['class' => 'mr-2']) ?><a
                        href="tel:<?php echo $phone_3; ?>"> <?php echo $phone_3; ?></a></p>
        <?php endif;
        ?>
        <i id="close" class="fas fa-times"></i>
    </div>
    <div class="modal-complay-success" style="display: none;">
<h2>Ваша жалоба отправлена</h2>
        <p>Наш модератор проверит это объявление.<br>Спасибо, что помогаете нам!</p>
        <i id="close-complay" class="fas fa-times"></i>
    </div>
    <div class="modal-contact-credit" style="display: none;">
        <div class="credit-cuns">
            <h2>Консультация по кредиту</h2>
            <div class="row mb-1">
                <div class="col-2">
                    <img src="/theme/images/mts-icon.png">
                </div>
                <div class="col-10 pl-0">
                    <a href="tel:375333215555">+375 (33)
                        321-55-55</a>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-2">
                    <img src="/theme/images/velcom-icon.png">
                </div>
                <div class="col-10 pl-0">
                    <a href="tel:375445185555">+375 (44)
                        518-55-55</a>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-2">
                    <img style="margin-top: 8px;" src="/theme/images/life-icon.png">
                </div>
                <div class="col-10 pl-0">
                    <a href="tel:375257185555">+375 (25)
                        718-55-55</a>
                </div>
            </div>

            <p class="time-work mt-3">Пн - вс: 10:00 - 18:00 Ежедневно</p>
        </div>
        <i id="close-credit" class="fas fa-times"></i>
    </div>
</div>
<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="/">Главная<i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <?php if ($product->type !== ProductType::BOAT){
                ?>
            <li>

                <a href="<?php echo Url::UrlBaseCategory($product->type); ?>">Каталог <?php echo $nameProductType; ?>
                    <i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li>
                <a href="<?php echo Url::UrlCategoryBrand($product->type, $product->make); ?>"><?php echo $product->make; ?>
                    <i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li>
                <a href="<?php echo Url::UrlCategoryModel($product->type, $product->make, $product->makeid); ?>"><?php echo $product->model; ?>
                    <i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
            <li><span class="no-link ml-lg-2"><?= $product->make ?> <?= $model->model ?></span></li>
            <?php
            }
            else {
                    ?>
                <li>

                    <a href="/boat">Каталог водного трансопрта
                        <i class="fas fa-chevron-right ml-1 ml-lg-2"></i></a></li>
                <li><span class="no-link ml-lg-2"><?= $product->make ?> (<?= $product->year ?>)</span></li>


                <?php

            }
            ?>
        </ul>
    </div>
</div>
<main>

    <div class="car-card">
        <div class="container">
            <div class="row publication-info hidden-mobile align-items-center">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-2">
                            <span>№ <?= $product->id ?></span>
                        </div>
                        <div class="col-4">
                            <span><?= Yii::t('app', 'Published') ?> <?= Yii::$app->formatter->asDate($product->created_at) ?></span>
                        </div>
                        <div class="col-4 p-0">
                            <span><?= Yii::t('app', 'Updated') ?> <?= Yii::$app->formatter->asDate($product->updated_at) ?></span>
                        </div>
                        <div class="col-2 p-0">
                            <span><i class="fas fa-eye mr-1"></i> <?= Yii::t('app', '{n,plural,=0{# } =1{# } one{# } other{# }}', ['n' => $views]) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="row align-items-center">
                        <? if (Yii::$app->user->can('deleteOwnProduct', ['model' => $product])): ?>
                            <div class="col-3 p-0">
                                <a href="/update-ads?id=<?= $product->id ?>">
                                    <i class="fas fa-edit mr-1"></i>
                                    <span>
                             Редактировать
                            </span>
                                </a>
                            </div>
                        <?php
                        endif;
                        ?>
                        <div id="bookmarks-desktop" class="col-3">
                            <?php
                            if (Yii::$app->user->isGuest):
                                ?>
                                <a href="#" class="show-modal-login">
                                    <i class="far fa-star"></i>
                                    <span class="">В избранное</span>
                                </a>
                            <?php
                            else:
                                ?>
                                <?php
                                if (Bookmarks::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['product_id' => $product->id])->exists()):
                                    ?>
                                    <a href="#" title="Удалить из закладок"
                                       data-product="<?= $product->id; ?>" id="delete-bookmarks"
                                       class="bookmarks star in-favorite">
                                        <i class="fas fa-star"></i>
                                        <span class="">В избранном</span>
                                    </a>
                                    <a style="display: none;" href="#" class="bookmarks add-car-to-fav"
                                       data-product="<?= $product->id; ?>"
                                       id="add-bookmarks">
                                        <i class="far fa-star"></i>
                                        <span class="">В избранное</span>
                                    </a>
                                <?php
                                else:
                                    ?>
                                    <a href="#" class="bookmarks add-car-to-fav" data-product="<?= $product->id; ?>"
                                       id="add-bookmarks">
                                        <i class="far fa-star"></i>
                                        <span class="">В избранное</span>
                                    </a>
                                    <a style="display:none;" href="#" title="Удалить из закладок"
                                       data-product="<?= $product->id; ?>" id="delete-bookmarks"
                                       class="bookmarks star in-favorite">
                                        <i class="fas fa-star"></i>
                                        <span class="">В избранном</span>
                                    </a>
                                <?php
                                endif;
                                ?>
                            <?php
                            endif;
                            ?>
                        </div>
                        <div class="col-6">
                            <a role="button" id="complay">
                                <i class="fas fa-ban"></i>
                                <span>Пожаловаться на объявление</span>
                            </a>
                            <div id="complaint_block_desktop">
                                <?= Html::beginForm(['/catalog/complaint'], 'post', ['id' => 'complaint_form_desktop', 'class' => 'complay-form']); ?>
                                <?
                                $modelComplain = new Product();
                                $modelComplain->setScenario(Product::SCENARIO_COMPLAIN);
                                ?>
                                <?= Html::hiddenInput('id', $product->id) ?>
                                <?= Html::dropDownList('complaint_type', Complaint::$type_comlaint, Complaint::$type_comlaint) ?>
                                <?= Html::textarea('complaint_text', '', ['rows' => '6', 'placeholder' => 'Введите текст жалобы']) ?>
                                <?= Html::submitButton('Отправить', ['class' => 'custom-button']) ?>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="load-carousel hidden-desktop">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="card-carousel hidden-desktop">
            <?php foreach ($product->image as $i=> $image): ?>
                <?php

                $fullImage = $image->full;

                if ($product->priority == Product::HIGHT_PRIORITY) {
                    if (!empty($image->full_title_image) && $image->full_title_image != null) {
                        $fullImage = $image->full_title_image;
                    }
                }

                ?>
                <div class="car-image">
                    <a data-fancybox="gallery" rel="groupMainProduct" title=""
                       href="<?php echo $fullImage; ?>">

                        <div class="image" style="background-position: center;width: 100%; height: 250px;background-size:cover; background-image: url('<?php echo $fullImage; ?>');">
                            <div class="count-image">
                             <?php echo $i+1;?>
                                /
                                <?php echo count($product->image);?>
                            </div>
                        </div>
                    </a>
                </div>

            <?php
            endforeach;
            ?>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3 pr-lg-0">
                    <div class="row publication-info-mobile align-items-center hidden-desktop">
                        <div class="col-7">
                            <span>№ <?= $product->id ?></span>
                            <span>от <?= Yii::$app->formatter->asDate($product->created_at) ?></span>
                            <span><i class="fas fa-eye mr-1"></i><?= Yii::t('app', '{n,plural,=0{# } =1{# } one{# } other{# }}', ['n' => $views]) ?></span>
                        </div>
                        <div class="col-5 row justify-content-end">
                            <?php
                            if (Yii::$app->user->isGuest):
                                ?>
                                <a href="#" class="show-modal-login">
                                    <i class="far fa-star"></i>
                                </a>
                            <?php
                            else:
                                ?>
                                <?php
                                if (Bookmarks::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['product_id' => $product->id])->exists()):
                                    ?>
                                    <a href="#" title="Удалить из закладок"
                                       data-product="<?= $product->id; ?>" id="delete-bookmarks-mobile"
                                       class="bookmarks-mobile star in-favorite">
                                        <i class="fas fa-star"></i>
                                    </a>

                                    <a style="display:none;" href="#" class="bookmarks-mobile add-car-to-fav"
                                       data-product="<?= $product->id; ?>"
                                       id="add-bookmarks-mobile">
                                        <i class="far fa-star"></i>
                                    </a>
                                <?php
                                else:
                                    ?>
                                    <a style="display: none" href="#" title="Удалить из закладок"
                                       data-product="<?= $product->id; ?>" id="delete-bookmarks-mobile"
                                       class="bookmarks-mobile star in-favorite">
                                        <i class="fas fa-star"></i>
                                    </a>
                                    <a href="#" class="bookmarks-mobile add-car-to-fav"
                                       data-product="<?= $product->id; ?>"
                                       id="add-bookmarks-mobile">
                                        <i class="far fa-star"></i>
                                    </a>
                                <?php
                                endif;
                                ?>
                            <?php
                            endif;
                            ?>

                            <a role="button" id="complay-mob"><i class="fas fa-ban"></i></a>
                        </div>
                    </div>
                    <div id="complaint_block_mobile" class="hidden-desktop">
                        <?= Html::beginForm(['/catalog/complaint'], 'post', ['id' => 'complaint_form_mobile', 'class' => 'complay-form complay-form-mobile col-12']); ?>
                        <?
                        $modelComplain = new Product();
                        $modelComplain->setScenario(Product::SCENARIO_COMPLAIN);
                        ?>
                        <?= Html::hiddenInput('id', $product->id) ?>
                        <?= Html::dropDownList('complaint_type', Complaint::$type_comlaint, Complaint::$type_comlaint) ?>
                        <?= Html::textarea('complaint_text', '', ['rows' => '6', 'placeholder' => 'Введите текст жалобы']) ?>
                        <?= Html::submitButton('Отправить', ['class' => 'custom-button']) ?>
                        <?= Html::endForm() ?>
                    </div>
                    <div class="row car-info">
                        <div class="col-12 car-name">
                            <h2><a href="#"><?= $product->make ?> <?php if ($product->type !== ProductType::BOAT){ echo  $model->model;} ?>, <?= $model->year ?></a></h2>
                        </div>
                        <div class="col-12 car-price">
                                <span class="price-rb"> <? echo Yii::$app->formatter->asDecimal($product->price_byn); ?>
                                    BYN</span><span
                                    class="price-dol"><?= Yii::$app->formatter->asDecimal($product->price_usd) ?>
                                $</span>
                            <?php if ($product->exchange): ?>  <span
                                    class="auction hidden-desktop">  Обмен </span><?php endif; ?>
                            <?php if ($product->auction): ?>  <span class="auction">  Торг </span><?php endif; ?>
                        </div>
                        <div class="col-12">

                            <div class="row">
                                <div class="col-5"><span>Год выпуска</span></div>
                                <div class="col-7"><strong><?= $product->year ?></strong></div>
                            </div>

                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[0]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[0]->format) ?> <?= $product->spec[0]->unit ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[2]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[2]->format) ?> <?= $product->spec[2]->unit ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[4]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[4]->format) ?> <?= $product->spec[4]->unit ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[6]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[6]->format) ?> <?= $product->spec[6]->unit ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[1]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[1]->format) ?> <?= $product->spec[1]->unit ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[3]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[3]->format) ?> <?= $product->spec[3]->unit ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[5]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[5]->format) ?> <?= $product->spec[5]->unit ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><span><?= $product->spec[7]->name ?></span></div>
                                <div class="col-7">
                                    <strong><?= Html::encode($product->spec[7]->format) ?> <?= $product->spec[7]->unit ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 location hidden-desktop">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= $city; ?>, Беларусь</span>
                        </div>
                        <div class="col-12">
                            <button class="seller-phone hidden-desktop"><i class="fas fa-phone mr-2"></i>Телефон
                                продавца
                            </button>
                        </div>
                    </div>
                    <a href="#" id="credit-consultation" class="custom-button hidden-desktop credit-consultation">
                        <span style="color: white"> Консультация
                        по кредиту</span></a>
                    <div class="online-request">
                        <h2>ONLINE-заявка на кредит</h2>
                        <p>Заполните анкету в удобное для Вас время, мы примем ее и свяжемся с Вами</p>
                        <a href="/tools/credit-application?id=<?= $product->id; ?>" class="custom-button"><i
                              style="color: white"      class="fas fa-pencil-alt mr-2"></i><span style="color: white"> Заполнить
                            заявку</span></a>
                    </div>
                    <div class="row car-info-tabs hidden-desktop">
                        <div class="col-lg-3">
                            <ul class="nav row nav-tabs " id="myTab" role="tablist">
                                <li class="nav-item col-6 p-0">
                                    <a class="nav-link active text-center" id="seller-comment-tab" data-toggle="tab"
                                       href="#seller-comment" role="tab" aria-controls="seller-comment"
                                       aria-selected="true">Комментарии продавца</a>
                                </li>
                                <li class="nav-item col-6 p-0">
                                    <a class="nav-link text-center" id="credit-info-tab" data-toggle="tab"
                                       href="#credit-info" role="tab" aria-controls="credit-info"
                                       aria-selected="false">Информация о кредите</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content car-info-tab-content hidden-desktop" id="myTabContent">
                        <div class="tab-pane fade show active" id="seller-comment" role="tabpanel"
                             aria-labelledby="seller-comment-tab">
                            <p>
                                <?= Html::encode($product->seller_comments) ?>

                            </p>
                        </div>
                        <div class="tab-pane fade" id="credit-info" role="tabpanel"
                             aria-labelledby="credit-info-tab">
                            <?= $appData['allAboutCredit'] ?>
                        </div>
                    </div>
                    <div class="options hidden-desktop">
                        <h2>Дополнительные характеристики</h2>
                        <?
                        if (count($product->spec_additional) > 0):
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <ul>
                                        <?php
                                        foreach ($product->spec_additional as $i => $spec_additional): ?>


                                            <li><?php echo $spec_additional->name; ?></li>

                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-12 order-lg-1">
                            <div class="b-detail__main-aside-payment-form">
                                <div class="calculator-loan" style="display: none;"></div>
                                <form action="/" method="post" class="credit-calculator js-loan">
                                    <h2>Кредитный калькулятор</h2>
                                    <label><?= Yii::t('app', 'ENTER LOAN AMOUNT') ?></label>
                                    <input type="text" placeholder="<?= Yii::t('app', 'LOAN AMOUNT') ?>"
                                           value="<? echo $product->price_byn; ?>" name="price" disabled="disabled"/>
                                    <label><?= Yii::t('app', 'Prepayment') ?></label>
                                    <input type="number" placeholder="<?= Yii::t('app', 'Prepayment') ?>"
                                           value="0" name="prepayment" id="prepayment" min="0"
                                           max="<? echo $product->price_byn; ?>"/>
                                    <label><?= Yii::t('app', 'RATE IN') ?> %</label>
                                    <select name="rate" class="m-select" id="rate">
                                        <option value="<?= $appData['prior_bank'] ?>">
                                            Приорбанк <?= $appData['prior_bank'] ?>%
                                        </option>
                                        <option value="<?= $appData['vtb_bank'] ?>">ВТБ <?= $appData['vtb_bank'] ?>%
                                        </option>
                                        <option value="<?= $appData['idea_bank'] ?>">Идея
                                            Банк <?= $appData['idea_bank'] ?>%
                                        </option>
                                        <option value="<?= $appData['bta_bank'] ?>">БТА <?= $appData['bta_bank'] ?>%
                                        </option>
                                        <option value="<?= $appData['status_bank'] ?>">
                                            СтатусБанк <?= $appData['status_bank'] ?>%
                                        </option>
                                    </select>

                                    <label><?= Yii::t('app', 'LOAN TERM') ?></label>
                                    <select name="term" class="m-select" id="term">
                                        <option value="6m"><?= Yii::t('app', '6 month') ?></option>
                                        <option value="12m"><?= Yii::t('app', 'One year') ?></option>
                                        <option value="24m"><?= Yii::t('app', '2 years') ?></option>
                                        <option value="36m"><?= Yii::t('app', '3 years') ?></option>
                                        <option value="48m"><?= Yii::t('app', '4 years') ?></option>
                                        <option value="60m"
                                                selected><?= Yii::t('app', '5 years') ?></option>
                                    </select>

                                    <div class="js-loan-results">
                                        <p><strong> <span class="js-per-month"> </span> BYN</strong>/ месяц</p>
                                    </div>
                                    <button type="submit" class="custom-button">Рассчитать платежи <i
                                                class="fas fa-chevron-right ml-2"></i></button>

                                </form>
                                <button class="custom-button download-income-card"><i class="fas fa-download mr-2"></i>Справка
                                    о доходах
                                </button>
                            </div>

                        </div>
                        <div class="col-12 order-lg-0">
                            <div class="about-credit">
                                <div class="row header-about-credit align-items-center">
                                    <div class="col-4">
                                        <strong>Кредит</strong>
                                    </div>
                                    <div class="col-8 text-right">
                                        <span>от 3 месяцев до 5 лет</span>
                                    </div>
                                </div>


                                <div class="credit-cuns hidden-mobile">
                                    <h2>Консультация по кредиту</h2>
                                    <a href="tel:375333215555"><img src="/theme/images/mts-icon.png">+375 (33)
                                        321-55-55</a>
                                    <a href="tel:375445185555"><img src="/theme/images/velcom-icon.png">+375 (44)
                                        518-55-55</a>
                                    <a href="tel:375257185555"><img src="/theme/images/life-icon.png"> +375 (25)
                                        718-55-55</a>
                                    <p class="time-work">Пн - вс: 10:00 - 18:00
                                        <br>Ежедневно</p>
                                </div>
                                <ul>
                                    <li>с досрочным погашением</li>
                                    <li>без справки о доходах</li>
                                    <li>без первоначального взноса и поручителей</li>
                                    <li>без привязки к курсу валют</li>
                                </ul>
                                <p>*Если сумма кредита превышает 5000 руб. потребуется справка о доходах за 3
                                    месяца.</p>
                                <p><strong>Cтарый автомобиль в зачёт!</strong></p>
                            </div>
                            <div class="buying-types hidden-mobile">
                                <h5>Варианты покупки</h5>
                                <a class="custom-button" href="/avto-v-kredit"><i
                                            class="fas fa-dollar-sign mr-1"></i>Кредит</a>
                                <?php if ($product->exchange): ?>
                                    <a href="/obmen-avto" class="custom-button"><i class="fas fa-sync-alt mr-1"></i>Обмен</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="car-info hidden-mobile">
                        <div class="fotorama" data-nav="thumbs" data-thumbheight="152" data-thumbwidth="152"
                             data-allowfullscreen="true"
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
                                <div class="fotorama__wrap-link" data-img="<?= $image->full ?>"
                                     data-thumb="<?= $image->thumbnail ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <ul class="nav row nav-tabs mt-3" id="myTab2" role="tablist">
                                    <li class="nav-item col-6 p-0">
                                        <a class="nav-link active" id="seller-comment2-tab" data-toggle="tab"
                                           href="#seller-comment2" role="tab" aria-controls="seller-comment2"
                                           aria-selected="true">Комментарии продавца</a>
                                    </li>
                                    <li class="nav-item col-6 p-0">
                                        <a class="nav-link" id="credit-info2-tab" data-toggle="tab"
                                           href="#credit-info2" role="tab" aria-controls="credit-info2"
                                           aria-selected="false">Информация о кредите</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="seller-comment2" role="tabpanel"
                                 aria-labelledby="seller-comment2-tab">
                                <?= Html::encode($product->seller_comments) ?>
                            </div>
                            <div class="tab-pane fade" id="credit-info2" role="tabpanel"
                                 aria-labelledby="credit-info2-tab">
                                <?= $appData['allAboutCredit'] ?>
                            </div>
                        </div>
                        <div class="options">
                            <h2>Дополнительные характеристики</h2>
                            <?
                            if (count($product->spec_additional) > 0):
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <ul>
                                            <?php
                                            foreach ($product->spec_additional as $i => $spec_additional): ?>


                                                <li><?php echo $spec_additional->name; ?></li>

                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="seller-info">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <?php if (!empty($first_name)): ?>
                                        <i class="far fa-user mr-2"></i><span><?= $first_name ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo $city; ?></span>
                                </div>
                                <div class="col-3">
                                    <div class="show-all-phone">
                                        <i class="fas fa-phone mr-2"></i>
                                        <a href="tel:<?= $phone ?>"><?= $phone ?><?php if ((!empty($phone_2)) || (!empty($phone_3))): ?>
                                                <i class="fas fa-chevron-down ml-1"></i><?php endif; ?></a>

                                        <?php if ((!empty($phone_2)) || (!empty($phone_3))): ?>
                                            <ul class="col-11 phone-view-all dropdown-menu">
                                                <?php if (!empty($phone_2)): ?>
                                                    <li class="dropdown-item">
                                                        <a href="tel:<?= $phone_2 ?>">
                                                            <i class="fas fa-phone"></i><?= $phone_2 ?> </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if (!empty($phone_3)): ?>
                                                    <li class="dropdown-item">
                                                        <a href="tel:<?= $phone_3 ?>">
                                                            <i class="fas fa-phone"></i><?= $phone_3 ?> </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-3 text-right">
                                    <a href="/tools/callback" class="custom-button"><i
                                                class="fas fa-comment mr-2"></i><span>Написать
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($videoModel != null):
                        ?>
                        <div class="popular-videos">
                            <h2>Популярные видео о модели</h2>
                            <div class="row videos-container">
                                <?php
                                foreach ($videoModel as $video):
                                    ?>
                                    <div class="video-item col-lg-4">
                                        <div class="car-video">
                                            <iframe src="https://www.youtube.com/embed/<? echo $video->video_url; ?>"
                                                    frameborder="0" allow="autoplay; encrypted-media"
                                                    allowfullscreen></iframe>
                                        </div>
                                        <a href="https://www.youtube.com/embed/<? echo $video->video_url; ?>"
                                           class="video-description"
                                           target="_blank">Обзор <?= $product->make ?> <?= $model->model ?></a>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                    ?>
                    <?php
                    if ($modifications != null):
                        ?>
                        <div class="encyclopedia">
                            <h2>Энциклопедия <?= $product->make ?> <?= $model->model ?></h2>
                            <?php foreach ($modifications as $modification):
                                $imagesModel = ImageModifications::find()->where(['modifications_id' => $modification->id])->all();
                                $imagesCount = ImageModifications::find()->where(['modifications_id' => $modification->id])->count();
                                ?>
                                <div class="row enc-container m-0">
                                    <?php
                                    foreach ($imagesModel as $image):
                                        ?>
                                        <a class="enc-block" href="#">
                                            <div class="enc-image">
                                                <div class="image"
                                                     style="background-image: url('<? echo $image->img_url; ?>');">
                                                </div>
                                            </div>
                                        </a>

                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <a href="#" class="more show-all-mod" id="<?php echo $modification->id; ?>"
                                   data-url="/modification/load-modification?id=<?php echo $modification->id; ?>">Показать <?php
                                    echo AutoSearch::getCountModifications($modification->id);
                                    ?> модификаций <i
                                            class="fas fa-chevron-right"></i></a>
                                <div id="block-<?php echo $modification->id; ?>">
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="ads-block mt-4 mb-3">
                        <!-- Yandex.RTB R-A-288803-3 -->
                        <div id="yandex_rtb_R-A-288803-3"></div>
                        <script type="text/javascript">
                            (function(w, d, n, s, t) {
                                w[n] = w[n] || [];
                                w[n].push(function() {
                                    Ya.Context.AdvManager.render({
                                        blockId: "R-A-288803-3",
                                        renderTo: "yandex_rtb_R-A-288803-3",
                                        async: true
                                    });
                                });
                                t = d.getElementsByTagName("script")[0];
                                s = d.createElement("script");
                                s.type = "text/javascript";
                                s.src = "//an.yandex.ru/system/context.js";
                                s.async = true;
                                t.parentNode.insertBefore(s, t);
                            })(this, this.document, "yandexContextAsyncCallbacks");
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    if ((!empty($product->similar)) && ($product->type !== ProductType::BOAT)): ?>
        <div class="relative-products">
            <div class="container">
                <h2>Похожие объявления</h2>
                <div class="catalog-cars-container">


                    <?php foreach ($product->similar as $similarProduct):

                        $similarProduct->price_byn = Product::getByrPriceProduct($similarProduct->id);
                        $similarProduct->price_usd = Product::getUsdPriceProduct($similarProduct->id);
                        $sumMonth = CreditApplication::getMonthPayment($similarProduct->price_byn);
                        ?>
                        <div class="catalog-item">
                            <div class="catalog-item-img">
                                <a href="<?= Url::UrlShowProduct($similarProduct->id) ?>"><img
                                            title="<?= $similarProduct->full_title ?>"
                                            alt="<?= $similarProduct->full_title ?>"
                                            src="<?= $similarProduct->main_image_url ?>"></a>
                            </div>
                            <div class="catalog-item-description">
                                <div class="description-header">
                                    <h2>
                                        <a href="<?= Url::UrlShowProduct($similarProduct->id) ?>"><?php  echo $similarProduct->full_title; ?></a>
                                    </h2>
                                    <?php if ($similarProduct->exchange): ?> <span> Обмен </span><?php endif; ?>
                                    <?php if ($similarProduct->auction): ?>  <span>  Торг </span><?php endif; ?>
                                </div>
                                <div class="description-text">
                                    <?php foreach ($similarProduct->spec as $i => $spec): ?>
                                       <?php if ($i == 1):
                                        ?>
                                        <?= $spec->priority_hight->value ?> см<sup>3</sup>,
                                        <?
                                    endif;
                                        ?>
                                        <?php
                                        if ($i == 3):
                                            ?>
                                            <?= $spec->priority_hight->value ?>,
                                        <?
                                        endif;
                                        ?>
                                        <?php
                                        if ($i == 4):
                                            ?>
                                            <?= $spec->priority_hight->value ?>
                                        <?
                                        endif;
                                        ?>
                                        <?php


                                        if ($i == 0):
                                            ?>
                                            <?= $spec->priority_hight->value ?>,
                                        <?
                                        endif;
                                        ?>
                                    <?php endforeach;
                                    ?>
                                </div>
                                <div class="description-price">
                                    <span class="price-rb"><?php echo $similarProduct->price_byn; ?> BYN</span><span
                                            class="price-dol"><?php echo $similarProduct->price_usd; ?> $</span>
                                </div>
                            </div>
                            <div class="favorite">
                                <?php
                                if (Yii::$app->user->isGuest):
                                    ?>
                                    <a href="#" class="show-modal-login">
                                        <i class="far fa-star"></i>

                                    </a>
                                <?php
                                else:
                                    ?>
                                    <?php
                                    if (Bookmarks::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['product_id' => $similarProduct->id])->exists()):
                                        ?>
                                        <a style="display: none" id="add-bookmarks-<?= $similarProduct->id; ?>"
                                           title="Добавить в закладки" href="#"
                                           class="bookmarks-relative add-car-to-fav"
                                           data-product="<?= $similarProduct->id; ?>" data-action="add-bookmarks">
                                            <i class="far fa-star"></i>

                                        </a>
                                        <a id="delete-bookmarks-<?= $similarProduct->id; ?>" href="#"
                                           title="Удалить из закладок"
                                           data-product="<?= $similarProduct->id; ?>" data-action="delete-bookmarks"
                                           class="bookmarks-relative star in-favorite">
                                            <i class="fas fa-star"></i>

                                        </a>

                                    <?php
                                    else:
                                        ?>
                                        <a id="add-bookmarks-<?= $similarProduct->id; ?>" title="Добавить в закладки"
                                           href="#" class="bookmarks-relative add-car-to-fav"
                                           data-product="<?= $similarProduct->id; ?>" data-action="add-bookmarks">
                                            <i class="far fa-star"></i>

                                        </a>
                                        <a style="display: none" id="delete-bookmarks-<?= $similarProduct->id; ?>"
                                           href="#" title="Удалить из закладок"
                                           data-product="<?= $similarProduct->id; ?>" data-action="delete-bookmarks"
                                           class="bookmarks-relative star in-favorite">
                                            <i class="fas fa-star"></i>

                                        </a>
                                    <?php
                                    endif;
                                    ?>
                                <?php
                                endif;
                                ?>
                                <a href="#" class="dollar add-to-favorite">
                                    <i class="fas fa-dollar-sign"></i>
                                    <span class="add-tooltip"><?php echo $sumMonth; ?> руб. в месяц</span>
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        </div>
    <?

    endif;
    ?>
</main>