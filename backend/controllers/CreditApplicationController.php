<?php

namespace backend\controllers;

use common\models\CreditApplication;
use common\models\CreditApplicationSearch;
use Yii;
use yii\web\Response;

class CreditApplicationController extends \yii\web\Controller
{
    /**
     * Lists all applications.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CreditApplicationSearch();
        $params = Yii::$app->request->get();
        //$searchModel->load($params);
        $dataProvider = $searchModel->search($params);

        if (!isset($params['sort'])) {
            $dataProvider->query->orderBy('id DESC');
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Show application.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('createReview')) {
            Yii::$app->user->denyAccess();
        }

        $model = $this->findModel($id);

        $model->status = CreditApplication::STATUS_UNPUBLISHED;

        $model->save();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteCreditApplication')) {
            Yii::$app->user->denyAccess();
        };

        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success'];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the CreditApplication model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Model the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CreditApplication::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}