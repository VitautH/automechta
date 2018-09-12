<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 16.01.2018
 * Time: 16:25
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use GuzzleHttp\Client;
use yii\helpers\Url;
use common\models\Parsernews;
use common\models\Page;
use  common\models\PageI18n;
use yii\helpers\StringHelper;
use yii\web\HttpException;

class ParsernewsController extends Controller
{

    public function beforeAction($action)
    {
        if (!Yii::$app->user->can('createPage')) {
            Yii::$app->user->denyAccess();
        }

        return parent::beforeAction($action);
    }

    public function actionTutby()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $parser = new Parsernews();
            
            return $parser->getTutbyNews();
        } else {
            throw  new HttpException('403', 'Доступ запрещён');
        }

    }
}