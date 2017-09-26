<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$this->title = $name;
?>
<section class="b-error s-shadow">
    <div class="container">
        <?php 
            if ($message == Yii::t('app', 'Please confirm your registration')){
        ?>
			<h2 class="s-title">На ваш e-mail отправлено письмо с ссылкой для подтверждения регистрации.</h2> 
			<p>Спасибо за регистрацию на нашем сайте. Пожалуйста, активируйте регистрацию, перейдя по ссылке в письме, отправленном на ваш email.</p>
		<?php
    	   } else { 
        ?>
            <h1 class="wow zoomInUp" data-wow-delay="0.7s"><?= Html::encode($exception->statusCode) ?></h1>
            <h2 class="s-lineDownCenter wow zoomInUp" data-wow-delay="0.7s"><?= nl2br(Html::encode($message)) ?></h2>
            <p class="wow zoomInUp" data-wow-delay="0.7s"><?= Html::encode($this->title) ?></p>
        <?php } ?>
    </div>
</section><!--b-error-->
