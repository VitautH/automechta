<?php

namespace frontend\controllers;

use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Controller;
use common\models\Page;
use common\helpers\Url;

/**
 * Page controller
 */
class PageController extends Controller
{
    public $layout = 'new-index';
    public $bodyClass;

    public function beforeAction($action)
    {
        Url::remember('/account/index', 'previous');

        return parent::beforeAction($action);
    }

    /**
     * @param string $alias page alias
     *
     * @return index
     */
    public function actionShow($alias)
    {
        $model = $this->findModel($alias);

        $model->increaseViews();

        switch ($alias) {
            case 'avto-v-kredit':
                $this->bodyClass = 'avto-v-kredit';
                $this->layout = 'new-index';

                return $this->render('avto-v-kredit', [
                    'model' => $model,
                ]);
                break;
            case 'oformlenie-schet-spravki':
                $this->bodyClass = 'oformlenie-schet-spravki';
                $this->layout = 'new-index';

                return $this->render('oformlenie-schet-spravki', [
                    'model' => $model,
                ]);
                break;
            case 'obmen-avto':
                $this->bodyClass = 'trade-in';
                $this->layout = 'new-index';

                return $this->render('trade-in', [
                    'model' => $model,
                ]);
                break;
            case 'srochnyj-vykup':
                $this->bodyClass = 'srochnyj-vykup';
                $this->layout = 'new-index';

                return $this->render('srochnyj-vykup', [
                    'model' => $model,
                ]);
                break;
            case 'prijom-avto-na-komissiju':
                $this->bodyClass = 'prijom-avto-na-komissiju';
                $this->layout = 'new-index';

                return $this->render('prijom-avto-na-komissiju', [
                    'model' => $model,
                ]);
                break;
            default:
                return $this->render('show', [
                    'model' => $model,
                ]);
                break;
        }
    }

    /**
     * Finds the Product model based on its primary key value (id).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $alias
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alias)
    {
        if (($model = Page::find()->where(['alias' => $alias])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
