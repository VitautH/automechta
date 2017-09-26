<?php

use yii\db\Schema;
use yii\db\Migration;

class m160218_173155_i18n_metadata_fk extends Migration
{
    public function up()
    {
        $this->addForeignKey('FK_MetaData_MetaDataI18N', 'meta_data_i18n', 'parent_id', 'meta_data', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m160218_173155_i18n_metadata_fk cannot be reverted.\n";

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
