<?php

use yii\db\Schema;
use yii\db\Migration;

class m160410_074855_add_make_type_col extends Migration
{
    public function up()
    {
        $this->addColumn('product_make', 'product_type', $this->integer());
        $this->addForeignKey('FK_ProductType_ProductMake', 'product_make', 'product_type', 'product_type', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m160410_074855_add_make_type_col cannot be reverted.\n";

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
