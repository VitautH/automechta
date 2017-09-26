<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Query;

/**
 * This is the model class for table "product_make".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $product_type
 *
 * @property Product[] $products
 */
class ProductMake extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_make';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['name'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'lft', 'rgt', 'depth', 'product_type'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'id' => Yii::t('app', 'ID'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'product_type' => Yii::t('app', 'Product type'),
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            'BlameableBehavior' => [
                'class' => BlameableBehavior::className(),
            ],
            'tree' => [
                'class' => NestedSetsBehavior::className(),
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
        return $this->hasMany(Product::className(), ['make' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductMakeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductMakeQuery(get_called_class());
    }

    /**
     * Get list of makes indexed by id
     * @param integer $type
     * @return array
     */
    public static function getMakesList($type = null)
    {
        $query = (new Query())->select('name, id')->from('product_make')->where('depth=1')->indexBy('id');
        if ($type !== null) {
            $type = intval($type);
            $query->andWhere('product_type=:product_type', [':product_type'=>$type]);
        }
        return $query->column();
    }
    public static function getMakeList($type)
    {
        $query = (new Query())->select('name, id')->from('product_make')->where(['id'=>$type])->indexBy('id');
        return $query->column();
    }
    /**
     * Get array of makes with id
     * @param integer $type
     * @param integer $hasProducts (if true returns only makers, which have products)
     * @return array
     */
    public static function getMakesListWithId($type = null, $hasProducts = null)
    {
        $query = (new Query())->select('product_make.name, product_make.id')->from('product_make')->where('depth=1')->indexBy('id');
        if ($type !== null) {
            $type = intval($type);
            $query->andWhere('product_type=:product_type', [':product_type'=>$type]);
        }
        if ($hasProducts) { 
            $query->join('INNER JOIN','product', 'product_make.id = product.make')->andWhere('product.status=1');
        }
        return $query->all();
    }

    /**
     * Get list of makes indexed by id
     * @return array
     */
    public static function getModelsList($makeId)
    {
        $result = [];
        $make = ProductMake::find()->where('id=:id', [':id' => $makeId])->one();
        if ($make !== null) {
            $result = (new Query())->select('name, id')
                ->from('product_make')
                ->where('depth=2 AND lft>:lft AND rgt<:rgt', [':lft' => $make->lft, ':rgt' => $make->rgt])
                ->indexBy('name')->column();
        }
        return $result;
    }

    /**
     * Get array of with id
     * @return array
     */
    public static function getModelsListWithId($makeId, $type, $hasProducts = null)
    {
        $result = [];
        $make = ProductMake::find()->where('id=:id AND product_type=:type', [':id' => $makeId, ':type' => $type])->one();
        if ($make !== null) {
            $query = (new Query())->select('product_make.name, product_make.id')
                ->from('product_make')
                ->where('depth=2 AND lft>:lft AND rgt<:rgt AND product_type=:type', [':lft' => $make->lft, ':rgt' => $make->rgt, ':type' => $type])
                ->indexBy('name');
            if ($hasProducts) { 
                $query->join('INNER JOIN','product', 'product_make.name = product.model')->andWhere('product.type=:type')->andWhere('product.status=1');
            }
            $result= $query->all();
        }
        return $result;
    }


    /**
     * Get root node or create if not exists
     * @return ProductMake
     */
    public static function getRoot()
    {
        $root = self::find()->root()->one();
        if ($root === null) {
            $root = new self([
                'name'=>'root',
            ]);
            $root->id = '0';
            $root->created_by = '0';
            $root->updated_by = '0';
            $root->makeRoot();
        }
        return $root;
    }

}
