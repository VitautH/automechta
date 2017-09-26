<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $name
 */
class MenuI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string'],
            [['language'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'language' => Yii::t('app', 'Language'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     * @return MenuI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuI18nQuery(get_called_class());
    }
}
