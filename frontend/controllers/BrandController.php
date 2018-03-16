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
    public $bodyClass;
    const PAGE_SIZE = 20;

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
            \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);

        }

        $searchForm->load($params);

        if (!empty($params['ProductSearchForm']['specs'])) {
            $searchForm->specifications = $params['ProductSearchForm']['specs'];
        }
        $lastPage = ceil($count / static::PAGE_SIZE);

        if (isset($params['page'])) {
            $page = intval($params['page']);
            if ($page == 1) {
                $limit = 'LIMIT ' . static::PAGE_SIZE;
            } else {
                if ($lastPage >= $page) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . static::PAGE_SIZE * ($page - 1);
                } else {
                    Yii::$app->response->statusCode = 404;
                    throw new NotFoundHttpException('Извините, данной страницы не существует.');
                }
            }
        } else {
            $page = 1;
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
            'currentPage' => $page,
            'lastPage' => $lastPage,
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
        if ($productType == 'cars' || $productType == 'moto' || $productType == 'scooter' || $productType == 'atv') {
            switch ($productType) {
                case 'cars':
                    $productType = ProductType::CARS;
                    $params['ProductSearchForm']['type'] = ProductType::CARS;
                    break;
                case 'moto':
                    $productType = ProductType::MOTO;
                    $params['ProductSearchForm']['type'] = ProductType::MOTO;
                    break;
                case 'scooter':
                    $productType = ProductType::SCOOTER;
                    $params['ProductSearchForm']['type'] = ProductType::SCOOTER;
                    break;
                case 'atv':
                    $productType = ProductType::ATV;
                    $params['ProductSearchForm']['type'] = ProductType::ATV;
                    break;
            }

            if (isset($params['page']) || isset($params['per-page']) || isset($params['sort']) ||
                isset($params['tableView']) || isset($params['ProductSearchForm'])
            ) {
                \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
            }

            if (Yii::$app->cache->exists('category_' . $productType)) {
                $count = Yii::$app->cache->getField('category_' . $productType, 'count');
            } else {
                $count = (new \yii\db\Query())
                    ->from(Product::TABLE_NAME)
                    ->where(['type' => $productType])
                    ->andWhere(['status' => Product::STATUS_PUBLISHED])
                    ->andWhere(['priority' => Product::LOW_PRIORITY])
                    ->count();

                Yii::$app->cache->hmset('category_' . $productType, ['count' => $count], 10000);
            }
            $params['count'] = $count;
            $connection = Yii::$app->getDb();
            $lastPage = ceil($count / static::PAGE_SIZE);
            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE;
                } else {
                    if ($lastPage >= $page) {
                        $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . ($page - 1) * static::PAGE_SIZE;
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            } else {
                $page = 1;
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
    SELECT id FROM " . Product::TABLE_NAME . "  WHERE  type = $productType 
    AND priority = " . Product::LOW_PRIORITY . "
    AND   status = " . Product::STATUS_PUBLISHED . " " . $sort . " " . $limit . " ");
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
                'lastPage' => $lastPage,
                'currentPage' => $page,
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
        $params = Yii::$app->request->get();
        if ($productType == 'cars' || $productType == 'moto' || $productType == 'scooter' || $productType == 'atv') {
            switch ($productType) {
                case 'cars':
                    $productType = ProductType::CARS;
                    $params['ProductSearchForm']['type'] = ProductType::CARS;
                    break;
                case 'moto':
                    $productType = ProductType::MOTO;
                    $params['ProductSearchForm']['type'] = ProductType::MOTO;
                    break;
                case 'scooter':
                    $productType = ProductType::SCOOTER;
                    $params['ProductSearchForm']['type'] = ProductType::SCOOTER;
                    break;
                case 'atv':
                    $productType = ProductType::ATV;
                    $params['ProductSearchForm']['type'] = ProductType::ATV;
                    break;
            }
            $maker = ProductMake::find()->where(['name' => $maker])->andWhere(['product_type' => $productType])->one();

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
            $lastPage = ceil($count / static::PAGE_SIZE);
            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE;
                } else {
                    if ($lastPage >= $page) {
                        $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . static::PAGE_SIZE * ($page - 1);
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            } else {
                $page = 1;
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

            if (isset($params['page']) || isset($params['per-page']) || isset($params['sort']) ||
                isset($params['tableView']) || isset($params['ProductSearchForm'])
            ) {
                \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
            }

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
    SELECT id FROM " . Product::TABLE_NAME . "  WHERE  type = $productType AND make = $maker->id AND  
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
                'description' => $maker->description,
                'count' => $count,
                'lastPage' => $lastPage,
                'currentPage' => $page,
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
        if ($productType == 'cars' || $productType == 'moto' || $productType == 'scooter' || $productType == 'atv') {
            switch ($productType) {
                case 'cars':
                    $productType = ProductType::CARS;
                    $params['ProductSearchForm']['type'] = ProductType::CARS;
                    break;
                case 'moto':
                    $productType = ProductType::MOTO;
                    $params['ProductSearchForm']['type'] = ProductType::MOTO;
                    break;
                case 'scooter':
                    $productType = ProductType::SCOOTER;
                    $params['ProductSearchForm']['type'] = ProductType::SCOOTER;
                    break;
                case 'atv':
                    $productType = ProductType::ATV;
                    $params['ProductSearchForm']['type'] = ProductType::ATV;
                    break;
            }


            $modelauto = str_replace('+', ' ', $modelauto);
            $maker = str_replace('+', ' ', $maker);

            $maker = ProductMake::find()->where(['name' => $maker])->andWhere(['product_type' => $productType])->one();
            $description = ProductMake::find()->select('description ')->where(['name' => $modelauto])->andWhere(['between', 'lft', $maker->lft, $maker->rgt])->andWhere(['product_type' => $productType])->one();
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
            $lastPage = ceil($count / static::PAGE_SIZE);
            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE;
                } else {
                    if ($lastPage >= $page) {
                        $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . static::PAGE_SIZE * ($page - 1);
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            } else {
                $page = 1;
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
            if (isset($params['page']) || isset($params['per-page']) || isset($params['sort']) ||
                isset($params['tableView']) || isset($params['ProductSearchForm'])
            ) {
                \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
            }


            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
    SELECT id FROM " . Product::TABLE_NAME . "  WHERE  type = $productType AND make = $maker->id AND model = '$modelauto' AND  
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
                'description' => $description->description,
                'count' => $count,
                'lastPage' => $lastPage,
                'currentPage' => $page,
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
        \Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, nofollow'
        ]);

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
        if ($productType == 'cars' || $productType == 'moto' || $productType == 'scooter' || $productType == 'atv') {
            switch ($productType) {
                case 'cars':
                    $productType = ProductType::CARS;
                    $params['ProductSearchForm']['type'] = ProductType::CARS;
                    break;
                case 'moto':
                    $productType = ProductType::MOTO;
                    $params['ProductSearchForm']['type'] = ProductType::MOTO;
                    break;
                case 'scooter':
                    $productType = ProductType::SCOOTER;
                    $params['ProductSearchForm']['type'] = ProductType::SCOOTER;
                    break;
                case 'atv':
                    $productType = ProductType::ATV;
                    $params['ProductSearchForm']['type'] = ProductType::ATV;
                    break;
            }

            $searchCount = new ProductSearchForm();
            $query = Product::find()->active();
            if (!empty($params['ProductSearchForm']['makes'])) {
                $searchCount->make = $params['ProductSearchForm']['makes'];
            }
            if (!empty($params['ProductSearchForm']['specs'])) {
                $searchCount->specifications = $params['ProductSearchForm']['specs'];
            }
            if (!empty($params['ProductSearchForm']['city_id'])) {
                $searchCount->city_id = $params['ProductSearchForm']['city_id'];
            }
            if (!empty($params['ProductSearchForm']['specs'])) {
                $searchCount->specifications = $params['ProductSearchForm']['specs'];
            }
            if (!empty($params['ProductSearchForm']['city_id'])) {
                $searchCount->city_id = $params['ProductSearchForm']['city_id'];
            }
            if (!empty($params['ProductSearchForm']['yearFrom'])) {
                $searchCount->yearFrom = $params['ProductSearchForm']['yearFrom'];
            }
            if (!empty($params['ProductSearchForm']['priceTo'])) {
                $searchCount->priceTo = $params['ProductSearchForm']['priceTo'];
            }
            if (!empty($params['ProductSearchForm']['priceFrom'])) {
                $searchCount->priceFrom = $params['ProductSearchForm']['priceFrom'];
            }
            if (!empty($params['ProductSearchForm']['region'])) {
                $searchCount->region = $params['ProductSearchForm']['region'];
            }
            if (!empty($params['ProductSearchForm']['published'])) {
                $searchCount->published = $params['ProductSearchForm']['published'];
            }
            if (!empty($params['ProductSearchForm']['yearTo'])) {
                $searchCount->yearTo = $params['ProductSearchForm']['yearTo'];
            }
            if (!empty($params['ProductSearchForm']['model'])) {
                $searchCount->model = $params['ProductSearchForm']['model'];
            }
            $searchCount->load($params);
            $count = $searchCount->count($query);
            unset($query);
            unset($searchCount);

            $searchForm = new ProductSearchForm();
            $query = Product::find()->active();
            if (!empty($params['ProductSearchForm']['specs'])) {
                $searchForm->specifications = $params['ProductSearchForm']['specs'];
            }
            if (!empty($params['ProductSearchForm']['city_id'])) {
                $searchForm->city_id = $params['ProductSearchForm']['city_id'];
            }
            if (!empty($params['ProductSearchForm']['yearFrom'])) {
                $searchForm->yearFrom = $params['ProductSearchForm']['yearFrom'];
            }
            if (!empty($params['ProductSearchForm']['priceTo'])) {
                $searchForm->priceTo = $params['ProductSearchForm']['priceTo'];
            }
            if (!empty($params['ProductSearchForm']['priceFrom'])) {
                $searchForm->priceFrom = $params['ProductSearchForm']['priceFrom'];
            }
            if (!empty($params['ProductSearchForm']['region'])) {
                $searchForm->region = $params['ProductSearchForm']['region'];
            }
            if (!empty($params['ProductSearchForm']['published'])) {
                $searchForm->published = $params['ProductSearchForm']['published'];
            }
            if (!empty($params['ProductSearchForm']['yearTo'])) {
                $searchForm->yearTo = $params['ProductSearchForm']['yearTo'];
            }
            if (!empty($params['ProductSearchForm']['makes'])) {
                $searchForm->make = $params['ProductSearchForm']['makes'];
            }
            if (!empty($params['ProductSearchForm']['model'])) {
                $searchForm->model = $params['ProductSearchForm']['model'];
            }
            $searchForm->load($params);

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

            $lastPage = ceil($count / static::PAGE_SIZE);
            if (isset($params['page'])) {
                $page = intval($params['page']);
                if ($page == 1) {
                    $query->limit(static::PAGE_SIZE);
                } else {
                    if ($lastPage >= $page) {
                        $query->limit(static::PAGE_SIZE);
                        $query->offset(static::PAGE_SIZE * ($page - 1));
                    } else {
                        Yii::$app->response->statusCode = 404;
                        throw new NotFoundHttpException('Извините, данной страницы не существует.');
                    }
                }
            } else {
                $query->limit(static::PAGE_SIZE);
                $page = 1;
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
                'lastPage' => $lastPage,
                'currentPage' => $page,
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
//                \Yii::$app->view->registerMetaTag([
//                    'name' => 'robots',
//                    'content' => 'noindex, nofollow'
//                ]);
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
