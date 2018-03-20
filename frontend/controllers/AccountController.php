<?php

namespace frontend\controllers;

use common\models\ProductSearch;
use common\models\User;
use common\models\Product;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\Uploads;
use yii\web\HttpException;
use frontend\models\Bookmarks;

/**
 * Account controller
 */
class AccountController extends Controller
{
    public $layout = 'index';
    public $bodyClass;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'move-node' => ['post'],
                    'delete-product' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->denyAccess('Извините, чтобы разместить объявление Вам необходимо заново войти в свой аккаунт
            или зарегистрироваться на сайте');
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $query = Product::find();
        $query->where(['created_by' => Yii::$app->user->id]);
        $query->andWhere(['!=', 'status', Product::STATUS_UNPUBLISHED]);
        $query->orderBy('product.updated_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->bodyClass = 'account-page';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSetting()
    {
        $modelPhoto = Uploads::find()->where(['linked_table' => 'user'])->andWhere(['linked_id' => Yii::$app->user->id])->one();
        if (empty($modelPhoto)) {
            $modelPhoto = new Uploads();
        }

        $model = User::findOne(Yii::$app->user->id);
        $model->setScenario('sellerContacts');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Saved'));
            return $this->refresh();
        } else {
            $this->bodyClass = 'account-setting';

            return $this->render('setting', [
                'model' => $model,
                'modelPhoto' => $modelPhoto,
            ]);
        }
    }

    public function actionBookmarks()
    {
        $query = Product::find();
        $query->rightJoin(Bookmarks::tableName(), Product::tableName() . '.id =' . Bookmarks::tableName() . '.product_id');
        $query->where([Bookmarks::tableName() . '.user_id' => Yii::$app->user->id]);
        $query->andWhere(['!=', Product::tableName() . '.status', Product::STATUS_UNPUBLISHED]);
        $query->orderBy('product.updated_at DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->bodyClass = 'account-bookmarks';

        return $this->render('bookmarks', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProductChange()
    {

        if (Yii::$app->request->isAjax) {
            $request = Yii::$app->request->post();

            function up($items)
            {
                $status = false;

                foreach ($items as $item) {
                    $model = Product::findOne($item);
                    if ($model === null) {
                        throw new NotFoundHttpException('The requested page does not exist.');
                    }

                    if (!Yii::$app->user->can('updateOwnProduct', ['model' => $model])) {
                        Yii::$app->user->denyAccess();
                    }

                    Yii::$app->response->format = Response::FORMAT_JSON;

                    $time = time() - (1 * 24 * 60 * 60);
                    if ($model->updated_at < $time) {
                        $model->updated_at = $time;

                        if ($model->priority == Product::HIGHT_PRIORITY) {
                            $model->priority = Product::HIGHT_PRIORITY;
                        }
                        if ($model->save()) {
                            $status = true;
                        }
                    }
                }
                Yii::$app->cache->deleteKey('main_page');

                return $status;
            }

            if (up($request ['ads'])) {
                Yii::$app->session->setFlash('success', "Объявления подняты!");
                return $this->redirect('/account/index', 302);
            } else {
                return ['status' => 'failed'];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @param $id
     * @throws NotFoundHttpException
     * @return array|Response
     */
    public function actionUpProduct($id)
    {
        $model = Product::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!Yii::$app->user->can('updateOwnProduct', ['model' => $model])) {
            Yii::$app->user->denyAccess();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $time = time() - (1 * 24 * 60 * 60);
        if ($model->updated_at < $time) {
            $model->updated_at = $time;

            if ($model->priority == Product::HIGHT_PRIORITY) {
                $model->priority = Product::HIGHT_PRIORITY;
            }

            if ($model->save()) {
                Yii::$app->cache->deleteKey('main_page');

                return ['status' => 'success', 'id' => $id];
            } else {
                return ['status' => 'failed', 'id' => $id];
            }

        } else {
            return ['status' => 'failed', 'id' => $id];
        }
    }

    /**
     * @param $id
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionDeleteProduct($id)
    {
        $model = Product::find()->where(['id' => $id])->one();

        if ($model->id === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!Yii::$app->user->can('deleteOwnProduct', ['model' => $model])) {
            Yii::$app->user->denyAccess();
        }

        $model->status = Product::STATUS_UNPUBLISHED;
        $model->save();
        Yii::$app->cache->deleteKey('main_page');
        Yii::$app->cache->deleteKey('product_' . $id);
        try {
            Uploads::deleteImages('product', $id);
        } catch (HttpException $e) {

        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success', 'id' => $id];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Validate user data
     * @return array
     */
    public function actionValidate()
    {
        $model = User::findOne(Yii::$app->user->id);

        if ($model === null) {
            $model = new User();
        }
        $model->setScenario('sellerContacts');
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
