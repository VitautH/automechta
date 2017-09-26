<?php

namespace backend\controllers;

use common\models\ProductMake;
use common\models\ProductType;
use common\models\ProductMakeSearch;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use common\controllers\behaviors\UploadsBehavior;
use common\controllers\TreeController;
use yii\web\NotFoundHttpException;

class ProductmakeController extends TreeController
{
    public $modelName = 'common\models\ProductMake';

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
        $actions = parent::actions();
        $actions['load-tree']['nameAttribute'] = function ($model) {
            $type = ProductType::find()->where('id='.$model->product_type)->one();
            $result = $model->name;
            if ($type) {
                $result .= ' (' . $type->i18n()->name . ')';
            }

            return $result;
        };
        return $actions;
    }

    /**
     * Lists all product makes.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewProductMake')) {
            Yii::$app->user->denyAccess();
        };

        $searchModel = new ProductMakeSearch();
        $params = Yii::$app->request->get();
        $searchModel->load($params);
        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $searchModel->search();

        $dataProvider->query->andWhere('depth>0');
        $dataProvider->query->orderBy('lft');
        $dataProvider->sort = false;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new product make.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createProductMake')) {
            Yii::$app->user->denyAccess();
        };

        $model = new ProductMake();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $root = ProductMake::getRoot();
            $model->appendTo($root);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Update product make
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateProductMake')) {
            Yii::$app->user->denyAccess();
        };

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

    /**
     * Deletes an existing product make.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteProductMake')) {
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
     * Get list of models by make id
     * @param $makeId
     * @return mixed
     */
    public function actionModels($makeId)
    {
        if (!Yii::$app->user->can('viewProductMake')) {
            Yii::$app->user->denyAccess();
        };

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($makeId);
        return ProductMake::getModelsList($model->id);
    }

    /**
     * Validate product make data
     * @param integer $id ProductMake id
     * @return array
     */
    public function actionValidate($id = null)
    {
        if (!Yii::$app->user->can('viewProductMake')) {
            Yii::$app->user->denyAccess();
        };

        $model = ProductMake::findOne($id);
        if ($model === null) {
            $model = new ProductMake();
        }
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ActiveForm::validate($model);
    }

    /**
     * Finds the ProductMake model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id = $this->getNodeId($id);
        if (($model = ProductMake::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}