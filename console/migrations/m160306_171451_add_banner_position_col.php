<?php

use yii\db\Schema;
use yii\db\Migration;

class m160306_171451_add_banner_position_col extends Migration
{
    public function up()
    {
        $this->addColumn('slider', 'text_position', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160306_171451_add_banner_position_col cannot be reverted.\n";

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
