<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use common\models\behaviors\UploadsBehavior;

/**
 * This is the model class for table "specification".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $direction
 * @property integer $required
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $group
 * @property integer $priority
 * @property integer $in_search
 * @property integer $in_meta
 * @property integer $max_length
 *
 * @property ProductTypeSpecifications[] $productTypeSpecifications
 * @property SpecificationI18n[] $specificationI18ns
 */
class Specification extends \yii\db\ActiveRecord
{
//    const TYPE_CHECKBOX_LIST = 1;
    const TYPE_DROP_DOWN = 2;
    const TYPE_NUMERIC = 3;
//    const TYPE_RANGE = 4;
    const TYPE_TEXT = 5;
    const TYPE_BOOLEAN = 6;

    const PRIORITY_NORMAL = 0;
    const PRIORITY_HIGH = 1;
    const PRIORITY_HIGHEST = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'direction', 'required', 'created_at', 'updated_at', 'created_by', 'updated_by', 'lft', 'rgt', 'depth', 'priority', 'in_search', 'in_meta', 'max_length'], 'integer'],
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
            'direction' => Yii::t('app', 'Direction'),
            'required' => Yii::t('app', 'Required'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'priority' => Yii::t('app', 'Priority'),
            'in_search' => Yii::t('app', 'In Search'),
            'max_length' => Yii::t('app', 'Max Length'),
            'in_meta' => Yii::t('app', 'In metadata'),
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
                'i18nModel' => '\common\models\SpecificationI18n',
            ],
            [
                'class' => UploadsBehavior::className(),
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
    public function getProductTypeSpecifications()
    {
        return $this->hasMany(ProductTypeSpecifications::className(), ['specification' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecificationI18ns()
    {
        return $this->hasMany(SpecificationI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SpecificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecificationQuery(get_called_class());
    }

    /**
     * Get list of types
     * @return array
     */
    public static function getTypes()
    {
        return [
//            self::TYPE_CHECKBOX_LIST => Yii::t('app', 'Checkbox list'),
            self::TYPE_DROP_DOWN => Yii::t('app', 'Drop down'),
            self::TYPE_NUMERIC => Yii::t('app', 'Numeric'),
//            self::TYPE_RANGE => Yii::t('app', 'Range'),
            self::TYPE_TEXT => Yii::t('app', 'Text'),
            self::TYPE_BOOLEAN => Yii::t('app', 'Boolean'),
        ];
    }

    /**
     * Get root node or create if not exists
     * @return Slider
     */
    public static function getRoot()
    {
        $root = self::find()->root()->one();
        if ($root === null) {
            $root = new self(['type' => self::TYPE_BOOLEAN]);
            $root->id = 0;
            $root->makeRoot();
        }
        return $root;
    }

    /**
     * @return array
     */
    public static function getPriorities()
    {
        return [
            self::PRIORITY_NORMAL => Yii::t('app', 'Normal priority'),
            self::PRIORITY_HIGH => Yii::t('app', 'High priority'),
            self::PRIORITY_HIGHEST => Yii::t('app', 'Highest priority'),
        ];
    }
}
