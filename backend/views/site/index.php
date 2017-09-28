<?php
use common\models\Product;
use common\models\CreditApplication;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$products = Product::find()->notVerified()->orderBy('created_at DESC')->all();
$creditApplication = CreditApplication::find()->orderBy('created_at DESC')->active()->all();

?>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-shadow--2dp mdl-cell--12-col">
        <div class="mdl-grid">
            <?php if(count($products) > 0): ?>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
                    <div class="mdl-card-wide mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title">
                            <br>
                            <br>
                            <h2 style="overflow: visible;" class="mdl-card__title-text mdl-badge" data-badge="<?= count($products) ?>">
                                Новые объявления
                            </h2>
                        </div>
                        <div class="mdl-card__supporting-text">
В каталоге <b><?= count($products) ?></b> объявлений ожидают подтверждения для публикации.<br><br>
Дата пуликации: <br>
От: <b><?= Yii::$app->formatter->asDate($products[count($products)-1]->created_at) ?></b><br>
До: <b><?= Yii::$app->formatter->asDate($products[0]->created_at) ?></b><br>
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="<?= Url::to(['product/index', 'ProductSearch[status]' => Product::STATUS_TO_BE_VERIFIED]) ?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                Перейти
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(count($creditApplication) > 0): ?>
            <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
                <div class="mdl-card-wide mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                        <br>
                        <br>
                        <h2 style="overflow: visible;" class="mdl-card__title-text  mdl-badge" data-badge="<?= count($creditApplication) ?>">Заявки на кредит</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        Количество заявок на кредит: <b><?= count($creditApplication) ?></b> <br><br>
                        Дата создания: <br>
                        От: <b><?= Yii::$app->formatter->asDate($creditApplication[count($creditApplication)-1]->created_at) ?></b><br>
                        До: <b><?= Yii::$app->formatter->asDate($creditApplication[0]->created_at) ?></b><br>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <a href="/credit-application/index?CreditApplicationSearch%5Bstatus%5D=1" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                            Перейти
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if($complaint > 0): ?>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
                    <div class="mdl-card-wide mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title">
                            <br>
                            <br>
                            <h2 style="overflow: visible;" class="mdl-card__title-text  mdl-badge" data-badge="<?= count($complaint) ?>">Количество жалоб</h2>
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="/complaint" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                Перейти
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
