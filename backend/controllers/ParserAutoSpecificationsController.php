<?php

namespace backend\controllers;

use common\models\AutoRegions;
use common\models\Product;
use Yii;
use yii\web\Controller;
use common\models\ProductMake;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use common\models\ProductType;
use common\models\AutoMakes;
use  common\models\AutoModels;
use common\models\AutoModifications;
use common\models\AutoModification;
use common\models\ImageModifications;
use dastanaron\translit\Translit;
use common\models\AutoSpecifications;
use common\models\AutoSpecification;
use common\models\Uploads;

class ParserAutoSpecificationsController extends Controller
{
    private $url;
    private $region;
    private $modificationId;
    private $makeId;
    private $modelId;
    private $makeName;
    private $modelName;
    private $fileName;

    public function actionWq(){
     $models = Product::find()->where(['status'=>Product::STATUS_UNPUBLISHED])->all();
     foreach($models as $model){
        $uploads = Uploads::find()->where(['linked_id'=>$model->id])->all();

        foreach ($uploads as $upload){
            //echo $upload->server.' '.$upload->hash.'<br>';
            if ($upload->server != 'static.automechta.by') {
             //  $data = Yii::$app->uploads->getUploadsData($upload->linked_table,$upload->linked_id);
               // unlink($data['path']);
                //unlink(Yii::$app->uploads->getFullPathByHash($upload->hash));
                var_dump(unlink(Yii::$app->uploads->getThumbnailTest($upload->hash,null,1920,800)));
                var_dump(unlink(Yii::$app->uploads->getThumbnailTest($upload->hash,null,800,460)));
            }

        }
     }

    }
    /*
     * Specifications
     */
    private function actionCa()
    {
        $specificationsModel = AutoSpecification::find()->all();
        $modificationsModel = AutoModification::find()->where(['between', 'id', 63001, 67000])->all();

        foreach ($modificationsModel as $model) {
            $document = \phpQuery::newDocumentHTML($model->specification);
            foreach ($specificationsModel as $spec) {
                $specifications = $document->find('div:contains("' . $spec->key . '")');
                $pq = pq($specifications);
                $specValue = $pq->eq(1)->text();
                if (!empty($specValue)) {
                    $value = (str_replace($spec->key, '', $specValue));
                    $specificationModel = new AutoSpecifications();
                    $specificationModel->modification_id = $model->id;
                    $specificationModel->specification_id = $spec->id;
                    $specificationModel->value = $value;
                    $specificationModel->save();
                    unset($specificationModel);
                }
                unset($specifications);
            }
        }
    }

    private function actionCb()
    {
        //34000
        $specificationsModel = AutoSpecification::find()->all();
        $modificationsModel = AutoModification::find()->where(['between', 'id', 67001, 73000])->all();

        foreach ($modificationsModel as $model) {
            $document = \phpQuery::newDocumentHTML($model->specification);
            foreach ($specificationsModel as $spec) {
                $specifications = $document->find('div:contains("' . $spec->key . '")');
                $pq = pq($specifications);
                $specValue = $pq->eq(1)->text();
                if (!empty($specValue)) {
                    $value = (str_replace($spec->key, '', $specValue));
                    $specificationModel = new AutoSpecifications();
                    $specificationModel->modification_id = $model->id;
                    $specificationModel->specification_id = $spec->id;
                    $specificationModel->value = $value;
                    $specificationModel->save();
                    unset($specificationModel);
                }
                unset($specifications);
            }
        }
    }

    private function actionCc()
    {
        //34000
        $specificationsModel = AutoSpecification::find()->all();
        $modificationsModel = AutoModification::find()->where(['between', 'id', 73001, 77000])->all();

        foreach ($modificationsModel as $model) {
            $document = \phpQuery::newDocumentHTML($model->specification);
            foreach ($specificationsModel as $spec) {
                $specifications = $document->find('div:contains("' . $spec->key . '")');
                $pq = pq($specifications);
                $specValue = $pq->eq(1)->text();
                if (!empty($specValue)) {
                    $value = (str_replace($spec->key, '', $specValue));
                    $specificationModel = new AutoSpecifications();
                    $specificationModel->modification_id = $model->id;
                    $specificationModel->specification_id = $spec->id;
                    $specificationModel->value = $value;
                    $specificationModel->save();
                    unset($specificationModel);
                }
                unset($specifications);
            }
        }
    }

