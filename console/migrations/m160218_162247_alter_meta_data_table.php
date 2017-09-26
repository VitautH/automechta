<?php

use yii\db\Schema;
use yii\db\Migration;

class m160218_162247_alter_meta_data_table extends Migration
{
    public function up()
    {
        $this->alterColumn('meta_data', 'value', $this->text());
    }

    public function down()
    {
        echo "m160218_162247_alter_meta_data_table cannot be reverted.\n";

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
