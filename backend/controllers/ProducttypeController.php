<?php

namespace backend\controllers;

use common\models\ProductType;
use common\models\ProductTypeSearch;
use common\models\Specification;
use common\models\ProductTypeSpecifications;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use common\controllers\TreeController;
use common\controllers\behaviors\UploadsBehavior;

class ProducttypeController extends TreeController
{
    public $modelName = 'common\models\ProductType';

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
     * Lists all product types.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewProductType')) {
            Yii::$app->user->denyAccess();
        };

        $searchModel = new ProductTypeSearch();
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
     * Creates a new product type.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createProductType')) {
            Yii::$app->user->denyAccess();
        };

        $model = new ProductType();

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $root = ProductType::getRoot();
            $model->appendTo($root);
            $this->saveUploads($model);
            $this->saveSpecifications($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'specifications' => Specification::find()->where('depth>0')->all(),
                'currentSpecifications' => [],
            ]);
        }
    }

    /**
     * Update product type
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateProductType')) {
            Yii::$app->user->denyAccess();
        };

        $model = $this->findModel($id);

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $model->save();
            $this->saveUploads($model);
            $this->saveSpecifications($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'specifications' => Specification::find()->where('depth>0')->all(),
                'currentSpecifications' => $model->getProductSpecificationIds(),
            ]);
        }
    }

    /**
     * Deletes an existing product type.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteProductType')) {
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
     * Validate product type data
     * @param integer $id ProductType id
     * @return array
     */
    public function actionValidate($id = null)
    {
        if (!Yii::$app->user->can('viewProductType')) {
            Yii::$app->user->denyAccess();
        };

        $model = ProductType::findOne($id);
        if ($model === null) {
            $model = new ProductType();
        }
        $model->loadI18n(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;

        $models = array_merge([$model], $model->getI18nModels());

        return ActiveForm::validateMultiple($models);
    }

    /**
     * Finds the ProductType model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id = $this->getNodeId($id);
        if (($model = ProductType::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Save specifications
     * @param ProductType $model
     */
    protected function saveSpecifications(ProductType $model)
    {
        $specificationsToSave = array_keys(Yii::$app->request->post('Specification', []));

        ProductTypeSpecifications::deleteAll('type=' . $model->id);

        foreach ($specificationsToSave as $specificationId) {
            $productTypeSpecification = new ProductTypeSpecifications();
            $productTypeSpecification->type = $model->id;
            $productTypeSpecification->specification = $specificationId;
            $productTypeSpecification->save();
        }
    }
}