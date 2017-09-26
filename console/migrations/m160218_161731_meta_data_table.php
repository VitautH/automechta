<?php

use yii\db\Schema;
use yii\db\Migration;

class m160218_161731_meta_data_table extends Migration
{
    public function up()
    {
        $this->createTable(
            'meta_data',
            [
                'id' => $this->primaryKey(),
                'linked_table' => $this->string(256),
                'linked_id' => $this->integer(),
                'type' => $this->integer(),
                'value' => $this->string(256),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ]
        );
    }

    public function down()
    {
        echo "m160218_161731_meta_data_table cannot be reverted.\n";

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
