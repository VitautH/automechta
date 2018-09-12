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
use common\models\User;

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
$this->registerCss("
#loader{
	position:absolute;
	width:28px;
	height:28px;
	margin: auto;
	left:50px;
}

.circularG{
	position:absolute;
	background-color:rgb(0,0,0);
	width:7px;
	height:7px;
	border-radius:4px;
		-o-border-radius:4px;
		-ms-border-radius:4px;
		-webkit-border-radius:4px;
		-moz-border-radius:4px;
	animation-name:bounce_circularG;
		-o-animation-name:bounce_circularG;
		-ms-animation-name:bounce_circularG;
		-webkit-animation-name:bounce_circularG;
		-moz-animation-name:bounce_circularG;
	animation-duration:1.1s;
		-o-animation-duration:1.1s;
		-ms-animation-duration:1.1s;
		-webkit-animation-duration:1.1s;
		-moz-animation-duration:1.1s;
	animation-iteration-count:infinite;
		-o-animation-iteration-count:infinite;
		-ms-animation-iteration-count:infinite;
		-webkit-animation-iteration-count:infinite;
		-moz-animation-iteration-count:infinite;
	animation-direction:normal;
		-o-animation-direction:normal;
		-ms-animation-direction:normal;
		-webkit-animation-direction:normal;
		-moz-animation-direction:normal;
}

#circularG_1{
	left:0;
	top:11px;
	animation-delay:0.41s;
		-o-animation-delay:0.41s;
		-ms-animation-delay:0.41s;
		-webkit-animation-delay:0.41s;
		-moz-animation-delay:0.41s;
}

#circularG_2{
	left:3px;
	top:3px;
	animation-delay:0.55s;
		-o-animation-delay:0.55s;
		-ms-animation-delay:0.55s;
		-webkit-animation-delay:0.55s;
		-moz-animation-delay:0.55s;
}

#circularG_3{
	top:0;
	left:11px;
	animation-delay:0.69s;
		-o-animation-delay:0.69s;
		-ms-animation-delay:0.69s;
		-webkit-animation-delay:0.69s;
		-moz-animation-delay:0.69s;
}

#circularG_4{
	right:3px;
	top:3px;
	animation-delay:0.83s;
		-o-animation-delay:0.83s;
		-ms-animation-delay:0.83s;
		-webkit-animation-delay:0.83s;
		-moz-animation-delay:0.83s;
}

#circularG_5{
	right:0;
	top:11px;
	animation-delay:0.97s;
		-o-animation-delay:0.97s;
		-ms-animation-delay:0.97s;
		-webkit-animation-delay:0.97s;
		-moz-animation-delay:0.97s;
}

#circularG_6{
	right:3px;
	bottom:3px;
	animation-delay:1.1s;
		-o-animation-delay:1.1s;
		-ms-animation-delay:1.1s;
		-webkit-animation-delay:1.1s;
		-moz-animation-delay:1.1s;
}

#circularG_7{
	left:11px;
	bottom:0;
	animation-delay:1.24s;
		-o-animation-delay:1.24s;
		-ms-animation-delay:1.24s;
		-webkit-animation-delay:1.24s;
		-moz-animation-delay:1.24s;
}

#circularG_8{
	left:3px;
	bottom:3px;
	animation-delay:1.38s;
		-o-animation-delay:1.38s;
		-ms-animation-delay:1.38s;
		-webkit-animation-delay:1.38s;
		-moz-animation-delay:1.38s;
}



@keyframes bounce_circularG{
	0%{
		transform:scale(1);
	}

	100%{
		transform:scale(.3);
	}
}

@-o-keyframes bounce_circularG{
	0%{
		-o-transform:scale(1);
	}

	100%{
		-o-transform:scale(.3);
	}
}

@-ms-keyframes bounce_circularG{
	0%{
		-ms-transform:scale(1);
	}

	100%{
		-ms-transform:scale(.3);
	}
}

@-webkit-keyframes bounce_circularG{
	0%{
		-webkit-transform:scale(1);
	}

	100%{
		-webkit-transform:scale(.3);
	}
}

@-moz-keyframes bounce_circularG{
	0%{
		-moz-transform:scale(1);
	}

	100%{
		-moz-transform:scale(.3);
	}
}
");
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
$('#clear_cache').click(function(){
$.ajax({
            url: '/product/clearcache',
            type: 'POST',
            beforeSend: function() {
     $('#loader').show();
  },
  complete: function(){
     $('#loader').hide();
  },
             success: function(data) {
            if(data == true){
            alert('Кеш очищен!');
            }
            else {
                alert('Произошла ошибка!');
            }
             }
         });
});
$('#indexing_product').click(function(){
$.ajax({
 beforeSend: function() {
     $('#loader').show();
  },
  complete: function(){
     $('#loader').hide();
  },
            url: '/product/indexingproduct',
            type: 'POST',
            success: function(data) {
              if(data == true){
            alert('Индексация товаров завершена!');
            }
            else {
                alert('Произошла ошибка!');
            }
             }
         });
});
});
");
?>
<div id="loader" style="display:none;">
    <div id="circularG_1" class="circularG"></div>
    <div id="circularG_2" class="circularG"></div>
    <div id="circularG_3" class="circularG"></div>
    <div id="circularG_4" class="circularG"></div>
    <div id="circularG_5" class="circularG"></div>
    <div id="circularG_6" class="circularG"></div>
    <div id="circularG_7" class="circularG"></div>
    <div id="circularG_8" class="circularG"></div>
