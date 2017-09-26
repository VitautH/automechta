<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "main_page_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $data_val
 * @property string $data_val_ext
 *
 * @property MainPage $parent
 */
class MainPageI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_page_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['data_val', 'data_val_ext'], 'string'],
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
            'data_val' => Yii::t('app', 'Data Val'),
            'data_val_ext' => Yii::t('app', 'Data Val Ext'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MainPage::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return MainPageI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MainPageI18nQuery(get_called_class());
    }
}
