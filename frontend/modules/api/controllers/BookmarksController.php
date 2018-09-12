<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 02.03.2018
 * Time: 15:44
 */

namespace frontend\modules\api\controllers;

use Yii;
use yii\base\Controller;
use yii\web\Response;
use frontend\models\Bookmarks;

class BookmarksController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->denyAccess('Извините, чтобы разместить объявление Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте');
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->get('id');
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new Bookmarks();
            $model->user_id = Yii::$app->user->id;
            $model->product_id = intval($id);
            if ($model->save()) {
                return ['status' => 'success', 'id' => $id];
            } else {
                return ['status' => 'failed', 'id' => $id];
            }
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->get('id');
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = Bookmarks::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['product_id' => $id])->one();
            if ($model === null) {
                return ['status' => 'failed', 'id' => $id];
            } else {
                if ($model->delete()) {
                    return ['status' => 'success', 'id' => $id];
                } else {
                    return ['status' => 'failed', 'id' => $id];
                }
            }

        }
    }
}