</div>
<div class="row">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Объявления</h3>
            <a class="btn btn-app" href="<?= Url::to(['product/create']) ?>">
                <i class="fa fa-plus"></i> Добавить
            </a>
            <a class="btn btn-app" id="indexing_product">
                <i class="fa fa-repeat"></i> Индексировать товары
            </a>
            <a class="btn btn-app" id="clear_cache">
                <i class="fa fa-trash"></i> Очистить кеш
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <?php \yii\widgets\Pjax::begin([
                'id' => 'product_grid_wrapper',
                'linkSelector' => '#producttype_grid_wrapper a:not(.button-col a)'
            ]); ?>
            <?=
            GridView::widget([
                'id' => 'product_grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'role' => 'grid',
                    'class' => 'table table-bordered table-striped dataTable mdl-js-data-table'
                ],
                'rowOptions' => function ($model) {
                    if ($model->ban == Product::BAN) {
                        return ['role' => 'row','class' => 'danger odd','id'=>'product-'.$model->id,];
                    }
                    else {
                        return ['role' => 'row','class' => 'odd','id'=>'product-'.$model->id,];
                    }
                },
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                    ],
                    [
                        'attribute' => 'id',
                        //'headerOptions' => ['style' => 'width: 70px;'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'id')
                    ],
                    [
                        'attribute' => 'email',
                        'value' => function ($model, $key, $index, $column) {
                            $email = User::find()->where(['id' => $model->created_by])->one()->email;
                            return $email;
                        },
                        //'headerOptions' => ['style' => 'width: 70px;'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'email')
                    ],

                    [
                        'label' => $searchModel->getAttributeLabel('make'),
                        'value' => function (Product $model, $key, $index, $column) {
                            $make = $model->getMake0()->one();
                            return $make['name'];
                        },
                        //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'make', $makesList),
                    ],
                    [
                        'label' => $searchModel->getAttributeLabel('model'),
                        'value' => function ($model, $key, $index, $column) {
                            return $model->model;
                        },
                        //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'model')
                    ],

                    [
                        'label' => $searchModel->getAttributeLabel('year'),
                        'value' => function ($model, $key, $index, $column) {
                            return $model->year;
                        },
                        // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'year')
                    ],
                    [
                        'attribute' => 'priority',
                        'value' => function ($model, $key, $index, $column) {
                            return Product::getPriorities()[$model->priority];
                        },
                        // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'priority', Product::getPriorities(), ['prompt' => Yii::t('app', 'Any')]),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model, $key, $index, $column) {
                            return Product::getStatuses()[$model->status];
                        },
                        //'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeDropDownList($searchModel, 'status', Product::getStatuses(), ['prompt' => Yii::t('app', 'Any')]),
                    ],
                    [
                        'label' => $searchModel->getAttributeLabel('phone'),
                        'value' => function ($model, $key, $index, $column) {
                            return $model->phone;
                        },
                        // 'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
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
                        // 'headerOptions' => ['style' => 'width: 215px;'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'created_at')
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:Y-m-d H:m:s'],
                        // 'headerOptions' => ['style' => 'width: 215px;'],
                        'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                        'filter' => MdlHtml::activeInput('text', $searchModel, 'updated_at')
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}{ban}',
                        'contentOptions' => ['class' => 'button-col'],
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::button(
                                    '<i class="fa fa-trash"></i>',
                                    [
                                        'class' => 'btn btn-default  mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                        'data-delete_url' => Url::to(['product/delete', 'id' => $model->id]),
                                        'title' => Yii::t('app', 'Delete'),
                                    ]
                                );
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fa fa-edit"></i>',
                                    Url::to(['product/update', 'id' => $model->id]),
                                    [
                                        'class' => 'btn btn-default  mdl-js-button mdl-button--icon mdl-button--colored',
                                        'title' => Yii::t('app', 'Edit'),
                                    ]
                                );
                            },
                            'ban' =>function ($url, $model,$key){
                return Html::a('<i class="fa fa-ban"></i>',
                                    Url::to(['product/ban', 'id' => $model->id]),
                                    [
                                        'class' => 'add-to-ban btn btn-default  mdl-js-button mdl-button--icon mdl-button--colored',
                                        'title' => Yii::t('app', 'Ban'),
                                    ]);
                            }
                        ]
                    ],
                ]
            ]);
            ?>
            <label>Выберите действие:</label>
            <select name="action" id="action">
                <option value="<?= Product::STATUS_UNPUBLISHED; ?>">Снять с публикации</option>
                <option value="<?= Product::STATUS_PUBLISHED; ?>">Опубликовать</option>
                <option value="delete">Удалить</option>
            </select>
            <button id="apply" name="apply">Применить</button>
            <?php
            \yii\widgets\Pjax::end();
            ?>
        </div>
    </div>
</div>
