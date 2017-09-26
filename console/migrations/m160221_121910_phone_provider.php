<?php

use yii\db\Schema;
use yii\db\Migration;

class m160221_121910_phone_provider extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'phone_provider', $this->integer());
    }

    public function down()
    {
        echo "m160221_121910_phone_provider cannot be reverted.\n";

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
