<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slider_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $title
 * @property string $header
 * @property string $caption
 * @property string $button_text
 *
 * @property Slider $parent
 */
class SliderI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['title', 'header', 'caption', 'button_text'], 'string'],
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
            'title' => Yii::t('app', 'Title'),
            'header' => Yii::t('app', 'Header'),
            'caption' => Yii::t('app', 'Caption'),
            'button_text' => Yii::t('app', 'Button Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Slider::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return SliderI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SliderI18nQuery(get_called_class());
    }
}
