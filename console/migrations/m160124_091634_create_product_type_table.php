<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_091634_create_product_type_table extends Migration
{
    public function up()
    {
        $this->createTable('product_type', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createTable('product_type_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'name' => $this->text(),
            'description' => $this->text(),
        ]);

        $this->addForeignKey('FK_ProductType_ProductTypeI18N', 'product_type_i18n', 'parent_id', 'product_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_ProductType_ProductType', 'product', 'type', 'product_type', 'id', 'SET NULL', 'CASCADE');

        $this->createTable('product_type_specifications', [
            'id' => $this->primaryKey(),
            'type' =>  $this->integer()->notNull(),
            'specification' =>  $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_ProductTypeSpecifications_ProductType', 'product_type_specifications', 'type', 'product_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_ProductTypeSpecifications_Specification', 'product_type_specifications', 'specification', 'specification', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewProductType' => [
                'description' => 'View product type data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createProductType' => [
                'description' => 'Create product type',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateProductType' => [
                'description' => 'Update product type',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteProductType' => [
                'description' => 'Delete product type',
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
        echo "m160124_091634_create_product_type_table cannot be reverted.\n";

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
