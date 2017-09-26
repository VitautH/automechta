<?php

use yii\db\Migration;

class m160215_095226_add_views_col_to_page extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'views', $this->integer()->defaultValue(0));
    }

    public function down()
    {
    }
}