    private function actionCd()
    {
        $specificationsModel = AutoSpecification::find()->all();
        $modificationsModel = AutoModification::find()->where(['between', 'id', 77001, 82000])->all();

        foreach ($modificationsModel as $model) {
            $document = \phpQuery::newDocumentHTML($model->specification);
            foreach ($specificationsModel as $spec) {
                $specifications = $document->find('div:contains("' . $spec->key . '")');
                $pq = pq($specifications);
                $specValue = $pq->eq(1)->text();
                if (!empty($specValue)) {
                    $value = (str_replace($spec->key, '', $specValue));
                    $specificationModel = new AutoSpecifications();
                    $specificationModel->modification_id = $model->id;
                    $specificationModel->specification_id = $spec->id;
                    $specificationModel->value = $value;
                    $specificationModel->save();
                    unset($specificationModel);
                }
                unset($specifications);
            }
        }
    }

    private function actionCe()
    {
        $specificationsModel = AutoSpecification::find()->all();
        $modificationsModel = AutoModification::find()->where(['between', 'id', 82001, 87000])->all();

        foreach ($modificationsModel as $model) {
            $document = \phpQuery::newDocumentHTML($model->specification);
            foreach ($specificationsModel as $spec) {
                $specifications = $document->find('div:contains("' . $spec->key . '")');
                $pq = pq($specifications);
                $specValue = $pq->eq(1)->text();
                if (!empty($specValue)) {
                    $value = (str_replace($spec->key, '', $specValue));
                    $specificationModel = new AutoSpecifications();
                    $specificationModel->modification_id = $model->id;
                    $specificationModel->specification_id = $spec->id;
                    $specificationModel->value = $value;
                    $specificationModel->save();
                    unset($specificationModel);
                }
                unset($specifications);
            }
        }
    }

    private function actionCf()
    {
        $specificationsModel = AutoSpecification::find()->all();
        $modificationsModel = AutoModification::find()->where(['between', 'id', 87001, 92000])->all();

        foreach ($modificationsModel as $model) {
            $document = \phpQuery::newDocumentHTML($model->specification);
            foreach ($specificationsModel as $spec) {
                $specifications = $document->find('div:contains("' . $spec->key . '")');
                $pq = pq($specifications);
                $specValue = $pq->eq(1)->text();
                if (!empty($specValue)) {
                    $value = (str_replace($spec->key, '', $specValue));
                    $specificationModel = new AutoSpecifications();
                    $specificationModel->modification_id = $model->id;
                    $specificationModel->specification_id = $spec->id;
                    $specificationModel->value = $value;
                    $specificationModel->save();
                    unset($specificationModel);
                }
                unset($specifications);
            }
        }
    }

    /*
     * End Specifications
     */


    private function actionGt()
    {

        $models = AutoMakes::find()->where(['region_id' => 4])->all();

        foreach ($models as $model) {

            $modifications = AutoModels::find()->where(['make_id' => $model->id])->all();

            foreach ($modifications as $modification) {
                $modification = AutoModifications::find()->where(['model_id' => $modification->id])->all();

                foreach ($modification as $data) {
                    $dat = AutoModifications::find()->where(['id' => $data->id])->one();
                    $dat->region_id = 4;
                    $dat->make_id = $model->id;
                    $dat->save();
                    unset($dat);
                }
            }

        }

    }

