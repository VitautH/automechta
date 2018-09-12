<?php

namespace backend\controllers;

use common\models\Callback;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Response;

class CallbackController extends Controller
{

    public function actionIndex()
    {
        $query = Callback::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->query->orderBy('created_at DESC');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $report = Callback::findOne($id);
            $report->viewed = Callback::VIEWED;
            if ($report->save()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'failed'];
            }

        } else {
            Yii::$app->user->denyAccess();
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = Callback::findOne($id);
            if ($model->delete()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'failed'];
            }

        } else {
            Yii::$app->user->denyAccess();
        }
    }
}