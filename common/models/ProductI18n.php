<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_i18n".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $title
 * @property string $seller_comments
 *
 * @property Product $parent
 */
class ProductI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['seller_comments'], 'string', 'max' => 2000],
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
            'title' => Yii::t('app', 'Version/Modification'),
            'seller_comments' => Yii::t('app', 'Seller Comments'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Product::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return ProductI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductI18nQuery(get_called_class());
    }
}
