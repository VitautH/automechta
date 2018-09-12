<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use backend\models\Tasks;
use common\helpers\Date;
use yii\data\ActiveDataProvider;

/**
 * Class TaskController
 *
 * Task management controller.
 *
 * @package backend\controllers
 */
class TaskController extends \yii\web\Controller
{

    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = new Tasks();
            $model->setScenario(Tasks::SCENARIO_CREATETASK);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'failed', 'message' => json_encode($model->getErrors())];
            }

        } else {
            Yii::$app->user->denyAccess();
        }
    }

    public function actionShow($id)
    {
        $task = Tasks::find()->where(['employee_to' => Yii::$app->user->id])->andWhere(['id' => $id])->one();

        if ($task === null) {
            throw new NotFoundHttpException('Извините, задача не найдена');
        }

        return $this->render('show', [
            'task' => $task,
        ]);
    }

    public function actionOwnTask($id)
    {
        $task = Tasks::find()->where(['id' => $id])->one();

        if ($task === null) {
            throw new NotFoundHttpException('Извините, задача не найдена');
        }

        return $this->render('show-own-task', [
            'task' => $task,
        ]);
    }

    public function actionUser(){
        $tasks = Tasks::find()->where(['employee_to' => Yii::$app->user->id])->orderBy('priority DESC')->addOrderBy('created_at DESC')->all();

        if ($tasks === null) {
            throw new NotFoundHttpException('Извините, задача не найдена');
        }

        return $this->render('user', [
            'tasks' => $tasks,
        ]);
    }

    public function actionIndex(){
        $query = Tasks::find()->orderBy('priority DESC')->addOrderBy('updated_at DESC');
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

    public function actionChangeStatus($task, $status){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

                $model = Tasks::find()->where(['employee_to' => Yii::$app->user->id])->andWhere(['id' => $task])->one();
                $model->setScenario(Tasks::SCENARIO_CHANGESTATUS);
                $model->status = $status;

            if ($model->save()){
                return ['status' => 'success', 'task-id'=>$task];
            }
            else {
                return ['status' => 'failed', 'message' => json_encode($model->getErrors())];
            }
        }
        else {
            Yii::$app->user->denyAccess();
        }
    }

    public function actionCheckTask()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();

            $model = Tasks::find()->where(['employee_to' => $post['employee_to']])->andWhere(['id' => $post['id']])->one();
            $model->setScenario(Tasks::SCENARIO_CHANGESTATUS);
            $model->status =   $post['status'];
            $model->comment =   $post['comment'];

            if ($model->validate() && $model->save()){
                return ['status' => 'success', 'task-id'=>$post['id']];
            }
            else {
                return ['status' => 'failed', 'message' => json_encode($model->getErrors())];
            }
        }
        else {
            Yii::$app->user->denyAccess();
        }
    }
}