<?php

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;
use yii\widgets\MaskedInput;
use common\models\MailingLists;

$this->registerJs("require(['controllers/mailing-lists/index']);", \yii\web\View::POS_HEAD);
$this->registerCss("
#loader {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 99;
    background: #00000057;
}
.spinner {
    position: relative;
    width: 28px;
    height: 28px;
    margin: auto;
    left: auto;
    right: auto;
    top: 50%;
    z-index: 9999;
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
$name = Yii::t('app', 'Рассылка');
$currentLang = Yii::$app->language;
$this->title = $name;
?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2><?= $name ?></h2>
        <a class="js-create-product mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--colored page-header__fab"
           href="<?= Url::to(['mailing-lists/create']) ?>">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-shadow--2dp">
        <div id="loader" style="display:none; ">
            <div class="spinner">
                <div id="circularG_1" class="circularG"></div>
                <div id="circularG_2" class="circularG"></div>
                <div id="circularG_3" class="circularG"></div>
                <div id="circularG_4" class="circularG"></div>
                <div id="circularG_5" class="circularG"></div>
                <div id="circularG_6" class="circularG"></div>
                <div id="circularG_7" class="circularG"></div>
                <div id="circularG_8" class="circularG"></div>
            </div>
        </div>
        <?php \yii\widgets\Pjax::begin([
            'id' => 'mailing-lists_grid_wrapper',
            'linkSelector' => '#mailing-lists_grid_wrapper .button-col a'
        ]); ?>
        <?=
        GridView::widget([
            'id' => 'mailing-lists_grid',
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'mdl-data-table mdl-data-table--no-border mdl-js-data-table'
            ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                    'headerOptions' => ['style' => 'width: 70px;'],
                ],
                [
                    'label' => 'Название рассылки',
                    'attribute' => 'title',
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                    'headerOptions' => ['style' => 'width: 70px;'],
                ],
                [
                    'label' => 'Тип рассылки',
                    'attribute' => 'type',
                    'value' => function ($model, $key, $index, $column) {
                        return MailingLists::getTypes()[$model->type];
                    },
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                    'headerOptions' => ['style' => 'width: 70px;'],
                ],
                [
                    'label' => 'Статус',
                    'attribute' => 'status',
                    'value' => function ($model, $key, $index, $column) {
                        return MailingLists::getStatuses()[$model->status];
                    },
                    'contentOptions' => ['class' => 'status auto-width-col center-align'],
                    'headerOptions' => ['style' => 'width: 70px;'],
                ],
                [
                    'label' => 'Заметка',
                    'attribute' => 'note',
                    'contentOptions' => ['class' => 'status auto-width-col center-align'],
                    'headerOptions' => ['style' => 'width: 70px;'],
                ],
                [
                    'label' => 'Дата созданя',
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:m:s'],
                    'headerOptions' => ['style' => 'width: 215px;'],
                    'contentOptions' => ['class' => 'auto-width-col center-align'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{send}{update}{delete}',
                    'contentOptions' => ['class' => 'button-col'],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::button(
                                '<i class="material-icons red-text">delete</i>',
                                [
                                    'class' => 'mdl-button mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                    'data-delete_url' => Url::to(['mailing-lists/delete', 'id' => $model->id]),
                                    'title' => Yii::t('app', 'Delete'),
                                ]
                            );
                        },
                        'send' => function ($url, $model, $key) {
                            return Html::button(
                                '<i class="material-icons">message</i>',
                                [
                                    'class' => 'send-mailing mdl-button mdl-js-button mdl-button--icon mdl-button--accent js-delete-row',
                                    'data-send_url' => Url::to(['mailing-lists/send', 'type' => $model->type, 'id' => $model->id]),
                                    'title' => Yii::t('app', 'Отправить'),
                                ]
                            );
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="material-icons teal-text">mode_edit</i>',
                                Url::to(['mailing-lists/update', 'id' => $model->id]),
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
        <?php
        \yii\widgets\Pjax::end();
        ?>
    </div>
</div>