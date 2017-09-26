<?php

use yii\db\Schema;
use yii\db\Migration;

class m160218_172623_i18n_metadata extends Migration
{
    public function up()
    {
        $this->dropColumn('meta_data', 'value');

        $this->createTable('meta_data_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'value' => $this->text(),
        ]);
    }

    public function down()
    {
        echo "m160218_172623_i18n_metadata cannot be reverted.\n";

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
