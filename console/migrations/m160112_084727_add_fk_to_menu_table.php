<?php

use yii\db\Schema;
use yii\db\Migration;

class m160112_084727_add_fk_to_menu_table extends Migration
{
    public function up()
    {
        $this->addForeignKey('FK_Menu_MenuI18N', 'menu_i18n', 'parent_id', 'menu', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('FK_Menu_MenuI18N', 'menu_i18n');
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
