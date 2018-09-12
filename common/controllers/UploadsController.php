<?php

namespace common\controllers;

use Yii;
use common\models\Uploads;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\imagine\Image;
use common\models\AppData;
use budyaga\cropper\actions\UploadAction;

class UploadsController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post'],
                    'remove' => ['post'],
                    'rotate' => ['post'],
                ],
            ],
        ];
    }

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

    /**
     * @param $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return array
     */
    public function actionRemove($id)
    {
        $model = Uploads::find()->where(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!Yii::$app->user->can('removeFile', ['model' => $model])) {
            Yii::$app->user->denyAccess();
        }

        $model->delete();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'status' => 'success',
            'id' => $model->id,
        ];
    }

    /**
     * @return array
     */
    public function actionUpload()
    {

        if (!Yii::$app->user->can('uploadFile')) {
            Yii::$app->user->denyAccess();
        }

        $model = new Uploads();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model->file = UploadedFile::getInstanceByName('file');

        $model->setAttributes(Yii::$app->request->get());

        if ($model->upload()) {
              return [
                'status' => 'success',
                'path' => $model->getAbsoluteUrl(),
                'id' => $model->id,
            ];
        } else {
            Yii::$app->response->statusCode = 400;
            if ($model->hasErrors()) {
                $errors = $model->getErrors();
                return [
                    'error' => $model->getFirstError(key($errors)),
                    'errors' => $errors
                ];
            } else {
                return ['status' => 'failed'];
            }
        }
    }


    /**
     * @param $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return array
     */
    public function actionRotate($id)
    {
        $model = Uploads::find()->where(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!Yii::$app->user->can('removeFile', ['model' => $model])) {
            Yii::$app->user->denyAccess();
        }

        $img = Yii::$app->uploads->getFullPathByHash($model->hash);

        Image::frame($img, 5, '666', 0)
        ->rotate(-90)
        ->save($img);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'status' => 'success',
            'id' => $model->id,
            'url' => $model->getAbsoluteUrl()
        ];
    }
}