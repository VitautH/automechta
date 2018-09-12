<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 14.12.2017
 * Time: 20:41
 */

namespace common\components;

use Codeception\Module\Yii1;
use common\models\Product;
use yii\base\Component;
use common\models\MetaData;
use common\models\AppData;
use common\models\Specification;
use common\controllers\behaviors\UploadsBehavior;
use common\models\ProductSpecification;
use common\models\User;
use common\models\ProductMake;
use frontend\models\ProductSearchForm;
use frontend\models\ContactForm;
use frontend\models\ProductForm;
use Yii;
use Redis;
use Elasticsearch\ClientBuilder;

class Indexing extends Component
{
    public function __construct(array $config = [])
    {
        ini_set('memory_limit', '1500M');
        parent::__construct($config);
    }

    public static function IndexingAllProduct()
    {
        $client = ClientBuilder::create()->build();
//        $params = array();
//        $params['body']  = array(
//            'name' => 'Misty',
//            'age' => 13,
//            'badges' => 0,
//            'pokemon' => array(
//                'psyduck' => array(
//                    'type' => 'water',
//                    'moves' => array(
//                        'Water Gun' => array(
//                            'pp' => 25,
//                            'power' => 40
//                        )
//                    )
//                )
//            )
//        );
//
//        $params['index'] = 'automechta';
//        $params['type']  = 'product';
//        $params['id'] = '1';
//
//        $result = $client->index($params);
//       unset($params);
//        $params = array();
//        $params['body']  = array(
//            'name' => 'BMW',
//            'age' => 22,
//            'badges' => 0,
//            'pokemon' => array(
//                'psyduck' => array(
//                    'type' => 'water',
//                    'moves' => array(
//                        'Water Gun' => array(
//                            'pp' => 25,
//                            'power' => 40
//                        )
//                    )
//                )
//            )
//        );
//
//        $params['index'] = 'automechta';
//        $params['type']  = 'product';
//        $params['id'] = '2';
//
//        $result = $client->index($params);
        $params = array();
        $params['index'] = 'automechta';
        $params['type'] = 'product';
        

        $result = $client->get($params);

        var_dump($result);
    }

