<?php

namespace backend\controllers;

use common\models\AuthItemQuery;
use common\models\AuthItemSearch;
use Yii;
use common\models\AuthItem;
use yii\rbac\Item;
use yii\rbac\Role;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * RolesController implements the CRUD actions for user roles (AuthItem model).
 */
class RolesController extends \yii\web\Controller
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
     * Lists all roles.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewRole')) {
            Yii::$app->user->denyAccess();
        };

        $searchModel = new AuthItemSearch();
        $params = Yii::$app->request->get();
        $params['AuthItemSearch']['type'] = $searchModel->type = Item::TYPE_ROLE;
        $searchModel->load($params);
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new Role (AuthItem model).
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createRole')) {
            Yii::$app->user->denyAccess();
        };

        $model = new AuthItem();
        $model->type = Item::TYPE_ROLE;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $role = $auth->createRole($model->name);
            $role->description = $model->description;
            $auth->add($role);
            $this->afterCreate($role);
            $this->savePermissions($role);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'permissions' => Yii::$app->authManager->getPermissions(),
            ]);
        }
    }

    /**
     * Updates an existing role (AuthItem model).
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $name name of role
     * @return mixed
     */
    public function actionUpdate($name)
    {
        if (!Yii::$app->user->can('updateRole')) {
            Yii::$app->user->denyAccess();
        };

        $model = $this->findModel($name);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->savePermissions(Yii::$app->authManager->getRole($model->name));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'permissions' => Yii::$app->authManager->getPermissions(),
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
        if (!Yii::$app->user->can('deleteRole')) {
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
     * Validate role data
     * @param string $name role name
     * @return array
     */
    public function actionValidate($name = null)
    {
        if (!Yii::$app->user->can('viewRole')) {
            Yii::$app->user->denyAccess();
        };

        $model = AuthItem::find()->where(['name' => $name, 'type' => Item::TYPE_ROLE])->one();
        if ($model === null) {
            $model = new AuthItem();
            $model->type = Item::TYPE_ROLE;
        }
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    /**
     * Save role permissions. Permissions will be retrieved from $_POST['permissions'] array
     * @param Item $role
     */
    private function savePermissions(Item $role)
    {
        $currentPermissions = Yii::$app->authManager->getPermissionsByRole($role->name);
        $permissionsToSave = array_keys(Yii::$app->request->post('permissions', []));

        foreach ($currentPermissions as $currentPermission) {
            if (!in_array($currentPermission->name, $permissionsToSave)) {
                Yii::$app->authManager->removeChild($role, $currentPermission);
            }
        }

        foreach ($permissionsToSave as $permissionName) {
            $permission = Yii::$app->authManager->getPermission($permissionName);
            if (!Yii::$app->authManager->hasChild($role, $permission)) {
                Yii::$app->authManager->addChild($role, $permission);
            }
        }
    }

    /**
     * Callback that is performed after created a new role.
     * Used to fill `created_by` attribute.
     * @param Role $role
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    protected function afterCreate(Role $role)
    {
        $user = Yii::$app->get('user', false);
        $userId =  $user && !$user->isGuest ? $user->id : null;
        $model = $this->findModel($role->name);
        $model->created_by = $userId;
        $model->save();
    }

    /**
     * @return AuthItemSearch
     */
    protected function getPermissionsSearchModel()
    {
        $searchModel = new AuthItemSearch();
        $params = Yii::$app->request->get();
        $params['AuthItemSearch']['type'] = $searchModel->type = Item::TYPE_PERMISSION;
        $searchModel->load($params);

        return $searchModel;
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
        if (($model = AuthItem::find()->where(['name' => $name, 'type' => Item::TYPE_ROLE])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
