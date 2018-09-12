<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use common\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

$userName = User::findOne(Yii::$app->user->identity->id)->username;

if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }
    
    $this->registerJs("require(['controllers/notification/notification']);", \yii\web\View::POS_HEAD);
    $this->registerJs("require(['controllers/site/moment']);", \yii\web\View::POS_HEAD);
    $this->registerJsFile('/js/crm.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/ControlSidebar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/Widget.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/Treeview.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/SiteSearch.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/PushMenu.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/Layout.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerCssFile('/css/crm.css');
    $this->registerCssFile('/css/AdminLTE.min.css');
    $this->registerCssFile('/plugins/bootstrap/css/bootstrap.css');
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    AppAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);
    $commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style href="/css/bootstrap.css"></style>
        <script>
            var require = {
                paths: {
                    'messages': '<?= $commonWebPath ?>/js/messages/<?= Yii::$app->language ?>/messages',
                }
            };
        </script>
        <?= Html::csrfMetaTags() ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            [
                'directoryAsset' => $directoryAsset,
                'userName' => $userName

            ]
        ) ?>

        <?= $this->render(
            'left.php',
            [
                'directoryAsset' => $directoryAsset,
                'userName' => $userName
            ]
        )
        ?>

        <?= $this->render(
            'content.php',
            [
                'content' => $content,
                'directoryAsset' => $directoryAsset,
                'userName' => $userName
            ]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
