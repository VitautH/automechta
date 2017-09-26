<?php

use yii\db\Schema;
use yii\db\Migration;

class m160410_092702_probuct_limit_rule extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $registered = $auth->getRole('Registered');

        $limitRule = new \common\rbac\LimitRule();

        $auth->add($limitRule);

        $permission = $auth->createPermission('createLimitedAmountOfProducts');
        $permission->description = 'Create limited amount of products';
        $permission->ruleName = $limitRule->name;

        $auth->add($permission);

        $auth->addChild($registered, $permission);

        $createProduct = $auth->getPermission('createProduct');
        $auth->addChild($permission, $createProduct);
        $auth->removeChild($registered, $createProduct);

    }

    public function down()
    {
        echo "m160410_092702_probuct_limit_rule cannot be reverted.\n";

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
