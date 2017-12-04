<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;
use \common\models\Product;
use \common\models\ProductMake;
use yii\widgets\MaskedInput;

$name = Yii::t('app', 'Products');
$currentLang = Yii::$app->language;
$this->title = $name;
$this->registerCss("
    input[name='ProductSearch[phone]'] {
    width: 75px;
    margin-top: 30px;
    border: 0;
    border-bottom: 1px solid lightgrey;
}
");
$this->registerJs("require(['controllers/product/index']);", \yii\web\View::POS_HEAD);
$makesList = ProductMake::getMakesList();
$makesList[0] = Yii::t('app', 'Any');
ksort($makesList);

$this->registerJs("
$(document).ready(function(){
$('#apply').click(function(){
var check = confirm('Вы действительно хотите произвести действия?');
if (check == true) {
var action =  $('#action').val();
var selection = new Array();
 $(\"input[name='selection[]']:checked\").each( function () {
       selection.push( $(this).val() );
   });
if (selection.length === 0){
alert('Выберите минимум одно объявление!');
}
else {
 $.ajax({
            url: '/product/change',
            type: 'POST',
            data: {ads: selection, action: action},
             success: function(data) {
             location.reload();
             }
         });
         }
         }
});

});
" );
?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2><?= $name ?></h2>
        <a class="js-create-product mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--colored page-header__fab"
           href="<?= Url::to(['product/create']) ?>">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-shadow--2dp">
        <?php \yii\widgets\Pjax::begin([
            'id' => 'product_grid_wrapper',
            'linkSelector' => '#producttype_grid_wrapper a:not(.button-col a)'
        ]); ?>
        <?=
        GridView::widget([
            'id' => 'product_grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
           // 'showFooter'=>true,
            'tableOptions' => [
                'class' => 'mdl-data-table mdl-data-table--no-border mdl-js-data-table'
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                ],
                [
                    'attribute' => 'id',
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                    'headerOptions' => ['style' => 'width: 70px;'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'id')
                ],
                [
                    'label' => $searchModel->getAttributeLabel('make'),
                    'value' => function (Product $model, $key, $index, $column) {
                        $make = $model->getMake0()->one();
                        return $make->name;
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'make', $makesList),
                ],
                [
                    'label' => $searchModel->getAttributeLabel('model'),
                    'value' => function ($model, $key, $index, $column) {
                        return $model->model;
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'model')
                ],

                [
                    'label' => $searchModel->getAttributeLabel('year'),
                    'value' => function ($model, $key, $index, $column) {
                        return $model->year;
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'year')
                ],
                [
                    'attribute' => 'priority',
                    'value' => function ($model, $key, $index, $column) {
                        return Product::getPriorities()[$model->priority];
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'priority', Product::getPriorities(), ['prompt' => Yii::t('app', 'Any')]),
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model, $key, $index, $column) {
                        return Product::getStatuses()[$model->status];
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeDropDownList($searchModel, 'status', Product::getStatuses(), ['prompt' => Yii::t('app', 'Any')]),
                ],
                [
                    'label' => $searchModel->getAttributeLabel('phone'),
                    'value' => function ($model, $key, $index, $column) {
                        return $model->phone;
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MaskedInput::widget([
                        'class' => 'mdl-textfield__input',
                        'model' => $searchModel,
                        'name' => 'ProductSearch[phone]',
                        'mask' => '+375 (99) 999-99-99',
                        'value' => $searchModel->phone
                    ])

                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:m:s'],
                    'headerOptions' => ['style' => 'width: 215px;'],
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'created_at')
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d H:m:s'],
                    'headerOptions' => ['style' => 'width: 215px;'],
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel, 'updated_at')
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'contentOptions' => ['class' => 'button-col'],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::button(
                                '<i class="material-icons red-text">delete</i>',
                                [
                                    'class' => 'mdl-button mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                    'data-delete_url' => Url::to(['product/delete', 'id' => $model->id]),
                                    'title' => Yii::t('app', 'Delete'),
                                ]
                            );
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="material-icons teal-text">mode_edit</i>',
                                Url::to(['product/update', 'id' => $model->id]),
                                [
                                    'class' => 'mdl-button mdl-js-button mdl-button--icon mdl-button--colored',
                                    'title' => Yii::t('app', 'Edit'),
                                ]
                            );
                        }
                    ]
                ],
            ]
        ]);
        ?>
        <label>Выберите действие:</label>
        <select name="action" id="action">
            <option value="<?=Product::STATUS_UNPUBLISHED;?>">Снять с публикации</option>
            <option  value="<?=Product::STATUS_PUBLISHED;?>">Опубликовать</option>
            <option value="delete">Удалить</option>
        </select>
        <button id="apply" name="apply">Применить</button>
        <?php
        \yii\widgets\Pjax::end();
        ?>
    </div>
</div>