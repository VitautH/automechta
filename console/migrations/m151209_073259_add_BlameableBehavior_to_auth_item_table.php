<?php

use yii\db\Schema;
use yii\db\Migration;

class m151209_073259_add_BlameableBehavior_to_auth_item_table extends Migration
{
    public function up()
    {
        $this->addColumn('auth_item', 'created_by', $this->integer());
        $this->addColumn('auth_item', 'updated_by', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('auth_item', 'created_by');
        $this->dropColumn('auth_item', 'updated_by');
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
