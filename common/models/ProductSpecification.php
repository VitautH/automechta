<?php

namespace common\models;

use backend\models\forms\Specification as SpecificationForm;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "product_specification".
 *
 * @property integer $id
 * @property integer $specification_id
 * @property integer $product_id
 * @property string $value
 * @property string $extra_value
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Product $product
 * @property Specification $specification
 */
class ProductSpecification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_specification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['specification_id'], 'required'],
            ['value', 'number', 'when' => function ($model) {
                $specification = $model->getSpecification()->one();
                return ($specification->type == Specification::TYPE_NUMERIC);
            }, 'whenClient' => "function (attribute, value) {
                return false;
            }"],
            ['value', 'required', 'when' => function ($model) {
                $specification = $model->getSpecification()->one();
                return ($specification->required == 1);
            }, 'whenClient' => "function (attribute, value) {
                return false;
            }"],
            ['value', function ($attribute, $params) {
                $specification = $this->getSpecification()->one();
                if ($specification->max_length && strlen($this->$attribute) > $specification->max_length) {
                    $error = Yii::t(
                        'app',
                        'Should contain at most {max, number} {max, plural, one{character} other{characters}}.',
                        ['max' => $specification->max_length]
                    );
                    $this->addError($attribute, $error);
                }
            }],
            [['specification_id', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['value', 'extra_value'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'specification_id' => Yii::t('app', 'Specification ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'value' => Yii::t('app', 'Value'),
            'extra_value' => Yii::t('app', 'Extra Value'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecification()
    {
        return $this->hasOne(Specification::className(), ['id' => 'specification_id']);
    }

    /**
     * @inheritdoc
     * @return ProductSpecificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductSpecificationQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getFormattedValue()
    {
        $spec = $this->getSpecification()->one();
        $value = $this->value;
        if (is_numeric($this->value)) {
            $value = Yii::$app->formatter->asDecimal($this->value);
        }
        if ($spec->type == Specification::TYPE_BOOLEAN) {
            $value = $value === '1' ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
        }
        return $value;
    }
}
