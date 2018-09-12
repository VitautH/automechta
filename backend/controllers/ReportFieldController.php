<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use backend\models\ReportField;
use common\models\AuthItem;
use yii\data\ActiveDataProvider;


class ReportFieldController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all report field.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewReportField')) {
            Yii::$app->user->denyAccess();
        }

        $query = ReportField::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        if (!Yii::$app->user->can('createReportField')) {
            Yii::$app->user->denyAccess();
        }

        $model = new ReportField();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('createReportField')) {
            Yii::$app->user->denyAccess();
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteReportField')) {
            Yii::$app->user->denyAccess();
        }


        if (Yii::$app->request->isAjax) {
            if ($this->findModel($id)->delete()) {

                return $this->redirect(['index']);
            }
        } else {
            return $this->redirect(['index']);
        }
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
        if (($model = ReportField::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}