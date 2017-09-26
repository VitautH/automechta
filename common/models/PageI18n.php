<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $header
 * @property string $description
 * @property string $content
 *
 * @property Page $parent
 */
class PageI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['header'], 'required'],
            [['header', 'description', 'content'], 'string'],
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
            'header' => Yii::t('app', 'Header'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return PageI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageI18nQuery(get_called_class());
    }
}
