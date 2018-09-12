<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
use common\models\AutoRegions;
use common\models\AutoSpecifications;
use common\models\AutoMakes;

$name = Yii::t('app', 'Авто спецификации');
$this->title = $name;
$this->registerCss("
.cars-params-group-title {
    position: absolute;
    top: -25px;
    font-size: 28px;
    font-weight: bold;
    line-height: 28px;
}
.cars-params-list {
    border: 1px solid #ddd;
    border-radius: 5px;
}
.cars-params-list>div:first-child {
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.cars-params-list>div>div:first-child {
    width: 40%;
}
.cars-params-list>div>div:last-child {
    width: 60%;
}
");
//$this->registerJs("require(['controllers/creditApplication/view']);", \yii\web\View::POS_HEAD);

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
            [
                'attribute' => 'region_id',
                'label'=>'Регион',
                'format' => 'raw',
                'value' => function ($model) {
                    return AutoRegions::findOne($model->region_id)->region_name;
                },
            ],
            [
                'attribute' => 'make_id',
                'label'=>'Марка',
                'format' => 'raw',
                'value' => function ($model) {
                    return AutoMakes::findOne($model->make_id)->name;
                },
            ],
            [
                'attribute' => 'model',
                'label'=>'Модель',
                'format' => 'raw',
            ],
            [
                'attribute' => 'years',
                'label'=>'Год',
            ],
            [
                'attribute' => 'modification',
                'label'=>'Модификация',
            ],
            [
                'attribute' => 'specifications',
                'label'=>'Хар-ка',
                'format' => 'html',
            ],
        ],
    ]);
?>
</div>