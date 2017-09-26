<?php

namespace backend\controllers;

use common\models\Menu;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\controllers\TreeController;
use common\controllers\behaviors\MetaDataBehavior;

class MenuController extends TreeController
{
    public $modelName = 'common\models\Menu';

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
                'class' => MetaDataBehavior::className(),
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
     * Lists all menu items.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewMenuItem')) {
            Yii::$app->user->denyAccess();
        };

        return $this->render('index', [
        ]);
    }

    /**
     * Creates a new menu Item.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createMenuItem')) {
            Yii::$app->user->denyAccess();
        };

        $model = new Menu();

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $root = Menu::getRoot();
            $model->appendTo($root);
            $this->saveMetaData($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Update menu item
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateMenuItem')) {
            Yii::$app->user->denyAccess();
        };

        $model = $this->findModel($id);

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $model->save();
            $this->saveMetaData($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteMenuItem')) {
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
     * Validate menu data
     * @param integer $id menu id
     * @return array
     */
    public function actionValidate($id = null)
    {
        if (!Yii::$app->user->can('viewMenuItem')) {
            Yii::$app->user->denyAccess();
        };

        $model = Menu::findOne($id);
        if ($model === null) {
            $model = new Menu();
        }
        $model->loadI18n(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;

        $models = array_merge([$model], $model->getI18nModels());

        return ActiveForm::validateMultiple($models);
    }

    /**
     * Finds the Menu model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Model the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id = $this->getNodeId($id);
        if (($model = Menu::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}