<?php

namespace frontend\controllers;

use common\models\ProductMake;
use common\models\ProductType;
use common\models\Product;
use common\models\Page;
use common\models\Menu;
use yii\web\Controller;
use yii\db\Query;
use Yii;
use common\helpers\Url;
ini_set('memory_limit','2048M');
class SitemapController extends Controller
{


    public function actionIndex()
    {
        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {  // проверяем есть ли закэшированная версия sitemap

            $menus = Menu::find()->all();

            foreach ($menus as $menu) {
                $urls[] = array(
                    htmlspecialchars(Url::to($menu['route'], true)), 'daily'
                );
            }

            $items = array();
            $items = array_merge($items, Page::find()->active()->all());
            $items = array_merge($items, Product::find()->active()->all());

            foreach ($items as $item) {
                $urls[] = array(
                    htmlspecialchars(Url::to(Url::UrlShowProduct($item->id), true)), 'daily'
                );
            }

            foreach (array_keys(ProductType::getTypesAsArray()) as $key) {
                $urls[] = array(
                    htmlspecialchars(Url::to(Url::UrlBaseCategory($key), true)), 'daily'
                );

                $makers = ProductMake::getMakesListWithId($key, true);

                foreach ($makers as $maker) {
                    $urls[] = array(
                        htmlspecialchars(Url::to(Url::UrlCategoryBrand($key,$maker['name'] ), true)), 'daily'
                    );

                    $models = ProductMake::getModelsListWithId($maker['id'], $key, true);

                    foreach ($models as $modelauto) {
                        $urls[] = array(
                            htmlspecialchars(Url::to(Url::UrlCategoryModel($key,$maker['name'],$modelauto['id']), true)), 'daily'
                        );
                    }
                }
            }

            $xml_sitemap = $this->renderPartial('index', array('urls' => $urls));

            Yii::$app->cache->set('sitemap', $xml_sitemap, 3600); // кэшируем результат на час.
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_XML; // устанавливаем формат отдачи контента

        echo $xml_sitemap;
    }
}