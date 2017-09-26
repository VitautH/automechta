<?php

use yii\db\Schema;
use yii\db\Migration;

class m160125_082023_add_ns_columns_to_specification_table extends Migration
{
    public function up()
    {
        $this->addColumn('specification', 'lft', $this->integer()->notNull());
        $this->addColumn('specification', 'rgt', $this->integer()->notNull());
        $this->addColumn('specification', 'depth', $this->integer()->notNull());
    }

    public function down()
    {
        echo "m160125_082023_add_ns_columns_to_specification_table cannot be reverted.\n";

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
