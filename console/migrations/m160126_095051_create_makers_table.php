<?php

use yii\db\Schema;
use yii\db\Migration;

class m160126_095051_create_makers_table extends Migration
{
    public function up()
    {
        $this->createTable('product_make', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->alterColumn('product', 'model', $this->string(2048));

        $this->addForeignKey('FK_Product_ProductMake', 'product', 'make', 'product_make', 'id', 'SET NULL', 'SET NULL');

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewProductMake' => [
                'description' => 'View product type data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createProductMake' => [
                'description' => 'Create product make',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateProductMake' => [
                'description' => 'Update product make',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteProductMake' => [
                'description' => 'Delete product make',
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
        echo "m160126_095051_create_makers_table cannot be reverted.\n";

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
