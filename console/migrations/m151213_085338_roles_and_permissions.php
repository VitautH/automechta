<?php

use yii\db\Schema;
use yii\db\Migration;

class m151213_085338_roles_and_permissions extends Migration
{

    public function up()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAllRoles();
        $auth->removeAllPermissions();
        $auth->removeAllRules();

        //Roles
        $admin = $auth->createRole('Administrator');
        $admin->description = Yii::t('app', 'Application administrator');

        $guest = $auth->createRole('Guest');
        $guest->description = Yii::t('app', 'Not authenticated (logged) user');

        $registered = $auth->createRole('Registered');
        $registered->description = Yii::t('app', 'Registered user');

        $registeredUnconfirmed = $auth->createRole('RegisteredUnconfirmed');
        $registeredUnconfirmed->description = Yii::t('app', 'Registered unconfirmed user');

        //Rules
        $authorRule = new \common\rbac\AuthorRule();

        $auth->add($admin);
        $auth->add($guest);
        $auth->add($registered);
        $auth->add($registeredUnconfirmed);
        $auth->add($authorRule);

        $permissions = [
            'createRole' => [
                'description' => 'Create new user role',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateRole' => [
                'description' => 'Update (change) user role',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteRole' => [
                'description' => 'Delete user role',
                'roles' => [$admin],
                'rules' => [],
            ],
            'viewRole' => [
                'description' => 'View user role data',
                'roles' => [$admin],
                'rules' => [],
            ],
            'createPermission' => [
                'description' => 'Create new access permission',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updatePermission' => [
                'description' => 'Update (change) access permission',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deletePermission' => [
                'description' => 'Delete access permission',
                'roles' => [$admin],
                'rules' => [],
            ],
            'viewPermission' => [
                'description' => 'View access permission data',
                'roles' => [$admin],
                'rules' => [],
            ],
            'createUser' => [
                'description' => 'Create new user',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateUser' => [
                'description' => 'Update (change) user',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteUser' => [
                'description' => 'Delete user',
                'roles' => [$admin],
                'rules' => [],
            ],
            'viewUser' => [
                'description' => 'View user data',
                'roles' => [$admin],
                'rules' => [],
            ],
            'createMenuItem' => [
                'description' => 'Create menu item',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateMenuItem' => [
                'description' => 'Update (change) menu item',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteMenuItem' => [
                'description' => 'Delete menu item',
                'roles' => [$admin],
                'rules' => [],
            ],
            'viewMenuItem' => [
                'description' => 'View menu item',
                'roles' => [$registered, $guest, $admin, $registeredUnconfirmed],
                'rules' => [],
            ],
            'updateOwnProfile' => [
                'description' => 'Update own (change) user data',
                'roles' => [$registered],
                'rules' => [$authorRule],
            ],
            'viewOwnProfile' => [
                'description' => 'View own user data',
                'roles' => [$registered],
                'rules' => [$authorRule],
            ],
        ];

        foreach ($permissions as $permissionName => $permissionData) {
            $permission = $auth->createPermission($permissionName);

            if (isset($permissionData['description']) ) {
                $permission->description = $permissionData['description'];
            }

            if (isset($permissionData['rules']) ) {
                foreach ($permissionData['rules'] as $rule) {
                    $permission->ruleName = $rule->name;
                }
            }

            $auth->add($permission);

            if (isset($permissionData['roles']) ) {
                foreach ($permissionData['roles'] as $role) {
                    $auth->addChild($role, $permission);
                }
            }
        }
    }

    public function down()
    {
        echo "m151213_085338_roles_and_permissions cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
