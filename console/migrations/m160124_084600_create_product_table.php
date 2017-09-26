<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_084600_create_product_table extends Migration
{
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'type' => $this->integer(),
            'make' => $this->integer(),
            'model' => $this->integer(),
            'price' => $this->integer(),
            'views' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createTable('product_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'title' => $this->text(),
            'seller_comments' => $this->text(),
        ]);

        $this->addForeignKey('FK_Product_ProductI18N', 'product_i18n', 'parent_id', 'product', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $authorRule = new \common\rbac\AuthorRule();

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewProduct' => [
                'description' => 'View product data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createProduct' => [
                'description' => 'Create product',
                'roles' => [$admin, $registered],
                'rules' => [],
            ],
            'updateProduct' => [
                'description' => 'Update product',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteProduct' => [
                'description' => 'Delete product',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateOwnProduct' => [
                'description' => 'Update own product',
                'roles' => [$registered],
                'rules' => [$authorRule],
            ],
            'deleteOwnProduct' => [
                'description' => 'Delete own product',
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

        $deleteProduct = $auth->getPermission('deleteProduct');
        $deleteOwnProduct = $auth->getPermission('deleteOwnProduct');
        $auth->addChild($deleteOwnProduct, $deleteProduct);

        $updateProduct = $auth->getPermission('updateProduct');
        $updateOwnProduct = $auth->getPermission('updateOwnProduct');
        $auth->addChild($updateOwnProduct, $updateProduct);
    }

    public function down()
    {
        echo "m160124_084600_create_product_table cannot be reverted.\n";

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
