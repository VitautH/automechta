<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
use common\models\CreditApplication;

$name = Yii::t('app', 'Credit Applications');
$this->title = $name;

$this->registerJs("require(['controllers/creditApplication/view']);", \yii\web\View::POS_HEAD);

?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2><?= $name ?></h2>
    </div>
</div>


<?php
/* @var $this yii\web\view */
/* @var $model common\models\Page */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\MetaDataWidget;

?>

<div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-cell--12-col-tablet mdl-shadow--2dp">
<?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phone',
            'dob',
            [
                'label' => $model->getAttributeLabel('sex'),
                'value' => CreditApplication::getSexList()[$model->sex],
            ],
            [
                'label' => $model->getAttributeLabel('family_status'),
                'value' => CreditApplication::getFamilyStatueList()[$model->family_status],
            ],
            [
                'label' => $model->getAttributeLabel('previous_conviction'),
                'value' => CreditApplication::getConvictionList()[$model->previous_conviction],
            ],
            'job',
            'experience',
            'salary',
            'loans_payment',
            'product',
            'credit_amount',
            [
                'label' => $model->getAttributeLabel('term'),
                'value' => CreditApplication::getTermList()[$model->term],
            ],
            [
                'label' => $model->getAttributeLabel('information_on_income'),
                'value' => CreditApplication::getInformationOnIncomeList()[$model->information_on_income],
            ],
            'created_at:datetime', // creation date formatted as datetime
        ],
    ]);
?>
</div>