    public static function IndexingAllProduct1()
    {
        $model = Product::find()->where(['status' => Product::STATUS_PUBLISHED])->all();
        $client = ClientBuilder::create()->build();


        foreach ($model as $item) {

//                if (Yii::$app->cache->exists('product_' . $item->id)) {
//                     Yii::$app->cache->deleteKey('product_' . $item->id);
//                } else {
            /*
                         * Product
                         */

            $product ['id'] = $item->id;
            $product ['make'] = $item->getMake0()->one()->name;
            $product ['type'] = $item->type;
            $product['makeid'] = ProductMake::find()->where(['and', ['depth' => $item->type], ['name' => $item->model], ['product_type' => $item->type]])->one()->id;
            $product ['model'] = $item->model;
            $product ['year'] = $item->year;
            $product ['views'] = $item->views;
            $product ['title'] = $item->getFullTitle();
            $product ['title_image'] = $item->getTitleImageUrl(267, 180);
            $product ['short_title'] = $item->i18n()->title;
            $product ['price_byn'] = $item->getByrPrice();
            $product ['price_usd'] = $item->getUsdPrice();
            $product ['exchange'] = $item->exchange;
            $product ['auction'] = $item->auction;
            $product ['priority'] = $item->priority;
            $product ['seller_comments'] = $item->i18n()->seller_comments;
            $product ['created_at'] = $item->created_at;
            $product ['created_by'] = $item->created_by;
            $product ['updated_at'] = $item->updated_at;
            $product ['phone'] = $item->phone;
            $product ['phone_2'] = $item->phone_2;
            $product ['phone_provider_2'] = $item->phone_provider_2;
            $product ['first_name'] = $item->first_name;
            $product ['region'] = $item->region;

            /*
             * Image
             */
            $uploads = $item->getUploads();
            $product ['image'] = [];
            foreach ($uploads as $i => $upload) {
                $product  ['image'] [$i] ['full'] = $upload->getThumbnail(800, 460);
                $product  ['image'] [$i] ['thumbnail'] = $upload->getThumbnail(115, 85);
            }

            /*
             * Specification
             */
            $productSpecifications = $item->getSpecifications();
            $productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
                $specification = $productSpec->getSpecification()->one();
                return $specification->type != Specification::TYPE_BOOLEAN;
            });
            $productSpecificationsMain = array_values($productSpecificationsMain);
            $productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
                $specification = $productSpec->getSpecification()->one();
                return $specification->type == Specification::TYPE_BOOLEAN;
            });
            $productSpecificationsAdditional = array_values($productSpecificationsAdditional);
            foreach ($productSpecificationsAdditional as $key => $productSpecification) {
                $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
            }

            /*
            * Additional specification
            */
            $product ['specAdditional'] = [];
            $countSpecifications = ProductSpecification::find()->where(['product_id' => $item->id])
                ->andWhere(['value' => 1])->count();
            if ($countSpecifications > 0) {
                foreach ($productSpecificationsAdditionalCols as $i => $productSpecificationsAdditionalCol) {
                    foreach ($productSpecificationsAdditionalCol as $i => $productSpecificationsAdditional) {
                        $spec = $productSpecificationsAdditional->getSpecification()->one();
                        if ((int)$productSpecificationsAdditional->value == 1) {
                            $product  ['spec_additional'] [$i] ['name'] = $spec->i18n()->name;
                        }
                    }
                }
            }

            /*
             * Main Specification
             */
            $product ['spec'] = [];
            foreach ($productSpecificationsMain as $i => $productSpec) {
                $spec = $productSpec->getSpecification()->one();
                $product  ['spec'] [$i] ['name'] = $spec->i18n()->name;
                $product  ['spec'] [$i] ['format'] = $productSpec->getFormattedValue();
                $product  ['spec'] [$i] ['unit'] = $spec->i18n()->unit;
            }

            /*
             * Similar product
             */
            $similarProducts = Product::find()
                ->where(['status' => Product::STATUS_PUBLISHED])
                ->andwhere(['make' => $item->make])
                ->andWhere(['model' => $item->model])
                ->orderBy('RAND()')
                ->limit(4)
                ->all();
            $product ['similar'] = [];
            foreach ($similarProducts as $i => $similarProduct) {
                $product['similar'][$i]['id'] = $similarProduct->id;
                $product['similar'][$i]['main_image_url'] = $similarProduct->getTitleImageUrl(640, 480);
                $product['similar'][$i]['full_title'] = $similarProduct->getFullTitle();
                $product['similar'][$i]['price_byn'] = $similarProduct->getByrPrice();
                $product['similar'][$i]['price_usd'] = $similarProduct->getUsdPrice();
                $product['similar'][$i]['spec'] = [];
                foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGHEST) as $params => $productSpec) {
                    $spec = $productSpec->getSpecification()->one();
                    $product['similar'][$i]['spec'][$params]['name'] = $spec->i18n()->name;
                    $product['similar'][$i]['spec'][$params]['get_title_image_url'] = $spec->getTitleImageUrl(20, 20);
                    $product['similar'][$i]['spec'][$params]['value'] = $productSpec->getFormattedValue();
                    $product['similar'][$i]['spec'][$params]['unit'] = $spec->i18n()->unit;
                }
                unset($productSpec);
                unset($params);
                foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGH) as $params => $productSpec) {
                    $spec = $productSpec->getSpecification()->one();
                    $product['similar'][$i]['spec'][$params]['priority_hight']['name'] = $spec->i18n()->name;
                    $product['similar'][$i]['spec'][$params]['priority_hight']['value'] = $productSpec->getFormattedValue();
                    $product['similar'][$i]['spec'][$params]['priority_hight']['unit'] = $spec->i18n()->unit;
                }
            }

//                    $views = $product['views'];
//                    $product = json_encode($product);
//                    $params = [
//                        'product' => json_encode($product),
//                        'counter' => $views,
//                    ];
//                    unset($product);
            $params= [];
            $params['body'] = $product;
            $params['index'] = 'automechta';
            $params['type'] = 'product';
            $params['id'] = $item->id;
            $result = $client->index($params);

//                    Yii::$app->cache->hmset('product_' . $item->id, $params, 172800);
//                    unset($params);
            gc_collect_cycles();
        }


        return true;
    }

    public static function ClearAllCache()
    {
        Yii::$app->cache->clearAll();
    }
}