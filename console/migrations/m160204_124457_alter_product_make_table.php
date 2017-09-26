<?php

use yii\db\Schema;
use yii\db\Migration;

class m160204_124457_alter_product_make_table extends Migration
{
    public function up()
    {
        $this->addColumn('product_make', 'lft', $this->integer()->notNull());
        $this->addColumn('product_make', 'rgt', $this->integer()->notNull());
        $this->addColumn('product_make', 'depth', $this->integer()->notNull());
    }

    public function down()
    {
        echo "m160204_124457_alter_product_make_table cannot be reverted.\n";

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
