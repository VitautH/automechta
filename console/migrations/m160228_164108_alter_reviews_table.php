<?php

use yii\db\Schema;
use yii\db\Migration;

class m160228_164108_alter_reviews_table extends Migration
{
    public function up()
    {
        $this->addColumn('reviews', 'rating', $this->integer());
        $this->dropColumn('reviews_i18n', 'rating');
    }

    public function down()
    {
        echo "m160228_164108_alter_reviews_table cannot be reverted.\n";

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
