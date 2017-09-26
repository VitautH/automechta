<?php

use yii\db\Schema;
use yii\db\Migration;

class m160125_130853_add_values_column_to_specification_i18n_table extends Migration
{
    public function up()
    {
        $this->addColumn('specification_i18n', 'values', $this->text());
        $this->dropColumn('specification', 'values');
    }

    public function down()
    {
        echo "m160125_130853_add_values_column_to_specification_i18n_table cannot be reverted.\n";

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
