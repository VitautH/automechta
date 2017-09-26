<?php
namespace frontend\controllers;

use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Controller;
use common\models\Page;

/**
 * News controller
 */
class NewsController extends Controller
{
    public $layout = 'index';

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Page::find()->active()->news()->orderBy('id desc');

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider
        ]);
    }

    /**
     * @param integer $id product id
     *
     * @return index
     */
    public function actionShow($id)
    {
        $model = $this->findModel($id);

        $model->increaseViews();

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Product model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
