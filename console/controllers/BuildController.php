<?php

namespace console\controllers;

use Yii;
use common\helpers\RequireJsConfig;
use yii\helpers\FileHelper;
use yii\helpers\Console;

class BuildController extends \yii\console\Controller
{
    // The command "yii build 0.1" will call build script
    public function actionIndex($version)
    {
        $this->buildMessages();
        $this->actionPublishAssets();
        $this->buildJs();
        $this->createUploadsSymlink();
    }

    public function actionPublishAssets()
    {
        exec('php yii build/publish-frontend-assets', $output);
        echo implode("\n", $output);
        $output = [];
        exec('php yii build/publish-backend-assets', $output);
        echo implode("\n", $output);
    }

    public function actionPublishFrontendAssets()
    {
        Yii::setAlias('@web', '');
        $view = Yii::$app->getView();

        Yii::setAlias('@webroot', '@frontend/web');
        $view->registerAssetBundle('frontend\assets\AppAsset');

        $this->stdout("Frontend assets published.\n", Console::FG_GREEN);
    }

    public function actionPublishBackendAssets()
    {
        Yii::setAlias('@web', '');
        $view = Yii::$app->getView();

        Yii::setAlias('@webroot', '@backend/web');
        $view->registerAssetBundle('backend\assets\AppAsset');

        $this->stdout("Backend assets published.\n", Console::FG_GREEN);
    }

    public function actionJs()
    {
        $this->buildJs();
    }

    public function actionMessages()
    {
        $this->buildMessages();
    }

    public function actionUploadssymlink()
    {
        $this->createUploadsSymlink();
    }

    private function createUploadsSymlink()
    {
        $link = Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads';
        $target = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads';
        if (file_exists($link)) {
            if (is_link($link)) {
                if (is_file($link)) {
                    unlink($link);
                } else if (is_dir($link)) {
                    @rmdir($link);
                    @unlink($link);
                }
                $this->stdout("Old uploads symlink removed.\n", Console::FG_YELLOW);
            } else {
                exit("$link exists but not symbolic link\n");
            }
        }

        $result = symlink($target, $link);
        if ($result) {
            $this->stdout("Uploads symlink successfully created.\n\n", Console::FG_GREEN);
        } else {
            $this->stdout("Uploads symlink was not created.\n\n", Console::FG_RED);
        }
    }

    private function buildJs()
    {
        $rjsPath = Yii::getAlias('@bower/r.js/dist/r.js');

        $nodePath = Yii::$app->params['nodePath'];

        $backendConfig = RequireJsConfig::getConfig('@backend/views/client-script/requirejs.php');
        $frontendConfig = RequireJsConfig::getConfig('@frontend/views/client-script/requirejs.php');
        file_put_contents(Yii::getAlias('@backend/web/js/config.js'), $backendConfig);
        file_put_contents(Yii::getAlias('@frontend/web/js/config.js'), $frontendConfig);
        $backendJs = Yii::getAlias('@backend/web/js/build.js');
        $frontendJs = Yii::getAlias('@frontend/web/js/build.js');
        system("$nodePath $rjsPath -o $backendJs");
        system("$nodePath $rjsPath -o $frontendJs");
    }

    private function buildMessages()
    {
        system("php yii message common/messages/config.php");
        $configFile = 'common/messages/config.php';
        $configFile = Yii::getAlias($configFile);
        if (!is_file($configFile)) {
            throw new Exception("The configuration file does not exist: $configFile");
        }

        $config = array_merge([
            'translator' => 'Yii::t',
            'overwrite' => false,
            'removeUnused' => false,
            'markUnused' => true,
            'sort' => false,
            'format' => 'php',
            'ignoreCategories' => [],
        ], require($configFile));

        foreach ($config['languages'] as $language) {
            //$files = FileHelper::findFiles(realpath($config['sourcePath']), $config);
            $dir = $config['messagePath'] . DIRECTORY_SEPARATOR . $language;
            $files = FileHelper::findFiles($dir);
            $result = [];
            foreach ($files as $file) {
                $fileInfo = new \SplFileInfo($file);
                if ($fileInfo->getExtension()) {
                    $category = $fileInfo->getBasename('.php');
                    $data = require_once($file);
                    $result[$category] = $data;
                }
            }
            $jsLangDir = Yii::getAlias('@common/web/js/messages/' . $language);
            if (!is_dir($jsLangDir)) {
                @mkdir($jsLangDir);
            }
            $this->stdout("JS file created for $language language.\n\n", Console::FG_GREEN);
            @file_put_contents($jsLangDir . '/messages.js', 'define([], function(){return ' . json_encode($result) . ';});');
        }
    }
}