<?php

use yii\db\Migration;

class m160219_124738_add_confirmation_col extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'confirm_key', $this->string(256));
        $this->addColumn('user', 'phone', $this->string(256));
        $this->addColumn('user', 'city', $this->string(256));
        $this->addColumn('user', 'address', $this->string(256));
    }

    public function down()
    {
        echo "m160219_124738_add_confirmation_col cannot be reverted.\n";

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
