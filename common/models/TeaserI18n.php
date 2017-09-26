<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teaser_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $title
 * @property string $header
 * @property string $caption
 * @property string $button_text
 *
 * @property Teaser $parent
 */
class TeaserI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teaser_i18n';
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
        return $this->hasOne(Teaser::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return TeaserI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeaserI18nQuery(get_called_class());
    }
}
