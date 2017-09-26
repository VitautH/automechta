<?php

namespace backend\controllers;

use common\models\AuthItemSearch;
use Yii;
use common\models\AuthItem;
use yii\rbac\Item;
use yii\rbac\Permission;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * PermissionsController implements the CRUD actions for permissions (AuthItem model).
 */
class PermissionsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all permissions.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewPermission')) {
            Yii::$app->user->denyAccess();
        };

        $searchModel = new AuthItemSearch();
        $params = Yii::$app->request->get();
        $params['AuthItemSearch']['type'] = $searchModel->type = Item::TYPE_PERMISSION;
        $searchModel->load($params);
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new permission (AuthItem model).
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createPermission')) {
            Yii::$app->user->denyAccess();
        };

        $model = new AuthItem();
        $model->type = Item::TYPE_PERMISSION;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $permission = $auth->createPermission($model->name);
            $permission->description = $model->description;
            $auth->add($permission);
            $this->afterCreate($permission);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing permission (AuthItem model).
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $name name of permission
     * @return mixed
     */
    public function actionUpdate($name)
    {
        if (!Yii::$app->user->can('updatePermission')) {
            Yii::$app->user->denyAccess();
        };

        $model = $this->findModel($name);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @return mixed
     */
    public function actionDelete($name)
    {
        if (!Yii::$app->user->can('deletePermission')) {
            Yii::$app->user->denyAccess();
        };

        $this->findModel($name)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success'];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Validate permission data
     * @param string $name permission name
     * @return array
     */
    public function actionValidate($name = null)
    {
        if (!Yii::$app->user->can('viewPermission')) {
            Yii::$app->user->denyAccess();
        };

        $model = AuthItem::find()->where(['name' => $name, 'type' => Item::TYPE_PERMISSION])->one();
        if ($model === null) {
            $model = new AuthItem();
            $model->type = Item::TYPE_PERMISSION;
        }
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    /**
     * Callback that is performed after created a new permission.
     * Used to fill `created_by` attribute.
     * @param Permission $permission
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    protected function afterCreate(Permission $permission)
    {
        $user = Yii::$app->get('user', false);
        $userId =  $user && !$user->isGuest ? $user->id : null;
        $model = $this->findModel($permission->name);
        $model->created_by = $userId;
        $model->save();
    }

    /**
     * Finds the AuthItem model based on its primary key value (name).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = AuthItem::find()->where(['name' => $name, 'type' => Item::TYPE_PERMISSION])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
