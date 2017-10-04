<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;

AppAsset::register($this);
$commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style href="/css/bootstrap.css"></style>
    <script>
        var require = {
            paths : {
                'messages' : '<?= $commonWebPath ?>/js/messages/<?= Yii::$app->language ?>/messages',
            }
        };
    </script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <header class="mdl-layout__header mdl-shadow--0dp">
        <div class="docs-navigation__container">
            <?=
            Menu::widget([
                'activateParents' => true,
                'items' => Yii::$app->menu->getItems(),
                'options' => [
                    'class'=>'docs-navigation mdl-navigation',
                    'tag' => 'nav'
                ],
                'submenuTemplate' => '',
                'itemOptions' => [
                    'tag' => 'span',
                    'class' => 'mdl-navigation__link',
                ],
                'linkTemplate' => '<a href="{url}">{label}</a>',
            ]);
            ?>
        </div>
    </header>
    <div class="mdl-layout__drawer mdl-shadow--8dp">
        <span class="mdl-layout-title">
            <?= Html::a(Yii::$app->name, '/') ?>
        </span>
        <?=
             Menu::widget([
                 'activateParents' => true,
                 'items' => Yii::$app->menu->getSideItems(),
                 'options' => [
                     'tag' => 'nav',
                     'class' => 'mdl-navigation',
                 ],
                 'submenuTemplate' => "\n<nav>\n{items}\n</nav>\n",
                 'itemOptions' => [
                     'tag' => 'span'
                 ],
                 'linkTemplate' => '<a class="mdl-navigation__link" href="{url}">{label}</a>',
            ]);
        ?>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">
            <?= $content ?>
        </div>
        <div class="mdl-layout-spacer"></div>
        <footer class="mdl-mega-footer">
            <div class="mdl-mega-footer__middle-section">
                <?php foreach(Yii::$app->menu->getItems() as $item): ?>
                    <?php if (isset($item['items'])): ?>
                    <div class="mdl-mega-footer__drop-down-section">
                        <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                        <h1 class="mdl-mega-footer__heading"><?= $item['label'] ?></h1>
                        <?php
                            echo Menu::widget([
                                'items' => $item['items'],
                                'options' => [
                                    'class' => 'mdl-mega-footer__link-list',
                                ],
                                'submenuTemplate' => ""
                            ]);
                        ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="mdl-mega-footer__bottom-section">
                <div class="mdl-logo">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></div>
                <!--<ul class="mdl-mega-footer__link-list">
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Privacy & Terms</a></li>
                </ul>-->
            </div>

        </footer>
    </main>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