    private function actionQt()
    {
        $models = ImageModifications::find()->where(['img_url' => null])->all();
        foreach ($models as $model) {

            // $this->makeId = $model->id;
            $this->fileName = substr(strrchr($model->url, "/"), 1);
            $dir = '/home/admin/web/automechta.by/public_html/frontend/web/uploads/modificationImg/' . $model->modifications_id . '/';

            if (!file_exists($dir) || !is_dir(dirname($dir))) {
                var_dump(mkdir($dir, 0777, true));

            }


            $path = $dir . $this->fileName;
            $client = new \GuzzleHttp\Client();
            $client->get(
                $model->url,
                [
                    'save_to' => $path,
                ]);

            $images = ImageModifications::find()->where(['id' => $model->id])->one();
            $images->img_url = '/uploads/modificationImg/' . $model->modifications_id . '/' . $this->fileName;
            $images->save();

            unset($model);
            unset($images);

        }


    }

//    private function actionQt()
//    {
//        $models = AutoModels::find()->where(['tmp' => null])->all();
//        foreach ($models as $model) {
//            $this->fileName = substr(strrchr($model->img_url, "/"), 1);
//            $dir = '/home/admin/web/automechta.by/public_html/frontend/web/uploads/modelAutoImg/' . $model->make_id . '/';
//
//            if (!file_exists($dir) || !is_dir(dirname($dir))) {
//                var_dump(mkdir($dir, 0777, true));
//
//            }
//
//
//            $path = $dir . $this->fileName;
//            $client = new \GuzzleHttp\Client();
//            $client->get(
//                $model->img_url,
//                [
//                    'save_to' => $path,
//                ]);
//
//            $images = AutoModels::find()->where(['id' => $model->id])->one();
//            $images->tmp = '/uploads/modelAutoImg/' . $model->make_id . '/' . $this->fileName;
//            $images->save();
//
//            unset($model);
//            unset($images);
//
//        }
//
//
//    }

    private function actionEuro()
    {
        $translit = new Translit();
        $this->region = 1;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(1, 2);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();
                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }

    private function actionDouche()
    {
        $translit = new Translit();
        $this->region = 1;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(2, 3);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();

                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }

    private function actionJapanes()
    {
        $translit = new Translit();
        $this->region = 1;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(3, 4);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();

                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }

    private function actionKorea()
    {
        $translit = new Translit();
        $this->region = 1;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(5, 6);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();

                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }

    private function actionUsa()
    {
        $translit = new Translit();
        $this->region = 1;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(4, 5);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();

                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }

    private function actionRusian()
    {
        $translit = new Translit();
        $this->region = 2;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(6, 7);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();

                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }

    public function actionChina()
    {
        $translit = new Translit();
        $this->region = 2;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(7, 8);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();

                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }

