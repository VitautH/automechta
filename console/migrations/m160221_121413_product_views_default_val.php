<?php

use yii\db\Schema;
use yii\db\Migration;

class m160221_121413_product_views_default_val extends Migration
{
    public function up()
    {
        $this->alterColumn('product', 'views', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160221_121413_product_views_default_val cannot be reverted.\n";

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
