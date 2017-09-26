<?php

use yii\db\Schema;
use yii\db\Migration;

class m160121_162519_create_slider_table extends Migration
{
    public function up()
    {
        $this->createTable('slider', [
            'id' => $this->primaryKey(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'link' => $this->string(256)->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createTable('slider_i18n', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(32),
            'title' => $this->text(),
            'header' => $this->text(),
            'caption' => $this->text(),
            'button_text' => $this->text(),
        ]);

        $this->addForeignKey('FK_Slider_SliderI18N', 'slider_i18n', 'parent_id', 'slider', 'id', 'CASCADE', 'CASCADE');

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('Administrator');
        $guest = $auth->getRole('Guest');
        $registered = $auth->getRole('Registered');
        $registeredUnconfirmed = $auth->getRole('RegisteredUnconfirmed');

        $permissions = [
            'viewSlider' => [
                'description' => 'View slider data',
                'roles' => [$guest, $admin, $registered, $registeredUnconfirmed],
                'rules' => [],
            ],
            'createSlider' => [
                'description' => 'Create slider',
                'roles' => [$admin],
                'rules' => [],
            ],
            'updateSlider' => [
                'description' => 'Update slider',
                'roles' => [$admin],
                'rules' => [],
            ],
            'deleteSlider' => [
                'description' => 'Delete slider',
                'roles' => [$admin],
                'rules' => [],
            ],
        ];

        foreach ($permissions as $permissionName => $permissionData) {
            $permission = $auth->createPermission($permissionName);

            if (isset($permissionData['description']) ) {
                $permission->description = $permissionData['description'];
            }

            if (isset($permissionData['rules']) ) {
                foreach ($permissionData['rules'] as $rule) {
                    $permission->ruleName = $rule->name;
                }
            }

            $auth->add($permission);

            if (isset($permissionData['roles']) ) {
                foreach ($permissionData['roles'] as $role) {
                    $auth->addChild($role, $permission);
                }
            }
        }
    }

    public function down()
    {
        echo "m160121_162519_create_slider_table cannot be reverted.\n";

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
