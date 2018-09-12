<?
use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;
use \common\models\AutoMakes;
use common\models\AutoModels;
use backend\models\ModificationsSearch;

$makesList = ModificationsSearch::getMakesAll();
$makesList[0] = Yii::t('app', 'Any');
ksort($makesList);

if (!empty($_params_['ModificationsSearch']['make_id'])){
    $makeId = $_params_['ModificationsSearch']['make_id'];
    $modelsList = ModificationsSearch::getModels($makeId);
    $modelsList[0] = Yii::t('app', 'Any');
    ksort($modelsList);
}
else {
    $modelsList = ModificationsSearch::getModelsAll();
    $modelsList[0] = Yii::t('app', 'Any');
    ksort($modelsList);
}


$yearsList = ModificationsSearch::getYears();
$yearsList[0] = Yii::t('app', 'Any');
ksort($yearsList);
$name = 'Модификации';
$currentLang = Yii::$app->language;
$this->title = $name;

?>

<div class="row">
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <?=
            GridView::widget([
                'id' => 'product_grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'role' => 'grid',
                    'class' => 'table table-bordered table-striped dataTable mdl-js-data-table'
                ],
                'rowOptions' => ['role' => 'row', 'class' => 'odd'],
                'columns' => [

                    [
                        'attribute' => 'id',
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'id')
                    ],
                    [
                        'label' => 'Марка',
                        'value' => function ($model, $key, $index, $column) {
                            return AutoMakes::findOne($model->make_id)->name;
                        },
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'make_id', $makesList),
                    ],

                    [
                        'label' => 'Модель',
                        'value' => function ($model, $key, $index, $column) {
                            return AutoModels::findOne($model->model_id)->model;
                        },
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'model_id', $modelsList),
                    ],
                    [
                        'label' => 'Модификация',
                        'attribute' => 'modification_name',
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'modification_name')
                    ],
                    [
                        'label' => 'Год выпуска От:',
                        'attribute' => 'yearFrom',
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'yearFrom', $yearsList),
                    ],
                    [
                        'label' => 'Год выпуска До:',
                        'attribute' => 'yearTo',
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'yearTo', $yearsList),
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'contentOptions' => ['class' => 'button-col'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fa fa-edit"></i>',
                                    Url::to(['modifications/update', 'id' => $model->id]),
                                    [
                                        'class' => 'btn btn-default  mdl-js-button mdl-button--icon mdl-button--colored',
                                        'title' => Yii::t('app', 'Edit'),
                                    ]
                                );
                            }
                        ]
                    ],
                ]
            ]);
            ?>
        </div>
    </div>
</div>