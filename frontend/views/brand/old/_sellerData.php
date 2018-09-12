<?php
use yii\helpers\Html;
use common\models\User;
?>

    <h2 class="s-titleDet"><?= Yii::t('app', 'Seller phone') ?></h2>
<?php if (!empty($seller->phone) && !empty($seller->phone_provider)): ?>
    <p>
        <?= Html::img(User::getPhoneProviderIcons()[$seller->phone_provider], ['style'=>'height:22px']) ?> <a href="tel:<?= $seller->phone ?>"><?= $seller->phone ?></a>
    </p>
<?php endif; ?>
<?php if (!empty($seller->phone_2)): ?>
    <p>
        <?= Html::img(User::getPhoneProviderIcons()[$seller->phone_provider_2], ['style'=>'height:22px']) ?> <a href="tel:<?= $seller->phone_2 ?>"><?= $seller->phone_2 ?></a>
    </p>
<?php endif; ?>
<?php if (!empty($seller->region)): ?>
    <h2 class="s-titleDet"><?= Yii::t('app', 'Region') ?></h2>
    <p>
        <?= User::getRegions()[$seller->region] ?>
    </p>
<?php endif ?>