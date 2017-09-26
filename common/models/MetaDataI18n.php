<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meta_data_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $value
 */
class MetaDataI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meta_data_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['value'], 'string'],
            [['value'], 'trim'],
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
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     * @return MetaDataI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetaDataI18nQuery(get_called_class());
    }
}
