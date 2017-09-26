<?php

namespace frontend\modules\api\controllers;

use common\models\ProductMake;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\controllers\TreeController;
use yii\db\Query;

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

        $result = (new Query())->select('name, id')
            ->from('product_make')
            ->where('product_type=:product_type AND depth=1', [':product_type' => $type])
            ->indexBy('id')->column();

        return $result;
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