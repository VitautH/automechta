<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 27.09.2017
 * Time: 17:22
 */

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Complaint;
use yii\data\ActiveDataProvider;

class ComplaintController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewProduct')) {
            Yii::$app->user->denyAccess();
        }

        $query = Complaint::find()->indexBy('id')->orderBy([
            'id' => SORT_DESC
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('viewProduct')) {
            Yii::$app->user->denyAccess();
        }

        if (Yii::$app->request->isAjax) {
            $model = Complaint::findOne($id);
            $model->viewed = Complaint::VIEWED;
            if ($model->save()) {
                return $this->actionIndex();
            }

        }

    }
}