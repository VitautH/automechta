<?php

use yii\db\Schema;
use yii\db\Migration;

class m160128_071730_add_priority_column_to_product_table extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'priority', $this->integer());

        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('Administrator');
        $permission = $auth->createPermission('changeProductPriority');
        $permission->description = 'Change priority value of product';
        $auth->add($permission);
        $auth->addChild($admin, $permission);
    }

    public function down()
    {
        $this->dropColumn('product', 'priority');
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
