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
        <?php if ($region != $city):

        ?>

        <?= $city.', '; ?>
        <?php
    endif;
    ?>
        <?= $region; ?>
    </p>
<?php endif ?>
    <h2   class="s-titleDet"><?= Yii::t('app', 'Seller phone') ?>: </h2>

<?php //if (!empty($phone)): ?>
    <p>
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider], ['style' => 'height:22px']) ?>

            <a href="tel:<?= $phone ?>"><?= $phone ?></a>
       
    </p>
<?php //endif; ?>
<?php if (!empty($phone_2)): ?>
    <p>
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider_2], ['style' => 'height:22px']) ?> <a
                href="tel:<?= $phone_2 ?>"><?= $phone_2 ?></a>
    </p>
<?php endif; ?>
<?php if (!empty($phone_3)): ?>
    <p>
        <?= Html::img(User::getPhoneProviderIcons()[$phone_provider_3], ['style' => 'height:22px']) ?> <a
                href="tel:<?= $phone_3 ?>"><?= $phone_3 ?></a>
    </p>
<?php endif; ?>
