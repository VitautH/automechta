<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_093644_add_ns_columns_to_product_type_table extends Migration
{
    public function up()
    {
        $this->addColumn('product_type', 'lft', $this->integer()->notNull());
        $this->addColumn('product_type', 'rgt', $this->integer()->notNull());
        $this->addColumn('product_type', 'depth', $this->integer()->notNull());
    }

    public function down()
    {
        echo "m160124_093644_add_ns_columns_to_product_type_table cannot be reverted.\n";

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
