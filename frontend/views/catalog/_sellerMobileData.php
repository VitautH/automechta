<?php
use yii\helpers\Html;
use common\models\User;
use common\models\Region;
use common\models\City;

$region = Region::getRegionName($region);
$city = City::getCityName($city);
?>
<?php if (!empty($first_name)): ?>
    <p>
        <span class="seller-name"><?= $first_name ?></span>
    </p>
    <br>
<?php endif; ?>
<?php if (!empty($region)): ?>
    <p>
        <?php if ($region != $city) {
            echo $city . ', ';
        }
        echo $region;
        ?>
    </p>
<?php endif ?>
<span id="seller-phone-show" class="seller-phone-btn"><span class="fa fa-phone"></span> <?= Yii::t('app', 'Seller phone') ?> </span>
<div class="seller-phone-block">
    <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider], ['style' => 'height:22px']) ?>
        </span>
    <a class="seller-phone-number" href="tel:<?= $phone ?>"><?= $phone ?></a>
    <? if (!empty($phone_2)): ?>
        <br>
        <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider_2], ['style' => 'height:22px']) ?>
        </span>
        <a class="seller-phone-number" href="tel:<?= $phone_2 ?>"><?= $phone_2 ?></a>
        <?php
    endif;
    ?>
    <? if (!empty($phone_3)): ?>
        <br>
        <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider_3], ['style' => 'height:22px']) ?>
        </span>
        <a class="seller-phone-number" href="tel:<?= $phone_3 ?>"><?= $phone_3 ?></a>
        <?php
    endif;
    ?>
    <span class="cancel">Отменить</span>
</div>
<span id="credit-phone-show" class="credit-phone-btn"><span class="fa fa-phone"></span>Консультация по кредиту</span>
<div class="credit-phone-block">
    <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[ $appData['phone_credit_provider_1']], ['style' => 'height:22px']) ?>
        </span>
    <a  class="credit-phone-number"  href="tel:<?= $appData['phone_credit_1'] ?>"><?= $appData['phone_credit_1'] ?></a>
    <br>
    <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[ $appData['phone_credit_provider_2']], ['style' => 'height:22px']) ?>
        </span>
    <a  class="credit-phone-number"  href="tel:<?= $appData['phone_credit_2'] ?>"><?= $appData['phone_credit_2'] ?></a>
    <br>
    <span class="icon-phone-provider">
        <?= Html::img(User::getPhoneProviderIcons()[ $appData['phone_credit_provider_3']], ['style' => 'height:22px']) ?>
        </span>
    <a  class="credit-phone-number"  href="tel:<?= $appData['phone_credit_3'] ?>"><?= $appData['phone_credit_3'] ?></a>
    <span class="cancel">Отменить</span>
</div>
<a class="online-credit-btn" href="/tools/credit-application?id=<?=$product->id;?>">Онлайн заявка на кредит</a>