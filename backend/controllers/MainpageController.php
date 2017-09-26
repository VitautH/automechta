<?php

namespace backend\controllers;

use common\models\MainPage;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\controllers\behaviors\UploadsBehavior;

class MainpageController extends \yii\web\Controller
{
    public $modelName = 'common\models\MainPage';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
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
     * Update main page data
     * @return mixed
     */
    public function actionUpdate()
    {
        if (!Yii::$app->user->can('updateAppData')) {
            Yii::$app->user->denyAccess();
        }

        $models = MainPage::getModels();
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
     * Validate main page data
     * @return array
     */
    public function actionValidate()
    {
        if (!Yii::$app->user->can('viewAppData')) {
            Yii::$app->user->denyAccess();
        }

        $models = $models = MainPage::getModels();
        $this->fillModels($models);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ActiveForm::validateMultiple($models);
    }

    /**
     * @param MainPage[] $models
     * @return MainPage[]
     */
    protected function fillModels(array $models)
    {
        $data = Yii::$app->request->post();
        foreach ($models as $model) {
            if (MainPage::getFields()[$model->data_key]['i18n'] && isset($data['MainPageI18n'][$model->data_key])) {
                $i18nData = [
                    'MainPageI18n' => $data['MainPageI18n'][$model->data_key],
                    'MainPage' => ['data_key' => $model->data_key],
                ];
                $model->loadI18n($i18nData);
            } elseif(isset($data['MainPage'][$model->data_key])) {
                $model->load(['MainPage' => $data['MainPage'][$model->data_key]]);
            }
        }
        return $models;
    }

}