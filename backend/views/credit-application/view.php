<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
use common\models\CreditApplication;

$name = Yii::t('app', 'Credit Applications');
$this->title = $name;

$this->registerJs("require(['controllers/creditApplication/view']);", \yii\web\View::POS_HEAD);
$model->date_arrive = Yii::$app->formatter->asDate($model->date_arrive, 'yyyy-MM-dd');
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
            'lastname',
            'firstname',
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
            'created_at:datetime',
            [
                'label' => 'Приехал ?',
                'value' =>function () use ($model){
        if ($model->is_arrive){
            return 'Да';
        }
        else {
            return 'Нет';
        }
                }
            ],
        ],
    ]);
?>
<?php
$form = ActiveForm::begin([
    'id' => 'page-form',
   'action' =>  Url::to(['credit-application/save', 'id'=>$model->id]),
   'options' => ['class' => "mdl-grid mdl-form"],
//    'errorCssClass' => 'is-invalid',
//    'fieldConfig' => [
//        'template' => "{input}\n{label}\n{error}",
//        'options' => ['class' => 'mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label'],
//        'labelOptions' => ['class' => 'mdl-textfield__label'],
//        'errorOptions' => ['class' => 'mdl-textfield__error'],
//        'inputOptions' => ['class' => 'mdl-textfield__input']
//    ]
]);
?>
    <label>Дата приезда: </label>   <?= $form->field($model,  'date_arrive', ['options' => ['class' => 'b-submit__main-element']])->input('date', ['class'=>'field'])->label(false) ?>

    <br>

    <label>Заметка: </label> <?= $form->field($model, 'note', ['options' => ['class' => 'b-submit__main-element']])->textarea(['rows'=>10])->label(false) ?>
    <?= Html::submitButton(
        '<i class="material-icons">done</i>',
        [
            'class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--success mdl-form--submit',
            'title' =>  $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app','Update')
        ])
    ?>
    <?php ActiveForm::end(); ?>
</div>