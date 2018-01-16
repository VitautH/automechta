<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row">
    <header class="col-xs-12 s-headerSubmit s-headerSubmit s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
        <h2 class="">Фотографии для объявления</h2>
    </header>
    <?= Html::activeHiddenInput($form, 'submitted', ['value' => '1']) ?>
    <?= Html::activeHiddenInput($model, 'id') ?>
    <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
        <div class="js-dropzone"
             data-uploaded-files="<?= htmlspecialchars(json_encode(Yii::$app->uploads->getUploadsDataByModel($model)), ENT_QUOTES, 'UTF-8') ?>">
            <div class="dz-default dz-message"><span class="upload btn m-btn">Выбрать фотографии</span> <span
                        class="drop">или перетащите изображения для загрзуки сюда</span></div>
        </div>
        <div class="hint-upload-photo">
            Допускается загрузка не более 20 фотографий в формате JPG и PNG размером не более 8 МБ. <br>Фотография
            помеченная
            как "главная", будет отображенна первой. <br>Мы не рекомендуем Вам использовать фотошоп, рекламу и чужие
            фотографии.
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="hint-video"><h4> Видеоролик с вашей техникой</h4></div>
        <?= $formWidget->field($model, "video", ['options' => ['class' => 'input wow zoomInUp', 'data-wow-delay' => '0.5s']])
            ->textInput(['maxlength' => true, 'class' => '', 'required' => false])->label('Ссылка  видео на YouTube') ?>
    </div>
</div>