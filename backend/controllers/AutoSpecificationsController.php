<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\ProductMake;
use common\models\ProductType;
use common\models\AutoSpecifications;
use common\models\AutoMakes;
use yii\data\ActiveDataProvider;

class AutoSpecificationsController extends Controller
{
    public function actionIndex()
    {
        //$searchModel = new VideoAutoSearch();
       // $params = Yii::$app->request->get();
       // $searchModel->load($params);

        /** @var ActiveDataProvider $dataProvider */
        //$dataProvider = $searchModel->search();

//        if (!isset($params['sort'])) {
//            $dataProvider->query->orderBy('product_type ASC');
//        }
//
//        $data = Yii::$app->request->get();
//        $typesList = ProductType::getTypesAsArray();
//
//        if (!isset($data["VideoAutoSearch"]["product_type"])) {
//            $makesList = ProductMake::getMakesList();
//        } else {
//            $makesList = ProductMake::getMakesList($data["VideoAutoSearch"]["product_type"]);
//        }

//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//           // 'makesList' => $makesList,
//            //'typesList' => $typesList,
//            //'searchModel' => $searchModel,
//        ]);

        $query = AutoSpecifications::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id){
        $model = AutoSpecifications::findOne($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}