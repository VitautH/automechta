<?php

namespace backend\controllers;

use common\models\AutoModels;
use common\models\AutoModifications;
use common\models\AutoModification;
use common\models\AutoSearch;
use common\models\ImageModifications;
use Yii;
use backend\models\ModificationsSearch;
use yii\web\Controller;
use common\models\AutoSpecifications;
use yii\web\NotFoundHttpException;
use common\models\AutoMakes;
use common\models\AutoRegions;
use dastanaron\translit\Translit;
use yii\web\HttpException;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class ModificationsController extends \yii\web\Controller
{
    /**
     * @return bool
     */
    public function beforeAction($action)
    {
        if ($this->action->id == 'upload') {
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return true;
    }

    public function actionIndex()
    {

        $searchModel = new ModificationsSearch();
        $params = Yii::$app->request->get();

        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $searchModel->search($params);

        if (!isset($params['sort'])) {
            $dataProvider->query->orderBy('id DESC');
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            '_params_'=>$params
        ]);
    }

    /**
     * @param $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return array
     */
    public function actionRemove($id)
    {
        if (Yii::$app->request->isAjax) {

            $model = ImageModifications::find()->where(['id' => $id])->one();
            if ($model !== null) {
                //unlink('/home/admin/web/automechta.by/public_html/frontend/web/'. $model->img_url);
                $model->delete();
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ['id' => $id, 'status' => 'success'];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ['status' => 'failed'];
            }
        }
    }

    /**
     * @return array
     */
    public function actionUpload($modificationsId)
    {

        if (!Yii::$app->user->can('uploadFile')) {
            Yii::$app->user->denyAccess();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = AutoModifications::findOne($modificationsId);

        $model->imageFiles = UploadedFile::getInstancesByName('file');

        $result = $model->upload($modificationsId);

        if ($result['status'] == 'success') {
            return [
                'status' => $result['status'],
                'path' => $result['path'],
                'id' => $result['id'],
            ];
        } else {
            Yii::$app->response->statusCode = 400;
            return ['status' => 'failed'];
        }
    }


    public function actionUpdate($id)
    {

        $modification = AutoModifications::findOne($id);
        $nameModifications = AutoMakes::findOne($modification->make_id)->name . ' ' . AutoModels::findOne($modification->model_id)->model . ' ' . AutoModifications::findOne($id)->modification_name .
            $images = ImageModifications::find()->where(['modifications_id' => $id])->all();

        return $this->render('update', [
            'images' => $images,
            'model' => $modification,
            'nameModifications' => $nameModifications
        ]);
    }


    /**
     * Finds the Product model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AutoModifications::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}