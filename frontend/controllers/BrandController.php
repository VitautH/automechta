<?php

namespace frontend\controllers;

use common\components\Uploads;
use common\models\ProductType;
use yii\data\ActiveDataProvider;
use Yii;
use yii\data\Sort;
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
use yii\helpers\Url;
use Redis;
use yii\data\Pagination;

/**
 * Catalog controller
 */
class BrandController extends Controller
{
    public $layout = 'index';
    const PAGE_SIZE = 10;

    public function behaviors()
    {
        return [
            [
                'class' => UploadsBehavior::className(),
            ]
        ];
    }

    /*
     * New Controller
     */
    public function actionCategorycompany()
    {
        $sort = 'ORDER BY `updated_at` DESC';
        $limit = 'LIMIT ' . static::PAGE_SIZE;
        $sortData = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Цене',
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дате подачи',
                ],
                'year' => [
                    'asc' => ['year' => SORT_ASC],
                    'desc' => ['year' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Году выпуска',
                ],
            ],
        ]);

        $searchForm = new ProductSearchForm();
        $query = Product::find()->where(['priority' => 1])->active();
        $params = Yii::$app->request->get();

        if (Yii::$app->cache->exists('category_comapany')) {
            $count = Yii::$app->cache->getField('category_comapany', 'count');
        } else {
            $count = (new \yii\db\Query())
                ->from(Product::TABLE_NAME)
                ->where(['priority' => 1])
                ->andWhere(['status' => Product::STATUS_PUBLISHED])
                ->count();
            Yii::$app->cache->hmset('category_comapany', ['count' => $count], 10000);
        }
        $params['count'] = $count;
        $connection = Yii::$app->getDb();

        if (isset($params['page']) || isset($params['per-page']) || isset($params['sort']) ||
            isset($params['tableView']) || isset($params['ProductSearchForm'])
        ) {
            \Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, nofollow'
            ]);
        }

        $searchForm->load($params);

        if (!empty($params['ProductSearchForm']['specs'])) {
            $searchForm->specifications = $params['ProductSearchForm']['specs'];
        }

        if (isset($params['page'])) {
            $page = intval($params['page']);
            if ($page == 1) {
                $limit = 'LIMIT ' . static::PAGE_SIZE;
            } else {
                if (ceil($count / static::PAGE_SIZE) >= $page) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . ($page * static::PAGE_SIZE * (2 - 1));
                } else {
                    Yii::$app->response->statusCode = 404;
                    throw new NotFoundHttpException('Извините, данной страницы не существует.');
                }
            }
        }

        if (isset($params['sort'])) {
            switch ($params['sort']) {
                case 'price':
                    $sort = 'ORDER BY `price` DESC';
                    break;
                case '-price':
                    $sort = 'ORDER BY `price` ASC';
                    break;
                case 'created_at':
                    $sort = 'ORDER BY `created_at` DESC';
                    break;
                case '-created_at':
                    $sort = 'ORDER BY `created_at` ASC';
                    break;
                case 'year':
                    $sort = 'ORDER BY `year` DESC';
                    break;
                case '-year':
                    $sort = 'ORDER BY `year` ASC';
                    break;

            }

        }


        $command = $connection->createCommand("
    SELECT id FROM " . Product::TABLE_NAME . "  WHERE priority = 1 AND  status = " . Product::STATUS_PUBLISHED . " " . $sort . " " . $limit . " ");
        $result = $command->queryAll();

        $searchForm->search($query);

        $products = [];

        foreach ($result as $i => $id) {
            if (Yii::$app->cache->exists('product_' . $id['id'])) {

                $products[] = json_decode(Yii::$app->cache->getField('product_' . $id['id'], 'product'));
            } else {
                $result = Product::getProduct($id['id']);
                $products[] = $result['product'];
            }
        }

        $pages = new Pagination(['totalCount' => $count, 'pageSize' => static::PAGE_SIZE]);
        $pages->pageSizeParam = false;


        return $this->render('categoryCompany', [
            'products' => $products,
            'count' => $count,
            'pages' => $pages,
            'sort' => $sortData,
            'searchForm' => $searchForm,
            'metaData' => $this->getMetaData($searchForm),
            '_params_' => $params
        ]);
    }

    public function actionNewcategory($productType)
    {
        $sort = 'ORDER BY `updated_at` DESC';
        $limit = 'LIMIT ' . static::PAGE_SIZE;
        $sortData = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Цене',
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дате подачи',
                ],
                'year' => [
                    'asc' => ['year' => SORT_ASC],
                    'desc' => ['year' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Году выпуска',
                ],
            ],
        ]);
        $params = Yii::$app->request->get();
        if ($productType == 'cars' || $productType == 'moto') {
            switch ($productType) {
                case 'cars':
                    $productType = 2;
                    $params['ProductSearchForm']['type'] = 2;
                    break;
                case 'moto':
                    $productType = 3;
                    $params['ProductSearchForm']['type'] = 3;
                    break;
            }

            if (isset($params['page']) || isset($params['per-page']) || isset($params['sort']) ||
                isset($params['tableView']) || isset($params['ProductSearchForm'])
            ) {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'robots',
                    'content' => 'noindex, nofollow'
                ]);
            }
            if (Yii::$app->cache->exists('category_' . $productType)) {
                $count = Yii::$app->cache->getField('category_' . $productType, 'count');
            } else {
                $count = (new \yii\db\Query())
                    ->from(Product::TABLE_NAME)
                    ->where(['type' => $productType])
                    ->andWhere(['status' => Product::STATUS_PUBLISHED])
                    ->count();
                Yii::$app->cache->hmset('category_' . $productType, ['count' => $count], 10000);
            }
            $params['count'] = $count;
            $connection = Yii::$app->getDb();
            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE;
                } else {
                    if (ceil($count / static::PAGE_SIZE) >= $page) {
                        $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . ($page * static::PAGE_SIZE * (2 - 1));
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            }

            if (isset($params['sort'])) {
                switch ($params['sort']) {
                    case 'price':
                        $sort = 'ORDER BY `price` DESC';
                        break;
                    case '-price':
                        $sort = 'ORDER BY `price` ASC';
                        break;
                    case 'created_at':
                        $sort = 'ORDER BY `created_at` DESC';
                        break;
                    case '-created_at':
                        $sort = 'ORDER BY `created_at` ASC';
                        break;
                    case 'year':
                        $sort = 'ORDER BY `year` DESC';
                        break;
                    case '-year':
                        $sort = 'ORDER BY `year` ASC';
                        break;

                }

            }

            $command = $connection->createCommand("
    SELECT id FROM " . Product::TABLE_NAME . "  WHERE type = $productType AND  
    status = " . Product::STATUS_PUBLISHED . " " . $sort . " " . $limit . " ");
            $result = $command->queryAll();
            $products = [];

            foreach ($result as $i => $id) {
                if (Yii::$app->cache->exists('product_' . $id['id'])) {

                    $products[] = json_decode(Yii::$app->cache->getField('product_' . $id['id'], 'product'));
                } else {
                    $result = Product::getProduct($id['id']);
                    $products[] = $result['product'];
                }
            }

            $pages = new Pagination(['totalCount' => $count, 'pageSize' => static::PAGE_SIZE]);
            $pages->pageSizeParam = false;
            $searchForm = new ProductSearchForm();
            $searchForm->load($params);


            return $this->render('category', [
                'products' => $products,
                'count' => $count,
                'pages' => $pages,
                'sort' => $sortData,
                'searchForm' => $searchForm,
                'metaData' => $this->getMetaData($searchForm),
                'type' => $productType,
                '_params_' => $params
            ]);

        } else {
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }
    }

    /**
     * @param string $productType product type id
     * @param string $maker product make
     *
     * @return index
     */
    public function actionNewmaker($productType, $maker)
    {
        $sort = 'ORDER BY `updated_at` DESC';
        $limit = 'LIMIT ' . static::PAGE_SIZE;
        $sortData = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Цене',
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дате подачи',
                ],
                'year' => [
                    'asc' => ['year' => SORT_ASC],
                    'desc' => ['year' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Году выпуска',
                ],
            ],
        ]);
        $maker = str_replace('+', ' ', $maker);
        $maker = ProductMake::find()->where(['name' => $maker])->one();
        $params = Yii::$app->request->get();
        if ($productType == 'cars' || $productType == 'moto') {
            switch ($productType) {
                case 'cars':
                    $productType = 2;
                    $params['ProductSearchForm']['type'] = 2;
                    break;
                case 'moto':
                    $productType = 3;
                    $params['ProductSearchForm']['type'] = 3;
                    break;
            }
            if (Yii::$app->cache->exists('category_' . $maker->id)) {
                $count = Yii::$app->cache->getField('category_' . $maker->id, 'count');
            } else {
                $count = (new \yii\db\Query())
                    ->from(Product::TABLE_NAME)
                    ->where(['type' => $productType])
                    ->andWhere(['make' => $maker->id])
                    ->andWhere(['status' => Product::STATUS_PUBLISHED])
                    ->count();
                Yii::$app->cache->hmset('category_' . $maker->id, ['count' => $count], 10000);
            }
            $params['count'] = $count;

            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE;
                } else {
                    if (ceil($count / static::PAGE_SIZE) >= $page) {
                        $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . ($page * static::PAGE_SIZE * (2 - 1));
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            }

            if (isset($params['sort'])) {
                switch ($params['sort']) {
                    case 'price':
                        $sort = 'ORDER BY `price` DESC';
                        break;
                    case '-price':
                        $sort = 'ORDER BY `price` ASC';
                        break;
                    case 'created_at':
                        $sort = 'ORDER BY `created_at` DESC';
                        break;
                    case '-created_at':
                        $sort = 'ORDER BY `created_at` ASC';
                        break;
                    case 'year':
                        $sort = 'ORDER BY `year` DESC';
                        break;
                    case '-year':
                        $sort = 'ORDER BY `year` ASC';
                        break;

                }

            }
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
    SELECT id FROM " . Product::TABLE_NAME . "  WHERE type = $productType AND make = $maker->id AND  
    status = " . Product::STATUS_PUBLISHED . " " . $sort . " " . $limit . " ");
            $result = $command->queryAll();

            $products = [];

            foreach ($result as $i => $id) {
                if (Yii::$app->cache->exists('product_' . $id['id'])) {

                    $products[] = json_decode(Yii::$app->cache->getField('product_' . $id['id'], 'product'));
                } else {
                    $result = Product::getProduct($id['id']);
                    $products[] = $result['product'];
                }
            }

            $pages = new Pagination(['totalCount' => $count, 'pageSize' => static::PAGE_SIZE]);
            $pages->pageSizeParam = false;


            $params['ProductSearchForm']['type'] = $productType;
            $params['ProductSearchForm']['make'] = $maker->id;
            $params['maker'] = $maker->id;
            $meta = [
                'title' => '',
            ];

            $meta['title'] = $maker->name;

            $meta['title'] = 'Купить ' . $meta['title'] . ' в Беларуси в кредит - цены, характеристики, фото. Продажа ' . $meta['title'] . ' в автосалоне АвтоМечта';

            $meta['description'] = 'Большой выбор ' . $meta['title'] . ' с пробегом в Минске. У нас можно купить авто в кредит всего за 1 час, продажа бу ' . $meta['title'] . ' в Минске и Беларуси. Оформление машины в кредит проходит на месте';


            $searchForm = new ProductSearchForm();
            $searchForm->load($params);

            switch ($productType) {
                case 2 :
                    $params['ProductSearchForm']['type'] = 2;
                    break;
                case 3 :
                    $params['ProductSearchForm']['type'] = 3;
                    break;
            }


            return $this->render('maker', [
                'products' => $products,
                'count' => $count,
                'pages' => $pages,
                'sort' => $sortData,
                'make_id' => $maker->id,
                'make_name' => $maker->name,
                'searchForm' => $searchForm,
                'metaData' => $meta,
                'type' => $productType,
                '_params_' => $params
            ]);


        } else {
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }
    }

    public function actionNewmodelauto($productType, $maker, $modelauto)
    {
        $sort = 'ORDER BY `updated_at` DESC';
        $limit = 'LIMIT ' . static::PAGE_SIZE;
        $sortData = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Цене',
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дате подачи',
                ],
                'year' => [
                    'asc' => ['year' => SORT_ASC],
                    'desc' => ['year' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Году выпуска',
                ],
            ],
        ]);
        $params = Yii::$app->request->get();
        if ($productType == 'cars' || $productType == 'moto') {
            switch ($productType) {
                case 'cars':
                    $productType = 2;
                    $params['ProductSearchForm']['type'] = 2;
                    break;
                case 'moto':
                    $productType = 3;
                    $params['ProductSearchForm']['type'] = 3;
                    break;
            }


            $modelauto = str_replace('+', ' ', $modelauto);
            $maker = str_replace('+', ' ', $maker);

            $maker = ProductMake::find()->where(['name' => $maker])->one();

            if (Yii::$app->cache->exists('category_' . $maker->id . '_' . $modelauto)) {
                $count = Yii::$app->cache->getField('category_' . $maker->id . '_' . $modelauto, 'count');
            } else {
                $count = (new \yii\db\Query())
                    ->from(Product::TABLE_NAME)
                    ->where(['type' => $productType])
                    ->andWhere(['make' => $maker->id])
                    ->andWhere(['model' => $modelauto])
                    ->andWhere(['status' => Product::STATUS_PUBLISHED])
                    ->count();
                Yii::$app->cache->hmset('category_' . $maker->id . '_' . $modelauto, ['count' => $count], 10000);
            }
            $params['count'] = $count;

            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE;
                } else {
                    if (ceil($count / static::PAGE_SIZE) >= $page) {
                        $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . ($page * static::PAGE_SIZE * (2 - 1));
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            }

            if (isset($params['sort'])) {
                switch ($params['sort']) {
                    case 'price':
                        $sort = 'ORDER BY `price` DESC';
                        break;
                    case '-price':
                        $sort = 'ORDER BY `price` ASC';
                        break;
                    case 'created_at':
                        $sort = 'ORDER BY `created_at` DESC';
                        break;
                    case '-created_at':
                        $sort = 'ORDER BY `created_at` ASC';
                        break;
                    case 'year':
                        $sort = 'ORDER BY `year` DESC';
                        break;
                    case '-year':
                        $sort = 'ORDER BY `year` ASC';
                        break;

                }

            }

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
    SELECT id FROM " . Product::TABLE_NAME . "  WHERE type = $productType AND make = $maker->id AND model = '$modelauto' AND  
    status = " . Product::STATUS_PUBLISHED . " " . $sort . " " . $limit . " ");
            $result = $command->queryAll();

            $products = [];

            foreach ($result as $i => $id) {
                if (Yii::$app->cache->exists('product_' . $id['id'])) {

                    $products[] = json_decode(Yii::$app->cache->getField('product_' . $id['id'], 'product'));
                } else {
                    $result = Product::getProduct($id['id']);
                    $products[] = $result['product'];
                }
            }

            $pages = new Pagination(['totalCount' => $count, 'pageSize' => static::PAGE_SIZE]);
            $pages->pageSizeParam = false;

            $params['type'] = $productType;
            $params['maker_id'] = $maker->id;
            $params['maker_name'] = $maker->name;
            $params['model_name'] = $modelauto;
            $meta = [
                'title' => '',
            ];


            $meta['title'] = $maker->name . ' ' . $modelauto;

            $meta['title'] = 'Купить ' . $meta['title'] . ' в Беларуси в кредит - цены, характеристики, фото. Продажа ' . $meta['title'] . ' в автосалоне АвтоМечта';

            $meta['description'] = 'Большой выбор ' . $meta['title'] . ' с пробегом в Минске. У нас можно купить авто в кредит всего за 1 час, продажа бу ' . $meta['title'] . ' в Минске и Беларуси. Оформление машины в кредит проходит на месте';


            $searchForm = new ProductSearchForm();
            $params['ProductSearchForm']['type'] = $productType;
            $params['ProductSearchForm']['make'] = $maker->id;
            $params['ProductSearchForm']['model'] = $maker->name;
            $params['maker'] = $maker->id;
            $searchForm->load($params);

            return $this->render('modelauto', [
                'products' => $products,
                'count' => $count,
                'pages' => $pages,
                'sort' => $sortData,
                'make_id' => $maker->id,
                'make_name' => $maker->name,
                'searchForm' => $searchForm,
                'metaData' => $meta,
                'type' => $productType,
                '_params_' => $params
            ]);

        }
    }

    public function actionSearch($productType)
    {

        $sortData = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Цене',
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дате подачи',
                ],
                'year' => [
                    'asc' => ['year' => SORT_ASC],
                    'desc' => ['year' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Году выпуска',
                ],
            ],
        ]);

        \Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, nofollow'
        ]);
        $params = Yii::$app->request->get();
        if ($productType == 'cars' || $productType == 'moto') {
            switch ($productType) {
                case 'cars':
                    $productType = 2;
                    $params['ProductSearchForm']['type'] = 2;
                    break;
                case 'moto':
                    $productType = 3;
                    $params['ProductSearchForm']['type'] = 3;
                    break;
            }

            $searchCount = new ProductSearchForm();
            $query = Product::find()->active();
            $params['ProductSearchForm']['makes'] = ProductMake::find()->where(['id' => $params['ProductSearchForm']['makes']])->one()->name;
            $searchCount->load($params);
            if (!empty($params['ProductSearchForm']['specs'])) {
                $searchCount->specifications = $params['ProductSearchForm']['specs'];
            }
            $count = $searchCount->count($query);
            unset($query);
            unset($searchCount);
            $searchForm = new ProductSearchForm();
            $query = Product::find()->active();
            $searchForm->load($params);
            if (!empty($params['ProductSearchForm']['specs'])) {
                $searchForm->specifications = $params['ProductSearchForm']['specs'];
            }
            if (isset($params['sort'])) {
                switch ($params['sort']) {
                    case 'price':
                        $query->orderBy('product.price DESC');
                        break;
                    case '-price':
                        $query->orderBy('product.price ASC');
                        break;
                    case 'created_at':
                        $query->orderBy('product.created_at DESC');
                        break;
                    case '-created_at':
                        $query->orderBy('product.created_at ASC');
                        break;
                    case 'year':
                        $query->orderBy('product.year DESC');
                        break;
                    case '-year':
                        $query->orderBy('product.year ASC');
                        break;
                    default:
                        $query->orderBy('product.updated_at DESC');
                        break;
                }
            } else {
                $query->orderBy('product.updated_at DESC');
            }


            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $query->limit(static::PAGE_SIZE);
                } else {
                    if (ceil($count / static::PAGE_SIZE) >= $page) {
                        $query->limit(static::PAGE_SIZE);
                        $query->offset((static::PAGE_SIZE * $page) - static::PAGE_SIZE);
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            } else {
                $query->limit(static::PAGE_SIZE);
            }

            $result = $searchForm->search($query)->select('product.id')->asArray()->all();

            $params['count'] = $count;
            $products = [];
            foreach ($result as $i => $id) {
                if (Yii::$app->cache->exists('product_' . $id['id'])) {

                    $products[] = json_decode(Yii::$app->cache->getField('product_' . $id['id'], 'product'));
                } else {
                    $result = Product::getProduct($id['id']);
                    $products[] = $result['product'];
                }
            }
            $pages = new Pagination(['totalCount' => $count, 'pageSize' => static::PAGE_SIZE]);
            $pages->pageSizeParam = false;

            return $this->render('search', [
                'products' => $products,
                'searchForm' => $searchForm,
                'sort' => $sortData,
                'pages' => $pages,
                'metaData' => $this->getMetaData($searchForm),
                'type' => $productType,
                '_params_' => $params
            ]);
        } else {
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }

    }

    /*
     *  Old Controller
     */
    public function actionCategory($productType)
    {
        $params = Yii::$app->request->get();
        if ($productType == 2 || $productType == 3) {
            switch ($productType) {
                case 2:
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/cars");
                    die();
                    $params['ProductSearchForm']['type'] = 2;
                    break;
                case 3:
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/moto");
                    die();
                    $params['ProductSearchForm']['type'] = 3;
                    break;
            }

            if (isset($params['page']) || isset($params['per-page']) || isset($params['sort']) ||
                isset($params['tableView']) || isset($params['ProductSearchForm'])
            ) {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'robots',
                    'content' => 'noindex, nofollow'
                ]);
            }

            $searchForm = new ProductSearchForm();
            $query = Product::find()->active();
            $searchForm->load($params);

            if (!empty($params['ProductSearchForm']['specs'])) {
                $searchForm->specifications = $params['ProductSearchForm']['specs'];
            }

            if (!isset($params['sort']) || $params['sort'] === '') {
                $query->orderBy('updated_at DESC');
            }


            $count = $searchForm->search($query)->count();
            $params['count'] = $count;

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
                'type' => $productType,
                '_params_' => $params
            ]);
        } else {
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }
    }

    /**
     * @param string $productType product type id
     * @param string $maker product make
     *
     * @return index
     */
    public function actionMaker($productType, $maker)
    {
        $maker = str_replace(' ', '+', $maker);
        if ($productType == 2 || $productType == 3) {
            switch ($productType) {
                case 2:
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/cars/" . $maker . "");
                    die();
                    break;
                case 3:
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/moto/" . $maker . "");
                    die();
                    break;
            }
        } else {
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }
    }

    public function actionModelauto($productType, $maker, $modelauto)
    {
        $modelAuto = ProductMake::find()->where(['id' => $modelauto])->one()->name;
        $modelAuto = str_replace(' ', '+', $modelAuto);
        $maker = str_replace(' ', '+', $maker);
        if ($productType == 2 || $productType == 3) {
            switch ($productType) {
                case 2:
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/cars/" . $maker . "/" . $modelAuto);
                    die();
                    break;
                case 3:
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/moto/" . $maker . "/" . $modelAuto);
                    die();
                    break;
            }
        } else {
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }
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
