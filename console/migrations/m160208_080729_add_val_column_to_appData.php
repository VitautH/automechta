<?php

use yii\db\Schema;
use yii\db\Migration;

class m160208_080729_add_val_column_to_appData extends Migration
{
    public function up()
    {
        $this->addColumn('app_data', 'data_val', $this->text());
    }

    public function down()
    {
        echo "m160208_080729_add_val_column_to_appData cannot be reverted.\n";

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
