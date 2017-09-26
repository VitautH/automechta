<?php

use yii\db\Schema;
use yii\db\Migration;

class m160209_170041_add_groups_to_specifications_i18n extends Migration
{
    public function up()
    {
        $this->addColumn('specification_i18n', 'group_name', $this->string());
    }

    public function down()
    {
        echo "m160209_170041_add_groups_to_specifications_i18n cannot be reverted.\n";

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
