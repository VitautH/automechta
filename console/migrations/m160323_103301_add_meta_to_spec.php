<?php

use yii\db\Migration;

class m160323_103301_add_meta_to_spec extends Migration
{
    public function up()
    {
        $this->addColumn('specification', 'in_meta', $this->integer()->defaultValue(0));
    }

    public function down()
    {
    }
}
