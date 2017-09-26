<?php

use yii\db\Schema;
use yii\db\Migration;

class m160321_162655_main_page_table extends Migration
{
    public function up()
    {
        $this->createTable('main_page', [
            'id' => $this->primaryKey(),
            'data_key' => $this->string()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'data_val' => $this->text(),
        ]);

        $this->createTable('main_page_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'data_val' => $this->text(),
            'data_val_ext' => $this->text(),
        ]);

        $this->addForeignKey('FK_MainPage_MainPageI18N', 'main_page_i18n', 'parent_id', 'main_page', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m160321_162655_main_page_table cannot be reverted.\n";

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
