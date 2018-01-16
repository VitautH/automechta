<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 22.12.2017
 * Time: 14:17
 */

namespace common\models;

use yii\base\Event;
use common\components\Cache;
use Yii;

class ProductEvent extends Event
{
    const EVENT_UPDATE_PRODUCT = 'updateProduct';
    public $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
        Yii::$app->on(ProductEvent::EVENT_UPDATE_PRODUCT, function ($event) {
            $method = $event->name;
            $this->$method();
        });
    }

    public function updateProduct()
    {
        Yii::$app->cache->deleteKey('product_'.$this->productId);
        Yii::$app->cache->deleteKey('footer');
        Yii::$app->cache->deleteKey('main_page');
        Yii::$app->cache->deleteKey('category_comapany');
    }
}