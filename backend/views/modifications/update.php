<?

use \yii\grid\GridView;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use \common\helpers\MdlHtml;
use \common\models\AutoMakes;
use common\models\AutoModels;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use \common\models\ImageModifications;

$name = 'Изображения модификаций ' . $nameModifications;
$currentLang = Yii::$app->language;
$this->title = $name;
$this->registerJs("require(['controllers/modifications/upload']);", \yii\web\View::POS_HEAD);
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Фотографии</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <?= Html::activeHiddenInput($model, 'id') ?>
            <div class="mdl-textfield mdl-textfield--full-width mdl-textfield--floating-label is-dirty">
                <div class="js-dropzone"
                     data-uploaded-files="<?= htmlspecialchars(json_encode($model->getUploadsImageModification($model->id)), ENT_QUOTES, 'UTF-8') ?>">
                    <div class="dz-default dz-message"><span
                                class="upload btn m-btn">Выбрать фотографию</span> <span
                                class="drop">или перетащите изображения для загрзуки сюда</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

