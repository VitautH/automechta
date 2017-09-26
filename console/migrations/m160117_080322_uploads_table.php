<?php

use yii\db\Schema;
use yii\db\Migration;

class m160117_080322_uploads_table extends Migration
{
    public function up()
    {
        $this->createTable(
            'uploads',
            [
                'id' => $this->primaryKey(),
                'linked_table' => $this->string(256),
                'linked_id' => $this->integer(),
                'type' => $this->integer(),
                'status' => $this->integer(),
                'name' => $this->string(256),
                'hash' => $this->string(256),
                'extension' => $this->string(256),
                'size' => $this->integer(),
                'mime_type' => $this->string(256),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ]
        );
    }

    public function down()
    {
        $this->dropTable('uploads');

        echo "m160117_080322_uploads_table cannot be reverted.\n";

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
