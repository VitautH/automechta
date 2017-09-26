<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_type_specifications".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $specification
 *
 * @property Specification $specification0
 * @property ProductType $type0
 */
class ProductTypeSpecifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_type_specifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'specification'], 'required'],
            [['type', 'specification'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'specification' => Yii::t('app', 'Specification'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecification0()
    {
        return $this->hasOne(Specification::className(), ['id' => 'specification']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type']);
    }
}
