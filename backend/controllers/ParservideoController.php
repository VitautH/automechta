<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\ProductMake;
use GuzzleHttp\Client;
use common\models\VideoAuto;
use common\models\VideoAutoSearch;
use common\models\ProductType;
use yii\data\ActiveDataProvider;
use common\models\Product;
use common\models\ProductVideo;

class ParservideoController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new VideoAutoSearch();
        $params = Yii::$app->request->get();
        $searchModel->load($params);

        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $searchModel->search();

        if (!isset($params['sort'])) {
            $dataProvider->query->orderBy('product_type ASC');
        }

        $data = Yii::$app->request->get();
        $typesList = ProductType::getTypesAsArray();

        if (!isset($data["VideoAutoSearch"]["product_type"])) {
            $makesList = ProductMake::getMakesList();
        } else {
            $makesList = ProductMake::getMakesList($data["VideoAutoSearch"]["product_type"]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'makesList' => $makesList,
            'typesList' => $typesList,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id)
    {
        if (Yii::$app->request->isAjax) {
            if (VideoAuto::findOne($id)->delete()) {
                return $this->actionIndex();
            }
        }
    }

    public function actionClearAll()
    {
        VideoAuto::deleteAll();

        return true;
    }
}