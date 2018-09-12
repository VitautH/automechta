<?php

namespace backend\controllers;

use backend\models\Reports;
use common\models\AuthItem;
use Yii;
use yii\filters\VerbFilter;
use common\models\UserSearch;
use common\models\User;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use common\models\Uploads;
use yii\web\HttpException;
use common\models\AuthAssignment;
use backend\models\Tasks;

/**
 * Class UserController
 *
 * User management controller.
 * Implements the CRUD actions for user model.
 *
 * @package backend\controllers
 */
class UsersController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }

    /**
     * List of users
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewUser')) {
            Yii::$app->user->denyAccess();
        };

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $params = Yii::$app->request->get();
        if (!isset($params['sort'])) {
            $dataProvider->query->orderBy('id DESC');
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * List of users
     *
     * @return string
     */
    public function actionAccount()
    {
        $modelPhoto = Uploads::find()->where(['linked_table' => 'user'])->andWhere(['linked_id' => Yii::$app->user->id])->one();
        if (empty($modelPhoto)) {
            $modelPhoto = new Uploads();
        }

        $report = new Reports();
        $modelTask = new Tasks();

        $model = User::findOne(Yii::$app->user->id);

        $role = AuthAssignment::find()->select('item_name')->where(['user_id' => Yii::$app->user->id])->one();
        $userRole = array();
        $userRole['name'] = Yii::t('app', $role->item_name);
        $userRole['id'] = AuthItem::find()->select('id')->where(['name'=> $role->item_name])->one()->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Saved'));
            return $this->refresh();
        } else {

            return $this->render('account', [
                'model' => $model,
                'userRole' => $userRole,
                'modelReport' => $report,
                'modelPhoto' => $modelPhoto,
                'modelTask'=>$modelTask

            ]);
        }
    }


    /**
     * Creates a new User.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createUser')) {
            Yii::$app->user->denyAccess();
        };

        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveAssignments($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing user.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id id of user
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateUser')) {
            Yii::$app->user->denyAccess();
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveAssignments($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing user model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteUser')) {
            Yii::$app->user->denyAccess();
        };

        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success'];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Validate user data
     * @param integer $id user id
     * @return array
     */
    public function actionValidate($id = null)
    {
        if (!Yii::$app->user->can('viewUser')) {
            Yii::$app->user->denyAccess();
        };

        $model = User::findOne($id);
        if ($model === null) {
            $model = new User();
        }
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    /**
     * Save user roles. Roles list will be retrieved from $_POST['roles'] array
     * @param User $user
     */
    private function saveAssignments(User $user)
    {
        $rolesToSave = array_keys(Yii::$app->request->post('roles', []));

        Yii::$app->authManager->revokeAll($user->id);

        foreach ($rolesToSave as $roleName) {
            $role = Yii::$app->authManager->getRole($roleName);
            Yii::$app->authManager->assign($role, $user->id);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
