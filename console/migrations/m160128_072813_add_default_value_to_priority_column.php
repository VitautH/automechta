<?php

use yii\db\Schema;
use yii\db\Migration;

class m160128_072813_add_default_value_to_priority_column extends Migration
{
    public function up()
    {
        $this->alterColumn('product', 'priority', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160128_072813_add_default_value_to_priority_column cannot be reverted.\n";

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
