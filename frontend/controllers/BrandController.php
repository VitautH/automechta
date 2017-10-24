<?php

namespace frontend\controllers;

use common\models\ProductType;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Controller;
use common\models\Product;
use common\models\AppData;
use common\models\Specification;
use common\controllers\behaviors\UploadsBehavior;
use common\models\ProductSpecification;
use common\models\User;
use common\models\ProductMake;
use common\models\MetaData;
use frontend\models\ProductSearchForm;
use frontend\models\ContactForm;
use frontend\models\ProductForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\web\NotAcceptableHttpException;

/**
 * Catalog controller
 */
class BrandController extends Controller
{
    public $layout = 'index';

    public function behaviors()
    {
        return [
            [
                'class' => UploadsBehavior::className(),
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionCategory($productType)
    {
        $params = Yii::$app->request->get();
        $searchForm = new ProductSearchForm();
        $query = Product::find()->active();
        if ($productType == 3) {
            $params['ProductSearchForm']['type'] = 3;
        }


        $searchForm->load($params);

        if (!empty($params['ProductSearchForm']['specs'])) {
            $searchForm->specifications = $params['ProductSearchForm']['specs'];
        }

        if (!isset($params['sort']) || $params['sort'] === '') {
            $query->orderBy('updated_at DESC');
        }


        $searchForm->search($query);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 18,
            ],
            'sort' => [
                'attributes' => [
                    'price' => [
                        'label' => 'Цене'
                    ],
                    'created_at' => [
                        'asc' => ['created_at' => SORT_DESC],
                        'desc' => ['created_at' => SORT_ASC],
                        'label' => 'Дате подачи'
                    ],
                    'year' => [
                        'label' => 'Году выпуска'
                    ],
                ]
            ]
        ]);

        if (Yii::$app->request->isAjax) {
            $this->layout = false;
        }

        return $this->render('category', [
            'provider' => $provider,
            'searchForm' => $searchForm,
            'metaData' => $this->getMetaData($searchForm),
            'type' => $productType
        ]);
    }

    public function actionIndex()
    {
        $params = Yii::$app->request->get();

        $searchForm = new ProductSearchForm();
        $query = Product::find()->active();


        $searchForm->load($params);

        if (!empty($params['ProductSearchForm']['specs'])) {
            $searchForm->specifications = $params['ProductSearchForm']['specs'];
        }

        if (!isset($params['sort']) || $params['sort'] === '') {
            $query->orderBy('updated_at DESC');
        }


        $searchForm->search($query);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 18,
            ],
            'sort' => [
                'attributes' => [
                    'price' => [
                        'label' => 'Цене'
                    ],
                    'created_at' => [
                        'asc' => ['created_at' => SORT_DESC],
                        'desc' => ['created_at' => SORT_ASC],
                        'label' => 'Дате подачи'
                    ],
                    'year' => [
                        'label' => 'Году выпуска'
                    ],
                ]
            ]
        ]);

        if (Yii::$app->request->isAjax) {
            $this->layout = false;
        }

        return $this->render('index', [
            'provider' => $provider,
            'searchForm' => $searchForm,
            'metaData' => $this->getMetaData($searchForm),
        ]);
    }

    public function actionSearch()
    {
        $params = Yii::$app->request->get();

        $searchForm = new ProductSearchForm();
        $query = Product::find()->active();


        $searchForm->load($params);

        if (!empty($params['ProductSearchForm']['specs'])) {
            $searchForm->specifications = $params['ProductSearchForm']['specs'];
        }

        if (!isset($params['sort']) || $params['sort'] === '') {
            $query->orderBy('updated_at DESC');
        }


        $searchForm->search($query);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 18,
            ],
            'sort' => [
                'attributes' => [
                    'price' => [
                        'label' => 'Цене'
                    ],
                    'created_at' => [
                        'asc' => ['created_at' => SORT_DESC],
                        'desc' => ['created_at' => SORT_ASC],
                        'label' => 'Дате подачи'
                    ],
                    'year' => [
                        'label' => 'Году выпуска'
                    ],
                ]
            ]
        ]);

        if (Yii::$app->request->isAjax) {
            $this->layout = false;
        }

        return $this->render('index', [
            'provider' => $provider,
            'searchForm' => $searchForm,
            'metaData' => $this->getMetaData($searchForm),
        ]);
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
                ->orderBy('specification.lft')
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
        return $productSpecificationModel;
    }

    /**
     * Get metadata model
     */
    protected function getMetaData(ProductSearchForm $searchForm)
    {
        $meta = [
            'title' => '',
        ];

        if ($searchForm->make) {
            $maker = ProductMake::find()->where('id=:id', [':id' => $searchForm->make])->one();
            if ($maker) {
                $meta['title'] = ' | ' . $maker->name;
                if ($searchForm->model) {
                    $meta['title'] = ' | ' . $maker->name . ' ' . $searchForm->model;
                }
            }

        }
        if ($meta['title'] === '' && $searchForm->type) {
            $type = ProductType::find()->where('id=:id', [':id' => $searchForm->type])->one();
            if ($type) {
                $meta['title'] = ' | ' . $type->i18n()->name;
            }
        }

        $meta['title'] = Yii::t('app', 'Catalog') . $meta['title'];

        $meta['description'] = $meta['title'] . ' купить в кредит в Минске';
        $meta['keywords'] = $meta['title'] . ' купить в кредит в Минске';

        return $meta;
    }

    /**
     * @param string $productType product type id
     * @param string $maker product make
     *
     * @return index
     */
    public function actionMaker($productType, $maker)
    {
        $model = $this->findModel($productType,$maker);
        $params = Yii::$app->request->get();
        $params['maker']= $model->id;
        $searchForm = new ProductSearchForm();
        $searchForm->load($params);
        $query = Product::find()->where(['AND',['make'=>$model->id],['product.status'=>1]])->orderBy('product.updated_at DESC');
        if (!empty($params['ProductSearchForm']['specs'])) {
            $searchForm->specifications = $params['ProductSearchForm']['specs'];
        }
        if (!isset($params['sort']) || $params['sort'] === '') {
            $query->orderBy('updated_at DESC');
        }
        $searchForm->search($query);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 18,
            ],
            'sort' => [
                'attributes' => [
                    'price' => [
                        'label' => 'Цене'
                    ],
                    'created_at' => [
                        'asc' => ['created_at' => SORT_DESC],
                        'desc' => ['created_at' => SORT_ASC],
                        'label' => 'Дате подачи'
                    ],
                    'year' => [
                        'label' => 'Году выпуска'
                    ],
                ]
            ]
        ]);

        if (Yii::$app->request->isAjax) {
            $this->layout = false;
        }

        return $this->render('indexBrand', [
            'provider' => $provider,
            'searchForm' => $searchForm,
            'metaData' => $this->getMetaData($searchForm),
            '_params_'=> $params
        ]);

