<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\ActiveRecord;
use common\models\ProductVideo;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductMake;
use GuzzleHttp\Client;
use yii\db\Query;
use Imagine\Exception\InvalidArgumentException;

class ParserProductVideo extends Component
{
    const LIMIT_VIDEO = 4;
    const MOTO = 'мотоцикл';
    const ATV = 'квадроцикл';
    const SCOOTER = 'скутер';
    const CARS = '';
    private $productYear;
    private $productType;
    private $makeId;
    private $makeName;
    private $productModel;
    private $productId;
    private $searchQuery;

    public function parser($productID)
    {
        $model = Product::find()->select('type,id,make,model,year')->where(['id' => $productID])->one();
        $this->productYear = $model->year;
        $this->productId = $productID;
        $this->productModel = $model->model;
        $this->makeId = $model->make;
        $this->productType = $model->type;

        $make = ProductMake::find()->select('name')->where(['id' => $this->makeId])->one();
        $this->makeName = $make->name;

        switch ($this->productType) {
            case ProductType::CARS:
                $this->searchQuery = 'обзор %20' . static::CARS . '  %20' . $this->makeName . '%20' . $this->productModel . '%20' . $this->productYear;
                $this->_parser();
                break;
            case ProductType::MOTO:
                $this->searchQuery = 'обзор  %20 ' . static::MOTO . '  %20' . $this->makeName . '%20' . $this->productModel . '%20' . $this->productYear;
                $this->_parser();
                break;
            case ProductType::ATV:
                $this->searchQuery = 'обзор  %20 ' . static::ATV . '  %20' . $this->makeName . '%20' . $this->productModel . '%20' . $this->productYear;
                $this->_parser();
                break;
            case ProductType::SCOOTER:
                $this->searchQuery = 'обзор  %20 ' . static::SCOOTER . '  %20' . $this->makeName . '%20' . $this->productModel . '%20' . $this->productYear;
                $this->_parser();
                break;
        }
    }

    public function delete($productId)
    {
        $this->productId = $productId;
        if (ProductVideo::deleteAll(['product_id' => $this->productId])) {
            return true;
        } else {
            return false;
        }
    }

    private function _parser()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.googleapis.com/youtube/v3/search?q=' . $this->searchQuery . ' &maxResults=' . static::LIMIT_VIDEO . '&part=snippet&key=AIzaSyC88JYDgObKkSLUUOOcAGFzdJllT0zGuKs');
        $body = json_decode($res->getBody());
        foreach ($body->items as $item) {

            $model = new ProductVideo();
            $model->product_id = $this->productId;
            $model->product_type = $this->productType;
            $model->product_make = $this->makeId;
            $model->model = $this->productModel;
            $model->year = $this->productYear;
            $model->video_url = $item->id->videoId;
            $model->save();

            unset($model);
            gc_collect_cycles();
        }
    }
}