    public function actionOthers()
    {
        $translit = new Translit();
        $this->region = 8;
        $client = new Client();
        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $marks = $document->find("ul.cars-marks-list")->slice(8, 9);

        foreach ($marks as $item) {

            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
                $url = $pq->find('a')->attr('href');
                $mark = $pq->find('a')->text();

                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
                $this->makeId = $markName->id;

                $this->getModels($url);
            }
        }
    }


    private function getModels($url)
    {
        sleep(1);
        $client = new Client();
        $translit = new Translit();
        $res = $client->request('GET', 'https://www.lastochka.by' . $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $specifications = $document->find("ul.cars-models-list");
        foreach ($specifications as $item) {
            $pq = pq($item);
            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
//                $image = $pq->attr('style');
//                $varTemp = str_replace('background-image:url(', '', $image);
//                $imageModel = str_replace(')', '', $varTemp);
                $url = $pq->find('a')->attr('href');
                $modelAuto = $pq->find('a')->text();
                $modelId = AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $modelAuto])->one();
                $this->modelId = $modelId->id;
//                if (
//AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $modelAuto])->andWhere(['img_url' => null])->exists()) {
//                    $model = AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $modelAuto])->andWhere(['img_url' => null])->one();
//                    $model->img_url = 'https://www.lastochka.by' . $imageModel;
//                    $model->save();
//                    unset($model);
//                }


                //$years = $pq->find('.cars-models-years')->text();

                // $modelName = AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $model])->one();
                // $this->modelId = $modelName->id;

                $this->_imageparser($url);
            }
        }
    }

    private function actionGetModifications($url)
    {
        $client = new Client();
        $translit = new Translit();
        $res = $client->request('GET', 'https://www.lastochka.by' . $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $specifications = $document->find("#cars");
        foreach ($specifications as $item) {
            $pq = pq($item);
            $mark = str_replace('Каталог ', '', $pq->find('h1')->text());

            $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
            $this->makeId = $markName->id;
            //$this->makeId =80;

            $li = $pq->find('li');
            foreach ($li as $item) {
                $pq = pq($item);
//                $image = $pq->attr('style');
//                $varTemp = str_replace('background-image:url(', '', $image);
//                $imageModel = str_replace(')', '', $varTemp);
                $url = $pq->find('a')->attr('href');
                $modelAuto = $pq->find('a')->text();
                $modelId = AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $modelAuto])->one();
                $this->modelId = $modelId->id;
                var_dump($this->modelId);
//                if (
//AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $modelAuto])->andWhere(['img_url' => null])->exists()) {
//                    $model = AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $modelAuto])->andWhere(['img_url' => null])->one();
//                    $model->img_url = 'https://www.lastochka.by' . $imageModel;
//                    $model->save();
//                    unset($model);
//                }


                //$years = $pq->find('.cars-models-years')->text();

                // $modelName = AutoModels::find()->where(['make_id' => $this->makeId])->andWhere(['model' => $model])->one();
                // $this->modelId = $modelName->id;

                $this->_imageparser($url);
            }
        }
    }

    private function actionFq()
    {
        $models = AutoModifications::find()->all();

        foreach ($models as $model) {
            if (!(ImageModifications::find()->where(['modifications_id' => $model->id])->exists())) {
                $models = AutoModels::find()->where(['id' => $model->model_id])->orderBy('id')->all();
                $this->modelId = $model->model_id;
                foreach ($models as $model) {
                    $makes = AutoMakes::find()->where(['id' => $model->make_id])->all();
                    foreach ($makes as $make) {
                      echo $make->name . ':'.$this->modelId .'-'. $model->model . '<br>';

                    echo $url = '/catalog/' . str_replace(' ', '-', $make->name).'/'. str_replace(' ', '_', $model->model);
                     // $this->_imageparser($url);
                    }
                }
            }
        }
    }

    private function actionImageparser($url,$id)
    {
        $this->modelId = $id;
        $client = new Client();
        $translit = new Translit();
        $res = $client->request('GET', 'https://www.lastochka.by' . $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $cars = $document->find("#cars");
        foreach ($cars as $item) {
            $pq = pq($item);
            $item = $pq->find('.cars-modifications-submodel');
            $arrayForCheck = $item->stack();
            if (count($arrayForCheck) > 0) {
                break;
            } else {
                $photos = $pq->find('a.cars-modifications-photo');

                $model = AutoModifications::find()->where(['model_id' => $this->modelId])->andWhere(['modification_name' => null])
                    ->andWhere(['years' => null])->one();
                var_dump($model->id);
                if ($model->id != null) {
                    if (ImageModifications::find()->where(['modifications_id' => $model->id])->exists()) {
                        break;
                    } else {
                        foreach ($photos as $photo) {
                            $pq = pq($photo);
                            $imageUrl = $pq->find('img')->attr('src');
                            $imageModel = new ImageModifications();
                            $imageModel->modifications_id = $model->id;
                            $imageModel->url = 'https://www.lastochka.by' . $imageUrl;
                            $imageModel->save();
                            unset($imageModel);
                        }
                    }
                }
            }
        }
    }

    private function actionBbb()
    {
        $models = AutoModels::find()->all();
$i = 0;
        foreach ($models as $model) {

            if (!(AutoModifications::find()->where(['model_id' => $model->id])->exists())) {
                $i++;
                echo $i;
//                $this->modelId = $model->id;
//                $this->makeId = $model->make_id;
//
//                $make = AutoMakes::findOne($model->make_id);
//                $makeName = $make->name;
//                $this->region =$make->region_id;
//                $modelName = $model->model;
//
//                $url = '/catalog/' . str_replace(' ', '-', $makeName) . '/2cv';// . str_replace(' ', '_', $modelName);
//
//                $this->getModifications($url);
            }
        }
    }
//            if (!(ImageModifications::find()->where(['modifications_id' => $model->id])->exists())) {
//                $models = AutoModels::find()->where(['id' => $model->model_id])->all();
//                foreach ($models as $model) {
//                    $makes = AutoMakes::find()->where(['id' => $model->make_id])->all();
//                    foreach ($makes as $make) {
//                        echo $make->name . ':' . $model->model . '<br>';
//                    }
//                }
//            }
    // }
    //}
//}

//
//
//                $photos = $pq->find('a.cars-modifications-photo');
//
//                $model = AutoModifications::find()->where(['model_id' => $this->modelId])->andWhere(['modification_name' => null])
//                    ->andWhere(['years' => null])->one();
//                var_dump($this->modelId);
//
//                if (ImageModifications::find()->where(['modifications_id'=>$model->id])->exists()) {
//                    break;
//                }
//                else {
//                foreach ($photos as $photo) {
//                    $pq = pq($photo);
//                    $imageUrl = $pq->find('img')->attr('src');
//                        $imageModel = new ImageModifications();
//                        $imageModel->modifications_id = $model->id;
//                        $imageModel->url = 'https://www.lastochka.by' . $imageUrl;
//                        $imageModel->save();
//                        unset($imageModel);
//                    }
//
//                }
////
////
//            }
//}

//            if ($li){
//                break;
//            }
//            else {
//                foreach ($li as $item) {
//                    $pq = pq($item);
//
//                   // $modificationName = $pq->find('.cars-modifications-submodel-title')->text();
//                   // $modificationYears = $pq->find('.cars-modifications-submodel-years')->text();
//
//                    $photos = $pq->find('a.cars-modifications-photo');
//
//                    foreach ($photos as $photo) {
//                        $pq = pq($photo);
//                        $imageUrl = $pq->find('img')->attr('src');
//
//                        $model = AutoModifications::find()->where(['model_id' => $this->modelId])->andWhere(['modification_name'=>null])
//                            ->andWhere(['years' => null])->one();
//
//                        var_dump($imageUrl);
////                        $imageModel = new ImageModifications();
////                        $imageModel->modifications_id = $model->id;
////                        $imageModel->url = 'https://www.lastochka.by' . $imageUrl;
////                        $imageModel->save();
////                        unset($imageModel);
//
//                    }
////
////
//                }
//            }

//public function AA(){
//    $specifications = $document->find(".cars-modifications-submodel");
//    foreach ($specifications as $item) {
//        $pq = pq($item);
//
//        $modificationName = $pq->find('.cars-modifications-submodel-title')->text();
//        $modificationYears = $pq->find('.cars-modifications-submodel-years')->text();
//
//        $photos = $pq->find('a.cars-modifications-photo');
//
//        $model = AutoModifications::find()->where(['model_id' => $this->modelId])->andWhere(['modification_name' => $modificationName])
//            ->andWhere(['years' => $modificationYears])->one();
//
//        var_dump($modificationName);
//        var_dump($modificationYears);
//        var_dump($model->id);
//        if ($model->id != null):
//            if (ImageModifications::find()->where(['modifications_id' => $model->id])->exists()) {
//
//            } else {
//                foreach ($photos as $photo) {
//                    $pq = pq($photo);
//                    $imageUrl = $pq->find('img')->attr('src');
//                    var_dump($model->id);
//                    var_dump($imageUrl);
//                    $imageModel = new ImageModifications();
//                    $imageModel->modifications_id = $model->id;
//                    $imageModel->url = 'https://www.lastochka.by' . $imageUrl;
//                    $imageModel->save();
//                    var_dump($imageModel->getErrors());
//                    unset($imageModel);
//                }
//
//            }
//        endif;
//    }
//
//
//    /////*
//    /// //
//
//    private function actionZt()
//    {
//        $models = AutoMakes::find()->all();
//
//        foreach ($models as $model) {
//            $makes = AutoModels::find()->where(["img_url" => null])->all();
//
//            foreach ($makes as $make) {
//
//                if ($make->img_url == null) {
//                    $this->makeName = str_replace(' ', '', $model->name);
//                    $this->modelName = str_replace(' ', '', $make->model);
//                    $this->modelId = $make->id;
//
//                    // echo $this->makeName.'/'.$this->modelName;
//                    $this->_photo();
//                }
//            }
//        }
//
//    }
//
//    //}
//
//    private function _photo()
//    {
//        $translit = new Translit();
//        $client = new Client();
//
//        try {
//            $res = $client->request('GET', 'https://www.lastochka.by/catalog/' . $this->makeName . '/' . $this->modelName . '/', [
//                'headers' => [
//                    'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
//                ]]);
//        } catch (ClientException $exception) {
//            return false;
//        }
//        $body = $res->getBody();
//        $document = \phpQuery::newDocumentHTML($body);
//        $img = $document->find(".cars-modifications-photos")->slice(0, 1);
//
//        foreach ($img as $item) {
//
//            $pq = pq($item);
//
////            $link = $pq->find('a.au-preview-list__link')->attr('href');
////
////            try {
////                $res = $client->request('GET', $link, [
////                    'headers' => [
////                        'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
////                    ]]);
////
////            } catch (ClientException $exception) {
////                return false;
////            }
////
////            $body = $res->getBody();
////            $document = \phpQuery::newDocumentHTML($body);
////            $img = $document->find(".au-rama-big__link")->slice(0, 1);
////            foreach ($img as $item) {
////
////                $pq = pq($item);
//
//            $imgSrc = $pq->find('a.cars-modifications-photo')->attr('href');
////var_dump($imgSrc);
//            $model = AutoModels::findOne($this->modelId);
//            $model->img_url = 'https://www.lastochka.by' . $imgSrc;
//            $model->save();
//            unset($model);
//
//        }
//    }
//
//
//    public function beforeAction($action)
//    {
//        ini_set('max_execution_time', 5341500);
//        ini_set('memory_limit', "600M");
//
//        return parent::beforeAction($action);
//    }
//
    private function getModifications($url)
    {
        $client = new Client();

        $res = $client->request('GET', 'https://www.lastochka.by' . $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ]]);

        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $specifications = $document->find("#cars-modifications");
        foreach ($specifications as $item) {
            $pq = pq($item);
            $item = $pq->find('.cars-modifications-submodel');
            $arrayForCheck = $item->stack();
            if (count($arrayForCheck) > 0) {
                break;
            } else {

                /*
                 * Modifications
                 */


                $model = new AutoModifications();
                $model->model_id = $this->modelId;
                $model->make_id = $this->makeId;
                $model->region_id =   $this->region;
            $model->save();
              //  var_dump($model->getErrors());
                $this->modificationId = $model->id;
                var_dump( $this->modificationId);
                unset($model);

                /*
                 * Modification
                 */
                $translit = new Translit();

                $specifications = $pq->find('.cars-modifications-wrap');
                foreach ($specifications as $item) {

                    $pq = pq($item);

                    $modification_name = $pq->find('.cars-modifications-row')->find('div > a')->text();
                    $url = $pq->find('.cars-modifications-row')->find('div > a')->attr('href');

                    $years = $pq->find('.cars-modifications-row div:eq')->next()->text();
                    $engine = $pq->find('.cars-modifications-row div:eq')->next()->next()->text();
                    $drive_unit = $pq->find('.cars-modifications-row div:eq')->next()->next()->next()->text();
                    $year = explode("—", $years);
                    $yearFrom=$year[0];
                        $yearTo =$year[1];
                    $model = new AutoModification();
                    $model->modification_id = $this->modificationId;
                    $model->modification_name = $modification_name;
                    $model->slug = $translit->translit($modification_name, true, 'ru-en');
                    $model->years = $years;
                    $model->yearFrom = $yearFrom;
                    $model->yearTo = $yearTo;
                    $model->engine = $engine;
                    $model->drive_unit = $drive_unit;
                    $model->url = $url;
                    $model->save();

                    unset($model);
                }
            }

            gc_collect_cycles();
        }
    }
    private function actionParser()
    {
        $models = AutoModification::find()->select('id,url,specification')->where(['specification' => ''])->all();

        foreach ($models as $model) {
            $client = new Client();
            $res = $client->request('GET', 'https://www.lastochka.by' . $model->url, [
                'headers' => [
                    'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
                ]]);
            $body = $res->getBody();
            $document = \phpQuery::newDocumentHTML($body);
            $specifications = $document->find("#cars");
            foreach ($specifications as $item) {
                $pq = pq($item);
                $specification = $pq->find('.cars-params-group')->html();

                $spec = AutoModification::find()->where(['id' => $model->id])->one();
                $spec->specification = $specification;
                var_dump($spec->save());
                var_dump($model->id);
                var_dump($specification);
            }
        }
    }
}
//
//    private function actionDouchen()
//    {
//        $translit = new Translit();
//        $this->region = 2;
//        $client = new Client();
//        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
//            'headers' => [
//                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
//            ]]);
//        $body = $res->getBody();
//        $document = \phpQuery::newDocumentHTML($body);
//        $marks = $document->find("ul.cars-marks-list")->slice(2, 3);
//
//        foreach ($marks as $item) {
//
//            $pq = pq($item);
//            $li = $pq->find('li');
//            foreach ($li as $item) {
//                $pq = pq($item);
//                $url = $pq->find('a')->attr('href');
//                $mark = $pq->find('a')->text();
//
//                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
//                $this->makeId = $markName->id;
//
//                $this->getModels($url);
//            }
//        }
//    }
//
//    private function actionJapanesn()
//    {
//        $translit = new Translit();
//        $this->region = 3;
//        $client = new Client();
//        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
//            'headers' => [
//                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
//            ]]);
//        $body = $res->getBody();
//        $document = \phpQuery::newDocumentHTML($body);
//        $marks = $document->find("ul.cars-marks-list")->slice(3, 4);
//
//        foreach ($marks as $item) {
//
//            $pq = pq($item);
//            $li = $pq->find('li');
//            foreach ($li as $item) {
//                $pq = pq($item);
//                $url = $pq->find('a')->attr('href');
//                $mark = $pq->find('a')->text();
//
//                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
//                $this->makeId = $markName->id;
//
//                $this->getModels($url);
//            }
//        }
//    }
//
//    private function actionKorean()
//    {
//        $translit = new Translit();
//        $this->region = 1;
//        $client = new Client();
//        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
//            'headers' => [
//                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
//            ]]);
//        $body = $res->getBody();
//        $document = \phpQuery::newDocumentHTML($body);
//        $marks = $document->find("ul.cars-marks-list")->slice(5, 6);
//
//        foreach ($marks as $item) {
//
//            $pq = pq($item);
//            $li = $pq->find('li');
//            foreach ($li as $item) {
//                $pq = pq($item);
//                $url = $pq->find('a')->attr('href');
//                $mark = $pq->find('a')->text();
//
//                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
//                $this->makeId = $markName->id;
//
//                $this->getModels($url);
//            }
//        }
//    }
//
//    private function actionEuron()
//    {
//        $translit = new Translit();
//        $this->region = 5;
//        $client = new Client();
//        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
//            'headers' => [
//                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
//            ]]);
//        $body = $res->getBody();
//        $document = \phpQuery::newDocumentHTML($body);
//        $marks = $document->find("ul.cars-marks-list")->slice(1, 2);
//
//        foreach ($marks as $item) {
//
//            $pq = pq($item);
//            $li = $pq->find('li');
//            foreach ($li as $item) {
//                $pq = pq($item);
//                $url = $pq->find('a')->attr('href');
//                $mark = $pq->find('a')->text();
//
//                $markName = AutoMakes::find()->select('id,name')->where(['name' => $mark])->one();
//                $this->makeId = $markName->id;
//
//                $this->getModels($url);
//            }
//        }
//    }
//
//
//    private function parserModifications($years, $modification_name)
//    {
//
//        $translit = new Translit();
//        $model = new AutoModifications();
//        $model->years = $years;
//        $model->modification_name = $modification_name;
//        $model->model_id = $this->modelId;
//        $model->slug = $translit->translit($modification_name, true, 'ru-en');
//        $model->save();
//        $id = $model->id;
//        unset($model);
//
//        return $id;
//    }
//
//    private function parserModification($specifications)
//    {
//        $translit = new Translit();
//        foreach ($specifications as $item) {
//
//            $pq = pq($item);
//
//            $modification_name = $pq->find('.cars-modifications-row')->find('div > a')->text();
//            $url = $pq->find('.cars-modifications-row')->find('div > a')->attr('href');
//
//            $years = $pq->find('.cars-modifications-row div:eq')->next()->text();
//            $engine = $pq->find('.cars-modifications-row div:eq')->next()->next()->text();
//            $drive_unit = $pq->find('.cars-modifications-row div:eq')->next()->next()->next()->text();
//
//            $model = new AutoModification();
//            $model->modification_id = $this->modificationId;
//            $model->modification_name = $modification_name;
//            $model->slug = $translit->translit($modification_name, true, 'ru-en');
//            $model->years = $years;
//            $model->engine = $engine;
//            $model->drive_unit = $drive_unit;
//            $model->url = $url;
//            $model->save();
//            //$id = $model->id;
//            unset($model);
//            //  $this->parserSpecification($id,$url);
//
//        }
//    }
//

