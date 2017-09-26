<?php

use yii\db\Migration;

class m160323_105951_static_page_in_aside_menu extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'in_aside', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160323_105951_static_page_in_aside_menu cannot be reverted.\n";

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
