<?php

namespace frontend\controllers;

use common\models\AutoModels;
use common\models\AutoModifications;
use common\models\AutoModification;
use common\models\AutoSearch;
use common\models\ProductMake;
use Yii;
use yii\web\Controller;
use common\models\AutoSpecifications;
use yii\web\NotFoundHttpException;
use common\models\AutoMakes;
use common\models\AutoRegions;
use dastanaron\translit\Translit;
use yii\web\HttpException;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class ModificationController extends Controller
{
    public $layout = 'new-index';
    public $bodyClass;

    public function behaviors()
    {
        return [
            'httpCache' => [
                'class' => 'yii\filters\HttpCache',
                'sessionCacheLimiter' => 'public',
                'cacheControlHeader' => 'public, max-age=360000000',
            ],
        ];
            }

    public function actionIndex()
    {
        $this->view->title = 'Технические характеристики автомобилей, модельный ряд, фото, комплектация';
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Подробные технические характеристики автомобилей. Информация по двигателю, разгону, коробке передач, подвеске. Комплектации и цены, фото салона и экстерьера автомобилей'
        ]);

        $this->bodyClass = 'marks-list-page';
        $params['total'] = AutoModifications::find()->count();

        return $this->render('index', [
            'title' => 'Энциклопедия автомобилей',
            '_params_' => $params,
        ]);
    }

    public function actionMaker($maker)
    {

        $mark = AutoMakes::find()->where(['slug' => $maker])->one();

        $logo = ProductMake::find()->select('url_logo')->where(['like','name',$mark->name])->one();

        if ($mark == null) {
            Yii::$app->response->statusCode = 404;
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }

        $params = Yii::$app->request->get();
        $sort = 'model ASC';
        $sortData = new Sort([
            'attributes' => [
                'year' => [
                    'asc' => ['year' => SORT_ASC],
                    'desc' => ['year' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дате',
                ],
                'alphabet' => [
                    'asc' => ['alphabet' => SORT_ASC],
                    'desc' => ['alphabet' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Алфавиту',
                ],
                ],
                ]);

        if (isset($params['sort'])) {
            switch ($params['sort']) {
                case 'alphabet':
                    $sort = 'model DESC';
                    break;
                case '-alphabet':
                    $sort = 'model ASC';
                    break;
                case 'year':
                    $sort = 'yearFrom DESC';
                    break;
                case '-year':
                    $sort = 'yearFrom ASC';
                    break;

            }

        }
                $model = AutoModels::find()->where(['make_id' => $mark->id])->orderBy($sort)->all();

        if ($model == null) {
            Yii::$app->response->statusCode = 404;
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }


        $this->bodyClass = 'maker-page';
        $this->view->title = 'Технические характеристики ' . $mark->name . ', модельный ряд, фото, комплектация';
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Подробные технические характеристики ' . $mark->name . '. Информация по двигателю, разгону, коробке передач, подвеске. Комплектации и цены, фото салона и экстерьера ' . $maker . ''
        ]);

        return $this->render('maker', [
            'models' => $model,
            'logo'=>$logo->url_logo,
            'markName' => $mark->name,
            'markSlug' => $maker,
            'sort' => $sortData,
            'title' => 'Каталог ' . $mark->name . ' характеристики, спецификации',
        ]);
    }

    public function actionModels($maker, $models)
    {
        $mark = AutoMakes::find()->where(['slug' => $maker])->one();

        if ($mark == null) {
            Yii::$app->response->statusCode = 404;
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }

        $modelAuto = AutoModels::find()->where(['make_id' => $mark->id])->andWhere(['slug' => $models])->one();

        $model = AutoModifications::find()->where(['model_id' => $modelAuto->id])->all();
        if ($model == null) {
            Yii::$app->response->statusCode = 404;
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }

        $logo = ProductMake::find()->select('url_logo')->where(['like','name',$mark->name])->one();

        $this->bodyClass = 'model-page';
        $this->view->title = 'Технические характеристики ' . $mark->name . ' ' . $modelAuto->model . ', модельный ряд, фото, комплектация';
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Подробные технические характеристики ' . $mark->name . ' ' . $modelAuto->model . '. Информация по двигателю, разгону, коробке передач, подвеске. Комплектации и цены, фото салона и экстерьера ' . $maker . ''
        ]);


        return $this->render('model', [
            'models' => $model,
            'markName' => $mark->name,
            'modelName' => $modelAuto->model,
            'modelSlug' => $modelAuto->slug,
            'markSlug' => $mark->slug,
            'logo'=>$logo->url_logo,
            'title' => 'Модификации ' . $mark->name . ' ' . $modelAuto->model . ' характеристики, спецификации',
        ]);
    }

    public function actionShow($maker, $models, $id)
    {
        $markAuto = AutoMakes::find()->where(['slug' => $maker])->one();

        if ($markAuto == null) {
            Yii::$app->response->statusCode = 404;
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }
        $modelAuto = AutoModels::find()->where(['make_id' => $markAuto->id])->andWhere(['slug' => $models])->one();

        if ($modelAuto == null) {
            Yii::$app->response->statusCode = 404;
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }

        $model = $this->findModel($id);
        $logo = ProductMake::find()->select('url_logo')->where(['like','name',$markAuto->name])->one();


        $this->bodyClass = 'specification-cars-page';
        $this->view->title = 'Технические характеристики ' . $markAuto->name . ' ' . $modelAuto->model . ' ' . $model->modification_name . ', модельный ряд, фото, комплектация';
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Подробные технические характеристики ' . $markAuto->name . ' ' . $modelAuto->model . ' ' . $model->modification_name . '. Информация по двигателю, разгону, коробке передач, подвеске. Комплектации и цены, фото салона и экстерьера ' . $maker . ''
        ]);

        return $this->render('show', [
            'model' => $model,
            'modelName' => $modelAuto->model,
            'markName' => $markAuto->name,
            'modificationName' => $model->modification_name,
            'modelSlug' => $modelAuto->slug,
            'markSlug' => $markAuto->slug,
            'modificationSlug' => $model->slug,
            'logo'=>$logo->url_logo,
            'title' => $markAuto->name . ' ' . $modelAuto->model . ' ' . $model->modification_name,
        ]);
    }

    /*
     * Ajax load  modification list
     * @param $id
     * @throws NotFoundHttpException
     * @return array|Response
     */
    public function actionLoadModification($id)
    {
        if (Yii::$app->request->isAjax) {

            $seconds_to_cache = 0;
            $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
            header("Expires: $ts");
            header("Pragma: cache");
            header("Cache-Control: max-age=$seconds_to_cache");
            Yii::$app->response->format = Response::FORMAT_JSON;

            $allModifications = AutoModifications::findOne($id);

            //Slug Maker && Model
            $model = AutoModels::findOne($allModifications->model_id);
            $modelSlug = $model->slug;
            $makerSlug = AutoMakes::find()->where(['id' => $model->make_id])->one()->slug;

            $query = AutoModification::find();
            $query->where(['modification_id' => $id]);
            $query->andFilterWhere(['>=', 'yearFrom', $allModifications->yearFrom]);
            if ($allModifications->yearTo == 'н.в.') {
                $query->andWhere("yearTo <= " . date("Y") . " OR yearTo = 'н.в.'");
            } else {
                $query->andFilterWhere(['<=', 'yearTo', $allModifications->yearTo]);
            }

            $query->orderBy('yearFrom', 'ASC');
            $modifications = $query->all();

            $result = array();
            foreach ($modifications as $modification) {
                $result[] = ['maker_slug' => $makerSlug, 'model_slug' => $modelSlug, 'modification_id' => $modification->id, 'modification_name' => $modification->modification_name,
                    'modification_yearFrom' => $modification->yearFrom, 'modification_yearTo' => $modification->yearTo, 'modification_engine' => $modification->engine, 'modification_drive_unit' => $modification->drive_unit];
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionModificationsearch()
    {
        \Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, nofollow'
        ]);

        $params = Yii::$app->request->get();
        $autoSearch = new AutoSearch();
        if (!empty($params['AutoSearch']['yearFrom'])) {
            $autoSearch->yearFrom = $params['AutoSearch']['yearFrom'];
        }
        if (!empty($params['AutoSearch']['region'])) {
            $autoSearch->region = $params['AutoSearch']['region'];
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
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $params['total'] = $query->count();
        $this->bodyClass = 'modification-search-page';
        $dataProvider->pagination->pageSize=7;
        
        return $this->render('search', [
            '_params_' => $params,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Product model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AutoSpecifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AutoModification::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            Yii::$app->response->statusCode = 404;
            throw new NotFoundHttpException('Извините, данной страницы не существует.');
        }
    }

}