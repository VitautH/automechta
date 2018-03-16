<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 07.12.2017
 * Time: 14:30
 */

namespace common\helpers;

use common\models\ProductMake;
use common\models\Product;
use common\models\ProductType;

class Url extends \yii\helpers\Url
{
    const CARS = 2;
    const MOTO = 3;
    const SCOOTER = 4;
    const ATV = 5;


    public static function UrlBaseCategory($type)
    {
        switch ($type) {
            case self::CARS:
                $type = 'cars';
                break;
            case self::MOTO:
                $type = 'moto';
                break;
            case self::SCOOTER:
                $type = 'scooter';
                break;
            case self::ATV:
                $type = 'atv';
                break;
        }

        $url = "https://" . $_SERVER['HTTP_HOST'] . "/" . $type;

        return $url;
    }

    public static function UrlCategoryBrand($type, $brand)
    {
        switch ($type) {
            case self::CARS:
                $type = 'cars';
                break;
            case self::MOTO:
                $type = 'moto';
                break;
            case self::SCOOTER:
                $type = 'scooter';
                break;
            case self::ATV:
                $type = 'atv';
                break;
        }
        $brand = str_replace(' ', '+', $brand);
        $url = "https://" . $_SERVER['HTTP_HOST'] . "/" . $type . "/" . $brand;

        return $url;
    }

    public static function UrlCategoryModel($type, $brand, $model)
    {
        $modelAuto = ProductMake::find()->where(['id' => $model])->one()->name;
        $modelAuto = str_replace(' ', '+', $modelAuto);
        $brand = str_replace(' ', '+', $brand);
            switch ($type) {
                case self::CARS:
                    $type = 'cars';
                    break;
                case self::MOTO:
                    $type = 'moto';
                    break;
                case self::SCOOTER:
                    $type = 'scooter';
                    break;
                case self::ATV:
                    $type = 'atv';
                    break;
            }

            $url = "https://" . $_SERVER['HTTP_HOST'] . "/" . $type . "/" . $brand . "/" . $modelAuto;
            return $url;
        }
        public static function UrlShowProduct($id)
        {
            $product = Product::findOne($id);
            $type = $product->type;
            $brand = ProductMake::find()->where(['id' => $product->make])->one()->name;
            $brand = str_replace(' ', '+', $brand);
            $model = $product->model;
            $model = str_replace(' ', '+', $model);
            switch ($type) {
                case self::CARS:
                    $type = 'cars';
                    break;
                case self::MOTO:
                    $type = 'moto';
                    break;
                case self::SCOOTER:
                    $type = 'scooter';
                    break;
                case self::ATV:
                    $type = 'atv';
                    break;
            }

            $url = "https://" . $_SERVER['HTTP_HOST'] . "/" . $type . "/" . $brand . "/" . $model . "/" . $id."";
            return $url;
        }
    public static function UrlShowPreviewProduct($id)
    {
        $product = Product::findOne($id);
        $type = $product->type;
        $brand = ProductMake::find()->where(['id' => $product->make])->one()->name;
        $brand = str_replace(' ', '+', $brand);
        $model = $product->model;
        $model = str_replace(' ', '+', $model);
        switch ($type) {
            case self::CARS:
                $type = 'cars';
                break;
            case self::MOTO:
                $type = 'moto';
                break;
            case self::SCOOTER:
                $type = 'scooter';
                break;
            case self::ATV:
                $type = 'atv';
                break;
        }

        $url = "https://" . $_SERVER['HTTP_HOST'] . "/" . $type . "/" . $brand . "/" . $model . "/preview/" . $id."";
        return $url;
    }
}