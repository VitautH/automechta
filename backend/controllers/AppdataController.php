<?php

namespace backend\controllers;

use common\models\AppData;
use common\models\AppRegistry;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\controllers\behaviors\UploadsBehavior;

class AppdataController extends \yii\web\Controller
{
    public $modelName = 'common\models\AppData';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'move-node' => ['post'],
                    'delete' => ['post'],
                ],
            ],
            [
                'class' => UploadsBehavior::className(),
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->redirect(['update']);
    }

    /**
     * SaveBank application data
     * @return mixed
     */
    public function actionSaveBank()
    {
        if (!Yii::$app->user->can('updateAppData')) {
            Yii::$app->user->denyAccess();
        }
        $data = Yii::$app->request->post()[AppRegistry::getModelsName()];
var_dump($data);
die();
        for ($i = 1; $i <= count($data); $i++) {
            if (AppRegistry::findOne(['data_key'=>'credit_bank_' . $i])){
                $model=AppRegistry::findOne(['data_key'=>'credit_bank_' . $i]);
                $model->label = $data["credit_bank_" . $i . ""]["label"];
                $model->data_value = $data["credit_bank_" . $i . ""]["value"];
                if (!$model->save()) {
                    var_dump($model->getErrors());
                }
                unset($model);
            }
            else {
                $model = new AppRegistry();
                $model->visibility = 'credit_page';
                $model->data_type = 'credit_bank';
                $model->field_type = 'input';
                $model->label = $data["credit_bank_" . $i . ""]["label"];
                $model->data_key = 'credit_bank_' . $i;
                $model->data_value = $data["credit_bank_" . $i . ""]["value"];
                if (!$model->save()) {
                    var_dump($model->getErrors());
                }
                unset($model);
            }
        }
        return $this->redirect(['update']);
    }

    /**
     * SaveBank application data
     * @return mixed
     */
    public function actionDeleteBank()
    {
        if (!Yii::$app->user->can('updateAppData')) {
            Yii::$app->user->denyAccess();
        }
        if (Yii::$app->request->isAjax) {
            $request = Yii::$app->request->post();
            $dataKey = $request['data-key'];

            if (AppRegistry::findOne(['data_key' => $dataKey])->delete()) {
                return true;
            } else {
                return false;
            }

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * Update application data
     * @return mixed
     */
    public function actionUpdate()
    {
        if (!Yii::$app->user->can('updateAppData')) {
            Yii::$app->user->denyAccess();
        }

        $models = AppData::getModels();
        $this->fillModels($models);

        if (Yii::$app->request->getMethod() === 'POST' && empty(ActiveForm::validateMultiple($models))) {
            foreach ($models as $model) {
                $model->save();
            }
            return $this->redirect(['update']);
        } else {
            return $this->render('update', [
                'models' => $models,
            ]);
        }
    }

    /**
     * Validate slider data
     * @return array
     */
    public function actionValidate()
    {
        if (!Yii::$app->user->can('viewAppData')) {
            Yii::$app->user->denyAccess();
        }

        $models = $models = AppData::getModels();
        $this->fillModels($models);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ActiveForm::validateMultiple($models);
    }

    /**
     * @param AppData[] $models
     * @return AppData[]
     */
    protected function fillModels(array $models)
    {
        $data = Yii::$app->request->post();
        foreach ($models as $model) {
            if (AppData::$fields[$model->data_key]['i18n'] && isset($data['AppDataI18n'][$model->data_key])) {
                $i18nData = [
                    'AppDataI18n' => $data['AppDataI18n'][$model->data_key],
                    'AppData' => ['data_key' => $model->data_key],
                ];
                $model->loadI18n($i18nData);
            } elseif (isset($data['AppData'][$model->data_key])) {
                $model->load(['AppData' => $data['AppData'][$model->data_key]]);
            }
        }
        return $models;
    }

}