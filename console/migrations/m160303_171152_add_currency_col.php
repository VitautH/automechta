<?php

use yii\db\Schema;
use yii\db\Migration;

class m160303_171152_add_currency_col extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'currency', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160303_171152_add_currency_col cannot be reverted.\n";

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
