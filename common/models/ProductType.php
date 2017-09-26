<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * This is the model class for table "product_type".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Product[] $products
 * @property ProductTypeI18n[] $productTypeI18ns
 * @property ProductTypeSpecifications[] $productTypeSpecifications
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => I18nBehavior::className(),
                'i18nModel' => '\common\models\ProductTypeI18n',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypeI18ns()
    {
        return $this->hasMany(ProductTypeI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypeSpecifications()
    {
        return $this->hasMany(ProductTypeSpecifications::className(), ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSpecificationIds()
    {
        $query = new Query();
        $query->select('specification')->from('product_type_specifications')->where('type=:type')->indexBy('specification');
        $query->params([':type' => $this->id]);
        return $query->column();
    }

    /**
     * @inheritdoc
     * @return ProductTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductTypeQuery(get_called_class());
    }

    /**
     * Get root node or create if not exists
     * @return Slider
     */
    public static function getRoot()
    {
        $root = self::find()->root()->one();
        if ($root === null) {
            $root = new self();
            $root->id = 0;
            $root->makeRoot();
        }
        return $root;
    }

    /**
     * Get list of types where key is type `id` and value is name of type according to current language.
     * @return array
     */
    public static function getTypesAsArray()
    {
        $types = self::find()->where('depth>0')->all();
        $result = [];

        foreach ($types as $type) {
            $result[$type->id] = $type->i18n()->name;
        }

        return $result;
    }
    public static function getTypeAsArray($type)
    {
        $types = self::find()->where(['id'=>$type])->all();
        $result = [];

        foreach ($types as $type) {
            $result[$type->id] = $type->i18n()->name;
        }

        return $result;
    }
}
