<?php

namespace backend\controllers;

use common\models\Teaser;
use common\models\TeaserSearch;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\controllers\TreeController;
use yii\data\ActiveDataProvider;
use common\controllers\behaviors\UploadsBehavior;

class TeaserController extends TreeController
{
    public $modelName = 'common\models\Teaser';

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

    public function actions()
    {
        $actions =  parent::actions();
        $actions['load-tree']['nameAttribute'] = function ($model) {return $model->i18n()->name;};
        return $actions;
    }

    /**
     * Lists all teaser items.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewTeaser')) {
            Yii::$app->user->denyAccess();
        };

        $searchModel = new TeaserSearch();
        $params = Yii::$app->request->get();
        $searchModel->loadI18n($params);
        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $searchModel->searchI18n();

        $dataProvider->query->andWhere('depth>0');
        $dataProvider->query->orderBy('lft');
        $dataProvider->sort = false;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new teaser Item.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createTeaser')) {
            Yii::$app->user->denyAccess();
        };

        $model = new Teaser();

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $root = Teaser::getRoot();
            $model->appendTo($root);
            $this->saveUploads($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Update teaser item
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateTeaser')) {
            Yii::$app->user->denyAccess();
        };

        $model = $this->findModel($id);

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $model->save();
            $this->saveUploads($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing teaser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteTeaser')) {
            Yii::$app->user->denyAccess();
        };

        $this->findModel($id)->deleteWithChildren();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success'];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Validate teaser data
     * @param integer $id teaser id
     * @return array
     */
    public function actionValidate($id = null)
    {
        if (!Yii::$app->user->can('viewTeaser')) {
            Yii::$app->user->denyAccess();
        };

        $model = Teaser::findOne($id);
        if ($model === null) {
            $model = new Teaser();
        }
        $model->loadI18n(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;

        $models = array_merge([$model], $model->getI18nModels());

        return ActiveForm::validateMultiple($models);
    }

    /**
     * Finds the Teaser model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Model the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id = $this->getNodeId($id);
        if (($model = Teaser::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}