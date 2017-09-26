<?php
use yii\helpers\Url;
?>
Здравствуйте <?= $user->username ?>!

Уведомляем вас, что ваше объявлние #<?= $model->id ?>: "<?= $model->getFullTitle() ?>" будет снято с публикации через 48 часов.
Вы можете продлить публикацию в личном кабинете:
<?= Url::to('http://automechta.by/account/index') ?>

---
С уважением, команда automechta.by
