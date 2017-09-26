<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_154948_add_in_search_col_to_specification_table extends Migration
{
    public function up()
    {
        $this->addColumn('specification', 'in_search', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160214_154948_add_in_search_col_to_specification_table cannot be reverted.\n";

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
