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
use yii\helpers\Json;
use common\models\Complaint;

/**
 * Catalog controller
 */
class CatalogController extends Controller
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
    public function actionIndex()
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: https://" . $_SERVER['HTTP_HOST'] . "/cars/company");
        die();
    }

    /**
     * @param integer $id product id
     * Old Controller
     * @return index
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShow($id)
    {
        $model = $this->findModel($id);
        if (($model->status !== Product::STATUS_PUBLISHED) || (empty($model))) {
            Yii::$app->response->statusCode = 404;

            return $this->render('sold');
        } else {
            $type = $model->type;
            $make = ProductMake::find()->where(['id' => $model->make])->one()->name;
            $make = str_replace(' ', '+', $make);
            $modelAuto = $model->model;
            $modelAuto = str_replace(' ', '+', $modelAuto);
            switch ($type) {
                case 2:
                    $type = 'cars';
                    break;
                case 3:
                    $type = 'moto';
                    break;
            }
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: https://" . $_SERVER['HTTP_HOST'] . "/" . $type . "/" . $make . "/" . $modelAuto . "/" . $model->id);
            die();
        }

        $model->increaseViews();

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    /*
     * New Controller
     */
    public function actionNewshow($productType, $maker, $modelauto, $id)
    {
        if ($productType == 'cars' || $productType == 'moto') {
            switch ($productType) {
                case 'cars':
                    $productType = 2;
                    break;
                case 'moto':
                    $productType = 3;
                    break;
            }
            $modelauto = str_replace('+', ' ', $modelauto);
            $maker = str_replace('+', ' ', $maker);
            $make = ProductMake::find()->where(['name' => $maker])->andWhere(['product_type' => $productType])->one()->id;

            if (($model = Product::find()->where(['id' => $id])->andWhere(['type' => $productType])
                    ->andWhere(['make' => $make])->andWhere(['model' => $modelauto])->one()) !== null
            ) {
                if (($model->status !== Product::STATUS_PUBLISHED) || (empty($model))) {
                    Yii::$app->response->statusCode = 404;

                    return $this->render('sold');
                } else {
                    $model->increaseViews();

                    // Cache
                    if (Yii::$app->cache->exists('product_' . $id)) {
                        Yii::$app->cache->hincr('product_' . $id);
                        $product = json_decode(Yii::$app->cache->getField('product_' . $id, 'product'));
                        $views = Yii::$app->cache->getField('product_' . $id, 'counter');
                    } else {

                        /*
                         * Product
                         */
                        $product = [];
                        $product ['id'] = $model->id;
                        $product ['make'] = $model->getMake0()->one()->name;
                        $product ['type'] = $model->type;
                        $product['makeid'] = ProductMake::find()->where(['and', ['depth' => $model->type], ['name' => $model->model], ['product_type' => $model->type]])->one()->id;
                        $product ['model'] = $model->model;
                        $product ['year'] = $model->year;
                        $product ['title'] = $model->getFullTitle();
                        $product ['title_image'] =  $model->getTitleImageUrl(267, 180);
                        $product ['short_title'] = $model->i18n()->title;
                        $product ['price_byn'] = $model->getByrPrice();
                        $product ['price_usd'] = $model->getUsdPrice();
                        $product ['exchange'] = $model->exchange;
                        $product ['auction'] = $model->auction;
                        $product ['priority'] = $model->priority;
                        $product ['seller_comments'] = $model->i18n()->seller_comments;
                        $product ['created_at'] = $model->created_at;
                        $product ['created_by'] = $model->created_by;
                        $product ['updated_at'] = $model->updated_at;
                        $product ['phone'] = $model->phone;
                        $product ['phone_2'] = $model->phone_2;
                        $product ['phone_provider_2'] = $model->phone_provider_2;
                        $product ['first_name'] = $model->first_name;
                        $product ['region'] = $model->region;

                        /*
                         * Image
                         */
                        $uploads = $model->getUploads();
                        $product ['image'] = [];
                        foreach ($uploads as $i => $upload) {
                            $product  ['image'] [$i] ['full'] = $upload->getThumbnail(800, 460);
                            $product  ['image'] [$i] ['thumbnail'] = $upload->getThumbnail(115, 85);
                        }

                        /*
                         * Specification
                         */
                        $productSpecifications = $model->getSpecifications();
                        $productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
                            $specification = $productSpec->getSpecification()->one();
                            return $specification->type != Specification::TYPE_BOOLEAN;
                        });
                        $productSpecificationsMain = array_values($productSpecificationsMain);
                        $productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
                            $specification = $productSpec->getSpecification()->one();
                            return $specification->type == Specification::TYPE_BOOLEAN;
                        });
                        $productSpecificationsAdditional = array_values($productSpecificationsAdditional);
                        foreach ($productSpecificationsAdditional as $key => $productSpecification) {
                            $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
                        }

                        /*
                        * Additional specification
                        */
                        $product ['specAdditional'] = [];
                        $countSpecifications = ProductSpecification::find()->where(['product_id' => $model->id])
                            ->andWhere(['value' => 1])->count();
                        if ($countSpecifications > 0) {
                            foreach ($productSpecificationsAdditionalCols as $i => $productSpecificationsAdditionalCol) {
                                foreach ($productSpecificationsAdditionalCol as $i => $productSpecificationsAdditional) {
                                    $spec = $productSpecificationsAdditional->getSpecification()->one();
                                    if ((int)$productSpecificationsAdditional->value == 1) {
                                        $product  ['spec_additional'] [$i] ['name'] = $spec->i18n()->name;
                                    }
                                }
                            }
                        }

                        /*
                         * Main Specification
                         */
                        $product ['spec'] = [];
                        foreach ($productSpecificationsMain as $i => $productSpec) {
                            $spec = $productSpec->getSpecification()->one();
                            $product  ['spec'] [$i] ['name'] = $spec->i18n()->name;
                            $product  ['spec'] [$i] ['format'] = $productSpec->getFormattedValue();
                            $product  ['spec'] [$i] ['unit'] = $spec->i18n()->unit;
                        }

                        /*
                         * Similar product
                         */
                        $similarProducts = Product::find()
                            ->where(['status' => Product::STATUS_PUBLISHED])
                            ->andwhere(['make' => $model->make])
                            ->andWhere(['model' => $model->model])
                            ->orderBy('RAND()')
                            ->limit(4)
                            ->all();
                        $product ['similar'] = [];
                        foreach ($similarProducts as $i => $similarProduct) {
                            $product['similar'][$i]['id'] = $similarProduct->id;
                            $product['similar'][$i]['main_image_url'] = $similarProduct->getTitleImageUrl(640, 480);
                            $product['similar'][$i]['full_title'] = $similarProduct->getFullTitle();
                            $product['similar'][$i]['price_byn'] = $similarProduct->getByrPrice();
                            $product['similar'][$i]['price_usd'] = $similarProduct->getUsdPrice();
                            $product['similar'][$i]['spec'] = [];
                            foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGHEST) as $params => $productSpec) {
                                $spec = $productSpec->getSpecification()->one();
                                $product['similar'][$i]['spec'][$params]['name'] = $spec->i18n()->name;
                                $product['similar'][$i]['spec'][$params]['get_title_image_url'] = $spec->getTitleImageUrl(20, 20);
                                $product['similar'][$i]['spec'][$params]['value'] = $productSpec->getFormattedValue();
                                $product['similar'][$i]['spec'][$params]['unit'] = $spec->i18n()->unit;
                            }
                            unset($productSpec);
                            unset($params);
                            foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGH) as $params=>$productSpec) {
                                $spec = $productSpec->getSpecification()->one();
                                $product['similar'][$i]['spec'][$params]['priority_hight']['name'] = $spec->i18n()->name;
                                $product['similar'][$i]['spec'][$params]['priority_hight']['value'] = $productSpec->getFormattedValue();
                                $product['similar'][$i]['spec'][$params]['priority_hight']['unit'] = $spec->i18n()->unit;
                            }
                        }


                        $product = json_encode($product);
                        $views = $product['views'];
                        $model->views;
                        $params = [
                            'product'=>json_encode($product),
                              'counter'=>$model->views,
                        ];
                        Yii::$app->cache->hmset('product_' . $id, $params, 172800);

                    }
                    // End Cache

                    return $this->render('show', [
                        'product' => $product,
                        'views' => $views,
                        'model' => $model,
                    ]);

                }


            } else {
                Yii::$app->response->statusCode = 404;

                return $this->render('sold');
            }
        } else {
            throw new NotFoundHttpException('Извините, данной страницы не существует.');

        }

    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        if (!Yii::$app->user->can('createProduct', ['model' => $model, 'limit' => 5])) {
            Yii::$app->user->denyAccess();
        }

        $form = new ProductForm();
        $model->loadDefaultValues();

        if (isset(Yii::$app->request->get('Product')['type'])) {
            $model->type = Yii::$app->request->get('Product')['type'];
        }

        $productSpecificationModels = $this->fillSpecifications($model);

        $form->load(Yii::$app->request->get());

        if (!$form->step || !is_numeric($form->step)) {
            $form->step = 1;
        }

        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $model->status = Product::STATUS_TO_BE_VERIFIED;
            $model->priority = 0;
            $model->save();
            $this->saveSpecifications($model);
            $model->updateMetaData();
            return $this->redirect(['uploads', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'form' => $form,
                'productSpecifications' => $productSpecificationModels,
            ]);
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!Yii::$app->user->can('updateProduct', ['model' => $model])) {
            Yii::$app->user->denyAccess();
        }

        $form = new ProductForm(['step' => 2]);

        $productSpecificationModels = $this->fillSpecifications($model);
        $model->setScenario(Product::SCENARIO_DEFAULT);
        if ($model->loadI18n(Yii::$app->request->post()) && $model->validateI18n()) {
            $model->status = Product::STATUS_TO_BE_VERIFIED;
            $model->priority = 0;
            $model->save();
            $this->saveSpecifications($model);

            return $this->redirect(['uploads', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'form' => $form,
                'productSpecifications' => $productSpecificationModels,
            ]);
        }
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUploads($id)
    {
        $model = $this->findModel($id);
        if (!Yii::$app->user->can('updateProduct', ['model' => $model])) {
            Yii::$app->user->denyAccess();
        }

        $form = new ProductForm();

        $form->load(Yii::$app->request->post());
        $form->step = 3;

        if ($form->validateStep($model)) {
            $this->saveUploads($model);
            return $this->redirect(['seller-contacts', 'id' => $model->id]);
        } else {
            if ($form->hasErrors('uploads')) {
                Yii::$app->session->setFlash('error', $form->getErrors('uploads'));
            }
            return $this->render('create', [
                'model' => $model,
                'form' => $form,
            ]);
        }
    }

    public function actionComplaint()
    {
        if (Yii::$app->request->isAjax) {
            $request = Yii::$app->request->post();

            if (empty($request['complaint_text'])) {
                $request['complaint_text'] = null;
            }

            $model = new Complaint();
            $model->complaint_type = $request['complaint_type'];
            $model->complaint_text = $request['complaint_text'];
            $model->product_id = $request['id'];
            if ($model->save()) {
                return '<div class="alert alert-success" role="alert" style="margin-top: 10px;">Ваша жалоба на объявление принята</div>';
            } else {
                return '<div class="alert alert-danger" role="alert" style="margin-top: 10px;">Произошла ошибка</div>';
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionSellerContacts($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request->post();

        if (!Yii::$app->user->can('updateProduct', ['model' => $model])) {
            Yii::$app->user->denyAccess();
        }

        if (empty($request)) {

            if (!$model) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            $form = new ProductForm();
            $form->step = 4;

            return $this->render('create', [
                'model' => $model,
                'form' => $form,
            ]);
        } else {
            $model->setScenario('sellerContacts');
            $model->first_name = $request['Product']['first_name'];
            $model->region = $request['Product']['region'];
            $model->phone = $request['Product']['phone'];
            $model->phone_provider = $request['Product']['phone_provider'];
            $model->phone_2 = $request['Product']['phone_2'];
            $model->phone_provider_2 = $request['Product']['phone_provider_2'];
            if ($model->save()) {
                return $this->redirect(['product-saved', 'id' => $model->id]);
            } else {
                print_r($model->getErrors());
            }

        }
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProductSaved($id)
    {
        $model = $this->findModel($id);

        return $this->render('afterSave', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(AppData::getData()['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email'));
            }

            return $this->redirect(['catalog/show', 'id' => $model->id]);
        } else {
            return $this->render('show', [
                'model' => $this->findModel($model->id),
            ]);
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

        $model = Product::findOne($id);
        if ($model === null) {
            $model = new Product();
        }
        $model->loadI18n(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;

        $productSpecificationModels = $this->fillSpecifications($model);

        $result = ActiveForm::validateMultiple([$model]);
        $result += ActiveForm::validateMultiple($model->getI18nModels());
        $result += ActiveForm::validateMultiple($productSpecificationModels);

        return $result;
    }

    /**
     * Validate user data
     * @return array
     */
    public function actionValidateSeller($id)
    {
        $model = Product::findOne($id);
        $model->setScenario('sellerContacts');
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

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
            Yii::$app->response->statusCode = 404;

            return $this->render('sold');
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
}
