<?php

use yii\db\Schema;
use yii\db\Migration;

class m160313_165621_credit_application extends Migration
{
    public function up()
    {
        $this->createTable('credit_application', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'name' => $this->text()->notNull(),
            'phone' => $this->string(256)->notNull(),
            'dob' => $this->string(256)->notNull(),
            'sex' => $this->integer()->notNull(),
            'family_status' => $this->integer()->notNull(),
            'previous_conviction' => $this->integer(),
            'job' => $this->text()->notNull(),
            'experience' => $this->text()->notNull(),
            'salary' => $this->integer()->notNull(),
            'loans_payment' => $this->integer()->notNull(),
            'product' => $this->text()->notNull(),
            'credit_amount' => $this->text()->notNull(),
            'term' => $this->string(256)->notNull(),
            'information_on_income' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);


        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewCreditApplication' => [
                'description' => 'View credit application',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createCreditApplication' => [
                'description' => 'Create credit application',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateCreditApplication' => [
                'description' => 'Update credit application',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteCreditApplication' => [
                'description' => 'Delete credit application',
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
        echo "m160313_165621_credit_application cannot be reverted.\n";

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
