<?php

use yii\db\Schema;
use yii\db\Migration;

class m160118_141936_file_permissions extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $authorRule = new \common\rbac\AuthorRule();

        $permissions = [
            'uploadFile' => [
                'description' => 'Upload file',
                'roles' => [$admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'removeFile' => [
                'description' => 'Remove uploaded file',
                'roles' => [$admin],
                'rules' => [],
            ],
            'removeOwnFile' => [
                'description' => 'Remove own uploaded file',
                'roles' => [$registered, $registeredUnconfirmed],
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

        $removeFile = $auth->getPermission('removeFile');
        $removeOwnFile = $auth->getPermission('removeOwnFile');
        $auth->addChild($removeOwnFile, $removeFile);
    }

    public function down()
    {
        echo "m160118_141936_file_permissions cannot be reverted.\n";

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
