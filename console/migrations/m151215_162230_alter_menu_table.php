<?php

use yii\db\Schema;
use yii\db\Migration;

class m151215_162230_alter_menu_table extends Migration
{
    public function up()
    {
        $this->alterColumn('menu', 'created_at', $this->integer());
        $this->alterColumn('menu', 'updated_at', $this->integer());
        $this->alterColumn('menu', 'created_by', $this->integer());
        $this->alterColumn('menu', 'updated_by', $this->integer());
    }

    public function down()
    {
        $this->alterColumn('menu', 'created_at', $this->integer()->notNull());
        $this->alterColumn('menu', 'updated_at', $this->integer()->notNull());
        $this->alterColumn('menu', 'created_by', $this->integer()->notNull());
        $this->alterColumn('menu', 'updated_by', $this->integer()->notNull());
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
