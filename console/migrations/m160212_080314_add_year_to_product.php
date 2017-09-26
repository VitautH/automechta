<?php

use yii\db\Schema;
use yii\db\Migration;

class m160212_080314_add_year_to_product extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'year', $this->integer(4)->notNull());
    }

    public function down()
    {
        echo "m160212_080314_add_year_to_product cannot be reverted.\n";

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
