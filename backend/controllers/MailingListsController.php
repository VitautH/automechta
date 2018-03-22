<?php

namespace backend\controllers;

use common\components\MailingInterface;
use yii\web\Controller;
use common\models\MailingLists;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class MailingListsController extends Controller
{
    /**
     * Lists all mailing list.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = MailingLists::find();
        $query->orderBy('updated_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new mailing list.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MailingLists();
        $data = Yii::$app->request->post();
        if ($model->load($data) && $model->validate()) {
            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MailingList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success'];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an MailingList page.
     * If update is successful, the browser will be redirected to the 'pages/index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = MailingLists::find()->where(['id' => $id])->one();
        $data = Yii::$app->request->post();

        if ($model->load($data)) {
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Validate mailing-lists data
     * @param integer $id Product id
     * @return array
     */
    public function actionValidate($id = null)
    {
        $request = Yii::$app->request->post();
        $model = MailingLists::findOne($id);
        if ($model === null) {
            $model = new MailingLists();
        } else {
            $model->save();
        }

        $model->load($request);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ActiveForm::validateMultiple([$model]);

        return $result;

    }

    public function actionSend($type, $id)
    {
        if (Yii::$app->request->isAjax) {
            switch ($type) {
                case MailingInterface::MAILING_EMAIL:
                    return Yii::$app->emailMailing->getAddress()->sendMailing($id);
                    break;
                case MailingInterface::MAILING_SMS:
                    return false;
                    break;
                default:
                    return Yii::$app->emailMailing->getAddress()->sendMailing($id);
                    break;
            }
        } else {
            Yii::$app->user->denyAccess();
        }
    }

    /**
     * Finds the MailingLists model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Model the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailingLists::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}