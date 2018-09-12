<?php
namespace frontend\controllers;

use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Controller;
use common\models\Page;
use common\helpers\Url;
use yii\data\Pagination;

/**
 * News controller
 */
class NewsController extends Controller
{
    public $layout = 'new-index';
    public $bodyClass;
    const PAGE_SIZE = 15;

    public function beforeAction($action)
    {
        Url::remember('/account/index', 'previous');

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $limit = 'LIMIT ' . static::PAGE_SIZE;
        $offset = 0;

        $count = Page::find()->andWhere(['not', ['main_image' => null]])->active()->news()->count();//->orderBy('id desc');
        $lastPage = ceil($count / static::PAGE_SIZE);
        $params = Yii::$app->request->get();

        if (isset($params['page'])) {
            $page = intval($params['page']);
            if ($page !== 1) {
                if ($lastPage >= $page) {
                    $limit = 'LIMIT ' . static::PAGE_SIZE . ' OFFSET ' . static::PAGE_SIZE * ($page - 1);
                    $offset = static::PAGE_SIZE * ($page - 1);
                } else {
                    Yii::$app->response->statusCode = 404;
                    throw new NotFoundHttpException('Извините, данной страницы не существует.');
                }
            }
        } else {
            $page = 1;
        }

        $result = Page::find()->andWhere(['not', ['main_image' => null]])->active()->news()->orderBy('id desc')->limit(static::PAGE_SIZE)->offset($offset)->all();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => static::PAGE_SIZE]);
        $pages->pageSizeParam = false;

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, nofollow'
        ]);

        $this->bodyClass = 'news-index';


        return $this->render('index', [
            'models' => $result,
            'count' => $count,
            'pages' => $pages,
            'currentPage' => $page,
            'lastPage' => $lastPage,
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
        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, nofollow'
        ]);

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
