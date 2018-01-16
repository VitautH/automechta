<?php
use yii\helpers\Html;
use common\models\User;
use common\models\Region;
use common\models\City;

$region = Region::getRegionName($region);
$city = City::getCityName($city);
?>
    <h2 class="s-titleDet"><?= Yii::t('app', 'Seller phone') ?>: </h2>
<?php if (!empty($phone)): ?>
    <p>
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider], ['style' => 'height:22px']) ?> <a
                href="tel:<?= $phone ?>"><?= $phone ?></a>
    </p>
<?php endif; ?>
<?php if (!empty($phone_2)): ?>
    <p>
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider_2], ['style' => 'height:22px']) ?> <a
                href="tel:<?= $phone_2 ?>"><?= $phone_2 ?></a>
    </p>
<?php endif; ?>
<?php if (!empty($first_name)): ?>
    <p>
        <?= $first_name ?>
    </p>
<?php endif; ?>
<?php if (!empty($region)): ?>
    <h2 class="s-titleDet"><?= Yii::t('app', 'Region') ?>: </h2>
    <p>
        <?= $region;//User::getRegions()[$region] ; ?>
    </p>
    <?php if ($region != $city):

        ?>
        <p>
            <?= $city; ?>
        </p>
        <?php
    endif;
    ?>
<?php endif ?>