<?php

use yii\db\Schema;
use yii\db\Migration;

class m160209_165806_add_groups_to_specifications extends Migration
{
    public function up()
    {
        $this->addColumn('specification', 'group', $this->string());
        $this->addColumn('specification', 'priority', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160209_165806_add_groups_to_specifications cannot be reverted.\n";

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
