<?php

use yii\db\Schema;
use yii\db\Migration;

class m160204_150017_app_data_tables extends Migration
{
    public function up()
    {
        $this->createTable('app_data', [
            'id' => $this->primaryKey(),
            'data_key' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createTable('app_data_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'data_val' => $this->text(),
            'data_val_ext' => $this->text(),
        ]);

        $this->addForeignKey('FK_AppData_AppDataI18N', 'app_data_i18n', 'parent_id', 'app_data', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewAppData' => [
                'description' => 'View app data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createAppData' => [
                'description' => 'Create app data',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateAppData' => [
                'description' => 'Update app data',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteAppData' => [
                'description' => 'Delete app data',
                'roles' => [$admin],
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
        echo "m160204_150017_app_data_tables cannot be reverted.\n";

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
