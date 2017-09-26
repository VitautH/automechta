<?php

use yii\db\Schema;
use yii\db\Migration;

class m160222_164007_add_user_second_phone extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'phone_2', $this->string(256));
        $this->addColumn('user', 'phone_provider_2', $this->integer());
    }

    public function down()
    {
        echo "m160222_164007_add_user_second_phone cannot be reverted.\n";

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
