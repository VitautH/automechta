<?php

use yii\db\Schema;
use yii\db\Migration;

class m151213_131711_create_menu_table extends Migration
{
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'route' => $this->string(256)->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'permission' => $this->string(256),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createTable('menu_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'name' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('menu');
        $this->dropTable('menu_i18n');
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
