<?php

use yii\db\Schema;
use yii\db\Migration;

class m160303_164520_add_exchange_field_to_product extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'exchange', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160303_164520_add_exchange_field_to_product cannot be reverted.\n";

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
