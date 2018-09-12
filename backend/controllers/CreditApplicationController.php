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
      // if (!empty($params)) {
           $searchModel->load($params);
      // }
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
     * Add credit application.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createReview')) {
            Yii::$app->user->denyAccess();
        }

        $model = new CreditApplication();
        $data = Yii::$app->request->post();
        $model->status = CreditApplication::STATUS_CREATE_BY_MANAGER;

        if ($model->load($data)) {
            $model->date_arrive= CreditApplication::dateToUnix($data["CreditApplication"]['date_arrive']);
            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Add credit application.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionSave($id)
    {
        if (!Yii::$app->user->can('createReview')) {
            Yii::$app->user->denyAccess();
        }

        $model = CreditApplication::findOne($id);
        $data = Yii::$app->request->post();

        if ($model->load($data)) {
            $model->date_arrive= CreditApplication::dateToUnix($data["CreditApplication"]['date_arrive']);
            $model->save();

            return $this->redirect(['index']);
        }
    }

    public function actionIsarrive ($status,$id){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = CreditApplication::findOne($id);

            if ($status == CreditApplication::ARRIVED) {
                $model->is_arrive = CreditApplication::NO_ARRIVED;
            }
            if ($status == CreditApplication::NO_ARRIVED) {
                $model->is_arrive = CreditApplication::ARRIVED;
            }

            $model->save();
            
            return ['status' => 'success'];
        }
    }

    public function actionIsphone ($status,$id){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = CreditApplication::findOne($id);

            if ($status == CreditApplication::PHONED) {
                $model->is_phoned = CreditApplication::NO_PHONED;
            }
            if ($status == CreditApplication::NO_PHONED) {
                $model->is_phoned = CreditApplication::PHONED;
            }

            $model->save();

            return ['status' => 'success'];
        }
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