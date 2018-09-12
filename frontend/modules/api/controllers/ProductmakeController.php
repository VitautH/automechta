<?php

namespace frontend\modules\api\controllers;

use common\models\ProductMake;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\controllers\TreeController;
use yii\db\Query;
use common\models\Product;
use frontend\models\ProductSearchForm;

class ProductmakeController extends TreeController
{
    public $modelName = 'common\models\ProductMake';

    /**
     * Get list of makers by product type
     * @param $type
     * @return mixed
     */

    public function actionMakers($type)
    {
        if (!Yii::$app->user->can('viewProductMake')) {
            Yii::$app->user->denyAccess();
        };

        Yii::$app->response->format = Response::FORMAT_JSON;



            $data = (new Query())->select('name, id')
                ->from('product_make')
                ->where('product_type=:product_type AND depth=1', [':product_type' => $type])
                ->indexBy('id')->column();

            return $data;
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
            $result = ProductMake::getModelsList($model->id);
            $data = $result;

            return $data;
    }

    public function actionSearch()
    {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->get();

            $searchForm = new ProductSearchForm();
            $query = Product::find()->active();
            $searchForm->load($params);
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
            $total = $searchForm->search($query)->count();

            return $total;
        }
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