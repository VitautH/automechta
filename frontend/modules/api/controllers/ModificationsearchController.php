<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\db\Query;
use common\models\AutoModifications;
use common\models\AutoModels;
use common\models\AutoMakes;
use common\models\AutoRegions;
use common\models\AutoSearch;
use yii\web\Controller;

class ModificationsearchController  extends Controller
{


    /**
     * Get list of models by make id
     * @param $makeId
     * @return mixed
     */
    public function actionModels($makeId)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = AutoSearch::getModels($makeId);

        return $data;
    }

    public function actionSearch()
    {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->get();

            $autoSearch = new AutoSearch();
            if (!empty($params['AutoSearch']['yearFrom'])) {
                $autoSearch->yearFrom = $params['AutoSearch']['yearFrom'];
            }

            if (!empty($params['AutoSearch']['yearTo'])) {
                $autoSearch->yearTo = $params['AutoSearch']['yearTo'];
            }
            if (!empty($params['AutoSearch']['makes'])) {
                $autoSearch->make = $params['AutoSearch']['makes'];
            }
            if (!empty($params['AutoSearch']['model'])) {
                $autoSearch->model = $params['AutoSearch']['model'];
            }

            $autoSearch->load($params);
            $query = $autoSearch->search();
            $total = $query->count();

            return $total;
        }
    }
}