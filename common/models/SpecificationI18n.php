<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "specification_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $name
 * @property string $unit
 * @property string $example
 * @property string $comment
 * @property string $values
 *
 * @property Specification $parent
 */
class SpecificationI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specification_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name', 'unit', 'example', 'comment', 'values'], 'string'],
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
            'unit' => Yii::t('app', 'Unit'),
            'example' => Yii::t('app', 'Example'),
            'comment' => Yii::t('app', 'Comment'),
            'values' => Yii::t('app', 'Values'),
        ];
    }

    /**
     * Get decoded values
     * @return array
     */
    public function getValuesArray()
    {
        $values = $this->values;

        try {
            $values = Json::decode($values, true);
        } catch (\Exception $e) {
            $values = [];
        }

        if ($values === null || $values === '') {
            $values = [];
        }
        return $values;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Specification::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return SpecificationI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecificationI18nQuery(get_called_class());
    }
}
