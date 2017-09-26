<?php

use yii\db\Schema;
use yii\db\Migration;

class m160126_125813_craete_product_specifications_table extends Migration
{
    public function up()
    {
        $this->createTable('product_specification', [
            'id' => $this->primaryKey(),
            'specification_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'value' => $this->text(),
            'extra_value' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_Product_ProductSpecification', 'product_specification', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Specification_ProductSpecification', 'product_specification', 'specification_id', 'specification', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $authorRule = new \common\rbac\AuthorRule();

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewProductSpecification' => [
                'description' => 'View product specification data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createProductSpecification' => [
                'description' => 'Create product specification',
                'roles' => [$admin, $registered],
                'rules' => [],
            ],
            'updateProductSpecification' => [
                'description' => 'Update product specification',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteProductSpecification' => [
                'description' => 'Delete product specification',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateOwnProductSpecification' => [
                'description' => 'Update own product specification',
                'roles' => [$registered],
                'rules' => [$authorRule],
            ],
            'deleteOwnProductSpecification' => [
                'description' => 'Delete own product specification',
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

        $deleteProductSpecification = $auth->getPermission('deleteProductSpecification');
        $deleteOwnProductSpecification = $auth->getPermission('deleteOwnProductSpecification');
        $auth->addChild($deleteOwnProductSpecification, $deleteProductSpecification);

        $updateProductSpecification = $auth->getPermission('updateProductSpecification');
        $updateOwnProductSpecification = $auth->getPermission('updateOwnProductSpecification');
        $auth->addChild($updateOwnProductSpecification, $updateProductSpecification);
    }

    public function down()
    {
        echo "m160126_125813_craete_product_specifications_table cannot be reverted.\n";

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
