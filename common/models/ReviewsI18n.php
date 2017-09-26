<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reviews_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $person
 * @property string $header
 * @property string $content
 *
 * @property Reviews $parent
 */
class ReviewsI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['person', 'header', 'content'], 'string'],
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
            'person' => Yii::t('app', 'Person'),
            'header' => Yii::t('app', 'Header'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Reviews::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return ReviewsI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewsI18nQuery(get_called_class());
    }
}
