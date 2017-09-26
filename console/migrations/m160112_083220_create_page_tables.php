<?php

use yii\db\Schema;
use yii\db\Migration;

class m160112_083220_create_page_tables extends Migration
{
    public function up()
    {
        $this->createTable(
            'page',
            [
                'id' => $this->primaryKey(),
                'alias' => $this->string(256),
                'type' => $this->integer(),
                'status' => $this->integer(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ]
        );

        $this->createTable(
            'page_i18n',
            [
                'id' => $this->primaryKey(),
                'parent_id' => $this->integer()->notNull(),
                'language' => $this->string(32),
                'header' => $this->text(),
                'description' => $this->text(),
                'content' => $this->text(),
            ]
        );

        $this->addForeignKey('FK_Page_PageI18N', 'page_i18n', 'parent_id', 'page', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'createPage' => [
                'description' => 'Create new page',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updatePage' => [
                'description' => 'Update (change) page',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deletePage' => [
                'description' => 'Delete page',
                'roles' => [$admin],
                'rules' => [],
            ],
            'viewPage' => [
                'description' => 'View page',
                'roles' => [$admin, $guest, $registered, $registeredUnconfirmed],
                'rules' => [],
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
        $this->dropTable('page_i18n');
        $this->dropTable('page');

        $auth = Yii::$app->authManager;

        $permissions = [
            'createPage',
            'updatePage',
            'deletePage',
            'viewPage',
        ];

        foreach ($permissions as $permissionName) {
            $permission = $auth->getPermission($permissionName);
            $auth->remove($permission);
        }
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
