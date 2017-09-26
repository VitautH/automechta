<?php

namespace backend\controllers;

use common\models\Page;
use common\models\PageSearch;
use common\controllers\behaviors\UploadsBehavior;
use common\controllers\behaviors\MetaDataBehavior;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * PagesController implements the CRUD actions for application pages (common\models\Page model).
 */
class PagesController extends \yii\web\Controller
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
            [
                'class' => UploadsBehavior::className(),
            ],
            [
                'class' => MetaDataBehavior::className(),
            ],
        ];
    }

    /**
     * Lists all pages.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewPage')) {
            Yii::$app->user->denyAccess();
        }

        $searchModel = new PageSearch();
        $params = Yii::$app->request->get();
        $searchModel->loadI18n($params);
        $searchModel->type = Page::TYPE_STATIC;
        $dataProvider = $searchModel->searchI18n();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new page
     * If creation is successful, the browser will be redirected to the 'pages/index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createPage')) {
            Yii::$app->user->denyAccess();
        }

        $model = new Page();

        $data = Yii::$app->request->post();
        $data['Page']['type'] = Page::TYPE_STATIC;

        if ($model->loadI18n($data) && $model->validateI18n()) {
            $model->save();
            $this->saveUploads($model);
            $this->saveMetaData($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing page.
     * If update is successful, the browser will be redirected to the 'pages/index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updatePage')) {
            Yii::$app->user->denyAccess();
        }

        $model = $this->findModel($id);

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $model->save();
            $this->saveUploads($model);
            $this->saveMetaData($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing page.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deletePage')) {
            Yii::$app->user->denyAccess();
        }

        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success'];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Validate permission data
     * @param integer $id user id
     * @return array
     */
    public function actionValidate($id = null)
    {
        if (!Yii::$app->user->can('viewPage')) {
            Yii::$app->user->denyAccess();
        }

        $model = Page::findOne($id);
        if ($model === null) {
            $model = new Page();
        }
        $model->loadI18n(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;

        $models = array_merge([$model], $model->getI18nModels());

        return ActiveForm::validateMultiple($models);
    }

    /**
     * Finds the Page model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Model the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
