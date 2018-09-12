<?

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
use yii\base\ErrorException;
use yii\db\IntegrityException;

/**
 * Catalog controller
 */
class CreateadsController extends Controller
{
    public $layout = 'new-index';
    public $bodyClass;

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->denyAccess('Извините, чтобы разместить объявление Вам необходимо заново войти в свой аккаунт  
            или зарегистрироваться на сайте');
        }

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadsBehavior::className(),
            ]
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        if (!Yii::$app->user->can('createProduct', ['model' => $model, 'limit' => 5000])) {
            $model->delete();
            Yii::$app->user->denyAccess('НА ВАШ E-MAIL ОТПРАВЛЕНО ПИСЬМО С ССЫЛКОЙ ДЛЯ ПОДТВЕРЖДЕНИЯ РЕГИСТРАЦИИ
Пожалуйста, активируйте регистрацию, перейдя по ссылке в письме, отправленном на ваш e-mail');
        }

        $form = new ProductForm();

        if (!$form->step || !is_numeric($form->step)) {
            $form->step = 1;
        }

        if (isset(Yii::$app->request->get('Product')['type'])) {
            $model->type = Yii::$app->request->get('Product')['type'];
            $model->setScenario(Product::SCENARIO_BEFORE_CREATEADS);
            $model->status = Product::SCENARIO_BEFORE_CREATEADS;
            $model->loadDefaultValues();
            $productSpecificationModels = $this->fillSpecifications($model);
            $form->load(Yii::$app->request->get());
            try {
                $model->save();
            } catch (IntegrityException $e) {
                if (Yii::$app->user->isGuest) {
                    throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                    Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                } else {
                    throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                    транспортного средства.", 405);
                }
            } catch (\Exception $e) {
                if (Yii::$app->user->isGuest) {
                    throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                    Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                } else {
                    throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                    транспортного средства.", 405);
                }
            }

            $this->bodyClass = 'create-ads';

            return $this->render('create', [
                'model' => $model,
                'form' => $form,
                'productSpecifications' => $productSpecificationModels,
            ]);
        } else {
            $this->bodyClass = 'create-ads';

            return $this->render('create', [
                'model' => $model,
                'form' => $form,
            ]);
        }

    }

    public function actionBoat($id = null)
    {
        if(Yii::$app->user->isGuest){
            Yii::$app->user->denyAccess('Извините, чтобы разместить объявление Вам необходимо заново войти в свой аккаунт  
            или зарегистрироваться на сайте');
        }
        else {

            $request = Yii::$app->request->post();

            if (empty($request)) {
                $model = new Product();
                $model->type = 6;
                $model->setScenario(Product::SCENARIO_BEFORE_CREATEADS);
                $model->status = Product::STATUS_BEFORE_CREATE_ADS;
                $model->priority = 0;
                $model->save();
                $model->saveProductBoatMetaData();
                $id = $model->id;
                $model = $this->findModel($id);

                $this->bodyClass = 'create-ads';

                return $this->render('boat', [
                    'model' => $model,
                ]);
            } else {
                if ($id == null) {
                    Yii::$app->user->denyAccess();
                } else {
                    $model = $this->findModel($id);
                    $model->status = Product::STATUS_TO_BE_VERIFIED;
                    $model->setScenario(Product::SCENARIO_BOAT);
                    if ($model->loadI18n($request) && $model->validateI18n()) {

                        try {

                            if ($model->save()) {
                                Yii::$app->redis->executeCommand('PUBLISH', [
                                    'channel' => 'notification',
                                    'message' => Json::encode(['message' => 'Объявление'])
                                ]);
                            }

                            $this->bodyClass = 'create-ads';

                            return $this->render('afterSave', [
                                'model' => $model,
                            ]);
                        } catch (IntegrityException $e) {
                            if (Yii::$app->user->isGuest) {
                                throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                            } else {
                                throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                            транспортного средства.", 405);
                            }
                        } catch (\Exception $e) {
                            if (Yii::$app->user->isGuest) {
                                throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                            } else {
                                throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                            транспортного средства.", 405);
                            }
                        }

                    } else {
                        var_dump($model->getErrors());
                    }

                }
            }
        }
    }

    public function actionStep1($id)
    {
        if (Yii::$app->request->isAjax) {

            if ($id == null) {
                Yii::$app->user->denyAccess();
            }

            $request = Yii::$app->request->post();

            if (empty($request)) {
                throw new NotFoundHttpException('Извините, не переданы данные.');
            } else {
                $model = $this->findModel($id);
                $model->priority = 0;
                $model->setScenario(Product::SCENARIO_STEP_1);
                $this->fillSpecifications($model);
                if ($model->loadI18n($request) && $model->validateI18n()) {
                    $model->status = Product::STATUS_BEFORE_CREATE_ADS;
                    if ($request["Product"]['currency'] == 1) {
                        $model->price = $model->exchangeBynToUsd($request["Product"]['price']);
                        $model->priceByn = $request["Product"]['price'];
                    }
                    try {
                        $model->save();
                        $this->saveSpecifications($model);
                        $model->saveProductMetaData();

                        $this->bodyClass = 'create-ads';

                        return $this->renderPartial('_step_1', [
                            'model' => $model,
                        ]);
                    } catch (IntegrityException $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                            транспортного средства.", 405);
                        }
                    } catch (\Exception $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа
                             транспортного средства.", 405);
                        }
                    }

                }
            }
        }
    }

    public function actionStep2($id)
    {
        if (Yii::$app->request->isAjax) {

            if ($id == null) {
                Yii::$app->user->denyAccess();
            }

            $request = Yii::$app->request->post();

            if (empty($request)) {
                throw new NotFoundHttpException('Извините, не переданы данные.');
            } else {
                $model = $this->findModel($id);
                $model->setScenario(Product::SCENARIO_STEP_2);
                $this->saveUploads($model);

                if ($model->loadI18n($request) && $model->validateI18n()) {
                    try {
                        $model->save();

                        $this->bodyClass = 'create-ads';

                        return $this->renderPartial('_step_2', [
                            'model' => $model,
                        ]);
                    } catch (IntegrityException $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа транспортного средства.", 405);
                        }
                    } catch (\Exception $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа транспортного средства.", 405);
                        }
                    }

                }
            }
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
        $model->setScenario(Product::SCENARIO_CREATEADS);
        $model->setScenario(Product::SCENARIO_DEFAULT);
        $model->loadI18n(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;

        $productSpecificationModels = $this->fillSpecifications($model);

        $result = ActiveForm::validateMultiple([$model]);
        $result += ActiveForm::validateMultiple($model->getI18nModels());
        $result += ActiveForm::validateMultiple($productSpecificationModels);

        return $result;
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
        $model->loadDefaultValues();
        $productSpecificationModels = $this->fillSpecifications($model);

        /*
         * SCENARIO UPDATE ADS
         */
        $model->setScenario(Product::SCENARIO_BEFORE_CREATEADS);
        $this->bodyClass = 'create-ads';

        return $this->render('update-ads', [
            'model' => $model,
            'form' => $form,
            'productSpecifications' => $productSpecificationModels,
        ]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSave($id)
    {
        $request = Yii::$app->request->post();
        if (empty($request)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            if ($id == null) {
                Yii::$app->user->denyAccess();
            } else {
                $model = $this->findModel($id);
                $model->status = Product::STATUS_TO_BE_VERIFIED;
                if ($model->loadI18n($request) && $model->validateI18n()) {

                    try {

                        if ($model->save()) {
                            Yii::$app->redis->executeCommand('PUBLISH', [
                                'channel' => 'notification',
                                'message' => Json::encode(['message' => 'Объявление'])
                            ]);
                        }

                        $this->bodyClass = 'create-ads';

                        return $this->render('afterSave', [
                            'model' => $model,
                        ]);
                    } catch (IntegrityException $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                            транспортного средства.", 405);
                        }
                    } catch (\Exception $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                            транспортного средства.", 405);
                        }
                    }

                } else {
                    var_dump($model->getErrors());
                }

            }
        }
    }

    public function actionUpdateSave($id)
    {
        $request = Yii::$app->request->post();
        if (empty($request)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            if ($id == null) {
                Yii::$app->user->denyAccess();
            } else {
                $model = $this->findModel($id);
                $model->status = Product::STATUS_TO_BE_VERIFIED;
                $this->fillSpecifications($model);
                $this->saveUploads($model);

                if ($model->loadI18n($request) && $model->validateI18n()) {
                    if ($request["Product"]['currency'] == 1) {
                        $model->price = $model->exchangeBynToUsd($request["Product"]['price']);
                        $model->priceByn = $request["Product"]['price'];
                    }
                    try {
                        $model->save();
                        $this->saveSpecifications($model);
                        $model->updateProductMetaData();

                        $this->bodyClass = 'create-ads';

                        return $this->render('afterSave', [
                            'model' => $model,
                        ]);
                    } catch (IntegrityException $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                            транспортного средства.", 405);
                        }
                    } catch (\Exception $e) {
                        if (Yii::$app->user->isGuest) {
                            throw new \yii\web\HttpException(500, "Извините, чтобы разместить объявление 
                            Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте", 405);
                        } else {
                            throw new \yii\web\HttpException(500, "Произошла ошибка при выборе типа 
                            транспортного средства.", 405);
                        }
                    }

                } else {
                    var_dump($model->getErrors());
                }

            }
        }
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

    /*
     * Check  files
     * @param array url files  $_POST
     * @return bool
     *
     */
 public function actionCheckfiles(){
     if (Yii::$app->request->isAjax) {

     }
     else {
         Yii::$app->user->denyAccess();
     }
 }
}