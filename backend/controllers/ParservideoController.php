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

class ParservideoController extends Controller
{
    const LIMIT_VIDEO = 4;

    public function actionIndex()
    {
        $searchModel = new VideoAutoSearch();
        $params = Yii::$app->request->get();
        $searchModel->load($params);

        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $searchModel->search();

        if (!isset($params['sort'])) {
            $dataProvider->query->orderBy('type_id ASC');
        }

        $data = Yii::$app->request->get();
        $typesList = ProductType::getTypesAsArray();

        if (!isset($data["VideoAutoSearch"]["type_id"])) {
            $makesList = ProductMake::getMakesList();
        }
        else {
            $makesList = ProductMake::getMakesList($data["VideoAutoSearch"]["type_id"]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'makesList'=>$makesList,
            'typesList'=>$typesList,
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

    public function actionParserVideoCars()
    {
        foreach (ProductMake::getMakesList(ProductType::CARS) as $key => $value) {

            foreach (ProductMake::getModelsList($key) as $name) {
                $client = new Client();
                $res = $client->request('GET', 'https://www.googleapis.com/youtube/v3/search?q=' . $value . '%20' . $name . '&maxResults=' . static::LIMIT_VIDEO . '&part=snippet&key=AIzaSyDu-h0NU02HI00oIcfQf9BQKFTuO94nAPE');
                $body = json_decode($res->getBody());
                foreach ($body->items as $item) {

                    $model = new VideoAuto();
                    $model->type_id = ProductType::CARS;
                    $model->make_id = $key;
                    $model->model = $name;
                    $model->video_url = $item->id->videoId;
                    $model->save();
                    unset($model);

                    gc_collect_cycles();
                }
                gc_collect_cycles();
            }
            gc_collect_cycles();
        }

        return true;
    }

    public function actionParserVideoMoto()
    {
        foreach (ProductMake::getMakesList(ProductType::MOTO) as $key => $value) {

            foreach (ProductMake::getModelsList($key) as $name) {
                $client = new Client();
                $res = $client->request('GET', 'https://www.googleapis.com/youtube/v3/search?q=' . $value . '%20' . $name . '&maxResults=' . static::LIMIT_VIDEO . '&part=snippet&key=AIzaSyDu-h0NU02HI00oIcfQf9BQKFTuO94nAPE');
                $body = json_decode($res->getBody());
                foreach ($body->items as $item) {

                    $model = new VideoAuto();
                    $model->type_id = ProductType::MOTO;
                    $model->make_id = $key;
                    $model->model = $name;
                    $model->video_url = $item->id->videoId;
                    $model->save();
                    unset($model);

                    gc_collect_cycles();
                }
                gc_collect_cycles();
            }
            gc_collect_cycles();
        }

        return true;
    }

    public function actionParserVideoAtv()
    {
        foreach (ProductMake::getMakesList(ProductType::ATV) as $key => $value) {

            foreach (ProductMake::getModelsList($key) as $name) {
                $client = new Client();
                $res = $client->request('GET', 'https://www.googleapis.com/youtube/v3/search?q=' . $value . '%20' . $name . '&maxResults=' . static::LIMIT_VIDEO . '&part=snippet&key=AIzaSyDu-h0NU02HI00oIcfQf9BQKFTuO94nAPE');
                $body = json_decode($res->getBody());
                foreach ($body->items as $item) {

                    $model = new VideoAuto();
                    $model->type_id = ProductType::ATV;
                    $model->make_id = $key;
                    $model->model = $name;
                    $model->video_url = $item->id->videoId;
                    $model->save();
                    unset($model);

                    gc_collect_cycles();
                }
                gc_collect_cycles();
            }
            gc_collect_cycles();
        }

        return true;
    }

    public function actionParserVideoScooter()
    {
        foreach (ProductMake::getMakesList(ProductType::SCOOTER) as $key => $value) {

            foreach (ProductMake::getModelsList($key) as $name) {
                $client = new Client();
                $res = $client->request('GET', 'https://www.googleapis.com/youtube/v3/search?q=scooter ' . $value . '%20' . $name . '&maxResults=' . static::LIMIT_VIDEO . '&part=snippet&key=AIzaSyDu-h0NU02HI00oIcfQf9BQKFTuO94nAPE');
                $body = json_decode($res->getBody());
                foreach ($body->items as $item) {

                    $model = new VideoAuto();
                    $model->type_id = ProductType::SCOOTER;
                    $model->make_id = $key;
                    $model->model = $name;
                    $model->video_url = $item->id->videoId;
                    $model->save();
                    unset($model);

                    gc_collect_cycles();
                }
                gc_collect_cycles();
            }
            gc_collect_cycles();
        }

        return true;
    }

    public function actionClearAll()
    {
        VideoAuto::deleteAll();

        return true;
    }
}