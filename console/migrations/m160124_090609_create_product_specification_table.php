<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_090609_create_product_specification_table extends Migration
{
    public function up()
    {
        $this->createTable('specification', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'direction' => $this->integer(),
            'required' => $this->boolean(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createTable('specification_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'name' => $this->text(),
            'unit' => $this->text(),
            'example' => $this->text(),
            'comment' => $this->text(),
        ]);

        $this->addForeignKey('FK_Specification_SpecificationI18N', 'specification_i18n', 'parent_id', 'specification', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewSpecification' => [
                'description' => 'View specification data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createSpecification' => [
                'description' => 'Create specification',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateSpecification' => [
                'description' => 'Update specification',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteSpecification' => [
                'description' => 'Delete specification',
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
        echo "m160124_090609_create_product_specification_table cannot be reverted.\n";

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