//
////    private function actionOthers()
////    {
////        $client = new Client();
////        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
////            'headers' => [
////                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
////            ]]);
////        $body = $res->getBody();
////        $document = \phpQuery::newDocumentHTML($body);
////        $marks = $document->find("ul.cars-marks-list")->slice(8, 9);
////
////        foreach ($marks as $item) {
////
////            $pq = pq($item);
////            $li = $pq->find('li');
////            foreach ($li as $item) {
////                $pq = pq($item);
////                $mark = $pq->find('a')->text();
////
////                $specificationModel = new AutoMakes();
////                $specificationModel->make_name = $mark;
////                $specificationModel->region_id = 8;
////                $specificationModel->save();
////                unset($specification);
////            }
////        }
////    }
////
////    private function actionDouche()
////    {
////        $this->region = 2;
////        $client = new Client();
////        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
////            'headers' => [
////                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
////            ]]);
////        $body = $res->getBody();
////        $document = \phpQuery::newDocumentHTML($body);
////        $marks = $document->find("ul.cars-marks-list")->slice(2, 3);
////
////        foreach ($marks as $item) {
////
////            $pq = pq($item);
////            $li = $pq->find('li')->slice(12);
////            foreach ($li as $item) {
////                $pq = pq($item);
////                $url = $pq->find('a')->attr('href');
////                $mark = $pq->find('a')->text();
////                $this->getModels($url, $mark);
////            }
////        }
////    }
////
////    private function actionJapanes()
////    {
////        $this->region = 3;
////        $client = new Client();
////        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
////            'headers' => [
////                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
////            ]]);
////        $body = $res->getBody();
////        $document = \phpQuery::newDocumentHTML($body);
////        $marks = $document->find("ul.cars-marks-list")->slice(3, 4);
////
////        foreach ($marks as $item) {
////
////            $pq = pq($item);
////            $li = $pq->find('li')->slice(14);
////            foreach ($li as $item) {
////                $pq = pq($item);
////                $url = $pq->find('a')->attr('href');
////                $mark = $pq->find('a')->text();
////                $this->getModels($url, $mark);
////            }
////        }
////    }
////
////    private function actionUsa()
////    {
////        sleep(2);
////        $this->region = 4;
////        $client = new Client();
////        $res = $client->request('GET', 'https://www.lastochka.by/catalog', [
////            'headers' => [
////                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
////            ]]);
////        $body = $res->getBody();
////        $document = \phpQuery::newDocumentHTML($body);
////        $marks = $document->find("ul.cars-marks-list")->slice(4, 5);
////
////        foreach ($marks as $item) {
////
////            $pq = pq($item);
////            $li = $pq->find('li');
////            foreach ($li as $item) {
////                $pq = pq($item);
////                $url = $pq->find('a')->attr('href');
////                $mark = $pq->find('a')->text();
////                $this->getModels($url, $mark);
////            }
////        }
////    }
//
//
//    private function getSpecification($url)
//    {
//        sleep(1);
//        $client = new Client();
//        $res = $client->request('GET', 'https://www.lastochka.by' . $url, [
//            'headers' => [
//                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
//            ]]);
//        $body = $res->getBody();
//        $document = \phpQuery::newDocumentHTML($body);
//        $specifications = $document->find(".cars-modifications-submodel");
//        foreach ($specifications as $item) {
//            $pq = pq($item);
//            $modifications_name = $pq->find('.cars-modifications-submodel-title')->text();
//            $modifications_years = $pq->find('.cars-modifications-submodel-years')->text();
//            $this->modificationId = $this->parserModifications($modifications_years, $modifications_name);
//
//            $specifications = $document->find(".cars-modifications-wrap");
//            $this->parserModification($specifications);
//
//            gc_collect_cycles();
//        }
//    }
//
//
//}

