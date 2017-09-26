<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_171846_remove_empty_models extends Migration
{
    public function up()
    {
        $this->delete('product_make', 'name=:name', [':name'=>'Любая']);
    }

    public function down()
    {
        echo "m160214_171846_remove_empty_models cannot be reverted.\n";

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
