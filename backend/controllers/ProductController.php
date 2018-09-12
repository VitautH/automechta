<?php

namespace backend\controllers;

use common\models\Product;
use common\models\Uploads;
use common\models\ProductSearch;
use common\models\ProductType;
use common\models\ProductMake;
use common\models\Specification;
use common\models\ProductSpecification;
use common\controllers\behaviors\MetaDataBehavior;
use common\models\MetaData;
use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use common\controllers\behaviors\UploadsBehavior;
use yii\web\NotFoundHttpException;

class ProductController extends \yii\web\Controller
{
    public $modelName = 'common\models\Product';

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
            [
                'class' => MetaDataBehavior::className(),
            ],
        ];
    }

    /**
     * Lists all products.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewProduct')) {
            Yii::$app->user->denyAccess();
        }

        $searchModel = new ProductSearch();
        $params = Yii::$app->request->get();


        $searchModel->loadI18n($params);
        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $searchModel->search();

        if (!isset($params['sort'])) {
            $dataProvider->query->orderBy('created_at DESC');
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionClearcache()
    {
        if (!Yii::$app->user->can('deleteProduct')) {
            Yii::$app->user->denyAccess();
        }

        if (Yii::$app->request->isAjax) {
            if (Yii::$app->cache->clearAll()) {
                return true;
            } else {
                return false;
            }
        } else {
            Yii::$app->user->denyAccess();
        }
    }


    public function actionIndexingproduct()
    {
        if (!Yii::$app->user->can('deleteProduct')) {
            Yii::$app->user->denyAccess();
        }

        if (Yii::$app->request->isAjax) {
            if (Yii::$app->indexing->IndexingAllProduct()) {
                return true;
            } else {
                return false;
            }
        } else {
            Yii::$app->user->denyAccess();
        }
    }

    /**
     * Creates a new product.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createProduct')) {
            Yii::$app->user->denyAccess();
        }

        $model = new Product();
        $model->loadDefaultValues();

        if (isset(Yii::$app->request->get('Product')['type'])) {
            $model->type = Yii::$app->request->get('Product')['type'];
        }

        $productSpecificationModels = $this->fillSpecifications($model);

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $model->save();
            $this->saveUploads($model);
            $this->saveSpecifications($model);
            $model->saveProductMetaData();
            Yii::$app->cache->deleteKey('main_page');
            return $this->redirect(['index']);
        } else {
            $model->make = key(ProductMake::getMakesList($model->type));

            return $this->render('create', [
                'model' => $model,
                'productSpecifications' => $productSpecificationModels,
            ]);
        }
    }

    public function actionChange()
    {
        if (!Yii::$app->user->can('deleteProduct')) {
            Yii::$app->user->denyAccess();
        }

        if (Yii::$app->request->isAjax) {
            $request = Yii::$app->request->post();
            function delete($items)
            {
                foreach ($items as $item) {
                    $model = Product::findOne($item);
                    $model->delete();
                    Yii::$app->cache->deleteKey('main_page');
                    Yii::$app->parserProductVideo->delete($item);
                }
                return true;
            }

            function published($items)
            {
                foreach ($items as $item) {
                    $model = Product::findOne($item);
                    $model->status = Product::STATUS_PUBLISHED;
                    $model->save();

                    Yii::$app->parserProductVideo->parser($item);
                }
                return true;
            }

            function unpublished($items)
            {
                foreach ($items as $item) {
                    $model = Product::findOne($item);
                    $model->status = Product::STATUS_UNPUBLISHED;
                    if ($model->save()) {
                        Uploads::deleteImages('product', $item);
                    }

                    Yii::$app->parserProductVideo->delete($item);
                }
                return true;
            }

            switch ($request['action']) {
                case 'delete':
                    delete($request ['ads']);
                    break;
                case Product::STATUS_PUBLISHED:
                    published($request ['ads']);
                    break;

                case Product::STATUS_UNPUBLISHED:
                    unpublished($request ['ads']);
                    break;

            }

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Product to Black List
     *  @param integer $id
     * @return mixed
     */
    public function actionBan($id)
    {
        if (!Yii::$app->user->can('deleteProduct')) {
            Yii::$app->user->denyAccess();
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            switch ($model->ban) {
                case Product::BAN:
                    $model->ban = Product::UN_BAN;
                    $isBan = false;
                    break;

                case Product::UN_BAN:
                    $model->ban = Product::BAN;
                    $isBan = true;
                    break;
            }

            if ($model->save()) {
                return ['status' => true, 'isBan' => $isBan, 'id' => $id];
            } else {
                return ['status' => false];
            }
        } else {
            Yii::$app->user->denyAccess();
        }

    }

    /**
     * Update product
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateProduct')) {
            Yii::$app->user->denyAccess();
        }

        $model = $this->findModel($id);
        $model->loadDefaultValues();
        $productSpecificationModels = $this->fillSpecifications($model);
        $request = Yii::$app->request->post();

        if ($request['Product']['status'] == Product::STATUS_UNPUBLISHED) {
            Uploads::deleteImages('product', $id);
        }
        if ($request['Product']['status'] == Product::STATUS_PUBLISHED) {
            Yii::$app->parserProductVideo->parser($id);
        }

        if ($model->loadI18n($request) && $model->validateI18n()) {
            $model->phone = $request['Product']['phone'];
            $model->phone_2 = $request['Product']['phone_2'];

            if ($request["Product"]['currency'] == 1) {
                $model->price = $model->exchangeBynToUsd($request["Product"]['priceByn']);
                $model->priceByn = $request["Product"]['priceByn'];
            }

            $model->save();
            $this->saveUploads($model);
            $this->saveSpecifications($model);
            $model->updateProductMetaData();;
            Yii::$app->cache->deleteKey('main_page');

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'productSpecifications' => $productSpecificationModels,
            ]);
        }
    }

    /**
     * Deletes an existing product.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteProduct')) {
            Yii::$app->user->denyAccess();
        }
        $this->findModel($id)->delete();
        Uploads::deleteImages('product', $id);
        Yii::$app->cache->deleteKey('main_page');
        Yii::$app->parserProductVideo->delete($id);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Validate product data
     * @param integer $id Product id
     * @return array
     */
    public function actionValidate($id = null)
    {
        if (!Yii::$app->user->can('viewProduct')) {
            Yii::$app->user->denyAccess();
        }
        $request = Yii::$app->request->post();
        $model = Product::findOne($id);
        if ($model === null) {
            $model = new Product();
        } else {
            $model->status = $request['Product']['status'];
            $model->save();
        }


        $model->loadI18n($request);
        Yii::$app->response->format = Response::FORMAT_JSON;

        $productSpecificationModels = $this->fillSpecifications($model);

        $result = ActiveForm::validateMultiple([$model]);
        $result += ActiveForm::validateMultiple($model->getI18nModels());
        $result += ActiveForm::validateMultiple($productSpecificationModels);

        return $result;

    }

    /**
     * Render product specification form
     * @param integer $type product type value
     * @return mixed
     */
    public function actionSpecificationsForm($type)
    {
        if (!Yii::$app->user->can('viewProduct')) {
            Yii::$app->user->denyAccess();
        }

        $type = intval($type);

        $specifications = Specification::find()
            ->joinWith('productTypeSpecifications')
            ->where('product_type_specifications.type=:type', [':type' => $type])
            ->all();

        return $this->renderPartial('specificationsForm', [
            'specifications' => $specifications,
        ]);
    }

    /**
     * Render select product type form
     * @return mixed
     */
    public function actionTypeSelect()
    {
        if (!Yii::$app->user->can('viewProduct')) {
            Yii::$app->user->denyAccess();
        }

        return $this->renderPartial('typeSelect', [
            'types' => ProductType::getTypesAsArray()
        ]);
    }

    /**
     * @param Product $model
     * @return ProductSpecification[]
     */
    protected function saveSpecifications(Product $model)
    {
        ProductSpecification::deleteAll('product_id=' . $model->id);
        $productSpecificationModels = $this->fillSpecifications($model);
        foreach ($productSpecificationModels as $productSpecificationModel) {
            $productSpecificationModel->save();
        }
        return $productSpecificationModels;
    }

    /**
     * @param Product $model
     * @return ProductSpecification[]
     */
    protected function fillSpecifications(Product $model)
    {
        $productSpecificationsData = Yii::$app->request->post('ProductSpecification', []);
        $productSpecificationModels = [];

        if ($model->type !== null) {
            $specifications = Specification::find()
                ->joinWith('productTypeSpecifications')
                ->where('product_type_specifications.type=:type', [':type' => $model->type])
                ->all();

            foreach ($specifications as $specification) {
                $productSpecificationModel = null;
                if (!$model->isNewRecord) {
                    $productSpecificationModel = ProductSpecification::find()
                        ->where('specification_id=:specification_id and product_id=:product_id', [
                            ':specification_id' => $specification->id,
                            ':product_id' => $model->id,
                        ])->limit(1)->one();
                }

                if ($productSpecificationModel === null) {
                    $productSpecificationModel = new ProductSpecification();
                    $productSpecificationModel->specification_id = $specification->id;
                    $productSpecificationModel->product_id = $model->id;
                }

                if (isset($productSpecificationsData[$specification->id])) {
                    $productSpecificationModel->load($productSpecificationsData[$specification->id], '');
                }

                $productSpecificationModels[$specification->id] = $productSpecificationModel;
            }
        }

        return $productSpecificationModels;
    }

    /**
     * ToDo: Delete method
     * @param ActiveRecord $model
     * @return boolean
     */
//    protected function saveProductMetaData($model)
//    {
//        $this->saveMetaData($model);
//        $model->updateMetaData();
//    }


    /**
     * Finds the Product model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}