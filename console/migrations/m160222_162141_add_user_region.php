<?php

use yii\db\Schema;
use yii\db\Migration;

class m160222_162141_add_user_region extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'region', $this->integer());
    }

    public function down()
    {
        echo "m160222_162141_add_user_region cannot be reverted.\n";

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
