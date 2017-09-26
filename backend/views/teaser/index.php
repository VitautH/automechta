<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\TeaserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;

$name = Yii::t('app', 'Teaser');
$currentLang = Yii::$app->language;
$this->title = $name;
$this->registerJs("require(['controllers/teaser/index']);", \yii\web\View::POS_HEAD);
?>
<div class="mdl-grid page-header mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->menu->getBreadcrumbs()
        ]) ?>
        <h2><?= $name ?></h2>
        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--colored page-header__fab" href="<?= Url::to(['teaser/create']) ?>">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--padding mdl-cell--12-col mdl-shadow--2dp">
        <?php \yii\widgets\Pjax::begin([
            'id' => 'teaser_grid_wrapper',
            'linkSelector' => '#teaser_grid_wrapper a:not(.button-col a)'
        ]); ?>
        <?=
        GridView::widget([
            'id' => 'teaser_grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class'=>'mdl-data-table mdl-data-table--no-border mdl-js-data-table'
            ],
            'columns' => [
                [
                    'label' => $searchModel->i18n()->getAttributeLabel('header'),
                    'value' => function ($model, $key, $index, $column) {
                        return $model->i18n()->header;
                    },
                    'headerOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filterOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'contentOptions' => ['class' => 'mdl-data-table__cell--non-numeric'],
                    'filter' => MdlHtml::activeInput('text', $searchModel->i18n(), "[{$currentLang}]header", ['label' => $searchModel->i18n()->getAttributeLabel('header')])
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
                                    'data-delete_url' => Url::to(['teaser/delete', 'id' => $model->id]),
                                    'title' => Yii::t('app', 'Delete'),
                                ]
                            );
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="material-icons teal-text">mode_edit</i>',
                                Url::to(['teaser/update', 'id' => $model->id]),
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

