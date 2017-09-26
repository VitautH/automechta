<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_082630_create_teaser_table extends Migration
{
    public function up()
    {
        $this->createTable('teaser', [
            'id' => $this->primaryKey(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'link' => $this->string(256),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createTable('teaser_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'title' => $this->text(),
            'header' => $this->text(),
            'caption' => $this->text(),
            'button_text' => $this->text(),
        ]);

        $this->addForeignKey('FK_Teaser_TeaserI18N', 'teaser_i18n', 'parent_id', 'teaser', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewTeaser' => [
                'description' => 'View teaser data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createTeaser' => [
                'description' => 'Create teaser',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateTeaser' => [
                'description' => 'Update teaser',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteTeaser' => [
                'description' => 'Delete teaser',
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
        echo "m160124_082630_create_teaser_table cannot be reverted.\n";

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
