<?php

use yii\db\Schema;
use yii\db\Migration;

class m151117_101622_add_columns_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'first_name', $this->string(255));
        $this->addColumn('user', 'last_name', $this->string(255));
        $this->addColumn('user', 'middle_name', $this->string(255));
        $this->addColumn('user', 'patronymic', $this->string(255));
        $this->addColumn('user', 'last_visit', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'middle_name');
        $this->dropColumn('user', 'patronymic');
        $this->dropColumn('user', 'last_visit');
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