//        $params = Yii::$app->request->get();
//
//        $model = $this->findModel($productType,$maker);
//        $searchForm = new ProductSearchForm();
//        $query = Product::find()->where(['AND',['make'=>$model->id],['product.status'=>1]])->orderBy('product.updated_at DESC');
//
//
//        $searchForm->load($params);
//
//        if (!empty($params['ProductSearchForm'])) {
//            $searchForm->specifications = $params['ProductSearchForm'];
//        }
//
//        if (!isset($params['sort']) || $params['sort']==='') {
//            $query->orderBy('updated_at DESC');
//        }
//
//
//        $searchForm->search($query);
//        $provider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => [
//                'pageSize' => 18,
//            ],
//            'sort' => [
//                'attributes' => [
//                    'price'=>[
//                        'label' => 'Цене'
//                    ],
//                    'created_at' => [
//                        'asc' => ['created_at' => SORT_DESC],
//                        'desc' => ['created_at' => SORT_ASC],
//                        'label' => 'Дате подачи'
//                    ],
//                    'year'=>[
//                        'label' => 'Году выпуска'
//                    ],
//                ]
//            ]
//        ]);
//
//        if (Yii::$app->request->isAjax) {
//            $this->layout = false;
//        }
//
//
//        return $this->render('maker', [
//            'provider' => $provider,
//            'model' => $model,
//            'searchForm' => $searchForm,
//            'metaData' => $this->getMetaData($searchForm),
//        ]);
/////
//        $model = $this->findModel($productType,$maker);
//
//        return $this->render('maker', [
//            'model' => $model,
//        ]);
    }

    public function actionModelauto($productType, $maker, $modelauto)
    {
//        $typeName = ProductMake::find()->where(['id' => $modelauto])->one();
//
//        $model = ProductMake::find()->where(['and', ['depth' => 2], ['name' => $typeName->name], ['product_type' => $productType]])->one();
//
//        return $this->render('modelauto', [
//            'model' => $model,
//        ]);

        $model = $this->findModel($productType,$maker);
        $params = Yii::$app->request->get();
        $params['maker']= $model->id;
        $searchForm = new ProductSearchForm();
        $searchForm->load($params);
        $query = Product::find()->where(['AND',['make'=>$model->id],['product.status'=>1]])->orderBy('product.updated_at DESC');
        if (!empty($params['ProductSearchForm']['specs'])) {
            $searchForm->specifications = $params['ProductSearchForm']['specs'];
        }
        if (!isset($params['sort']) || $params['sort'] === '') {
            $query->orderBy('updated_at DESC');
        }
        $searchForm->search($query);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 18,
            ],
            'sort' => [
                'attributes' => [
                    'price' => [
                        'label' => 'Цене'
                    ],
                    'created_at' => [
                        'asc' => ['created_at' => SORT_DESC],
                        'desc' => ['created_at' => SORT_ASC],
                        'label' => 'Дате подачи'
                    ],
                    'year' => [
                        'label' => 'Году выпуска'
                    ],
                ]
            ]
        ]);

        if (Yii::$app->request->isAjax) {
            $this->layout = false;
        }

        return $this->render('indexBrand', [
            'provider' => $provider,
            'searchForm' => $searchForm,
            'metaData' => $this->getMetaData($searchForm),
            '_params_'=> $params
        ]);
    }

    /**
     * Finds the Product model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $alias
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($productType, $alias)
    {
        if (($model = ProductMake::find()->where(['and', ['depth' => 1], ['name' => $alias], ['product_type' => $productType]])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
