<?php

use yii\db\Schema;
use yii\db\Migration;

class m160125_104206_add_values_column_to_specification_table extends Migration
{
    public function up()
    {
        $this->addColumn('specification', 'values', $this->text());
    }

    public function down()
    {
        echo "m160125_104206_add_values_column_to_specification_table cannot be reverted.\n";

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
