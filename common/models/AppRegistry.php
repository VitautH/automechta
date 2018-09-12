<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 12.02.2018
 * Time: 15:44
 */

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class AppRegistry extends \yii\db\ActiveRecord
{
    /**
     * @var array
     */
    public static $fields = [
        'phone_credit_number' => [
            'field_type' => 'input',
            'visibility' => 'credit_page',
            'label' => 'Кредитный телефон',
        ],
        'phone_credit_provider' => [
            'field_type' => 'input',
            'visibility' => 'credit_page',
            'label' => 'Оператор кредитный телефон',
        ],
        'credit_bank' => [
            'credit_bank_name' => [
                'data_key' => 'credit_bank',
                'field_type' => 'input',
                'visibility' => 'credit_page',
                'label' => 'Название банка',
            ],
            'credit_bank_value' => [
                'data_key' => 'credit_bank',
                'field_type' => 'input',
                'visibility' => 'credit_page',
                'label' => 'Процентная ставка',
            ],
        ],
    ];
    public $type;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_registry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visibility', 'type', 'data_key', 'data_value'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'data_key' => Yii::t('app', 'Key'),
            'data_val' => Yii::t('app', 'Value'),
            'visibility' => 'Отображение на странице',
            'type' => 'Тип данных',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ]
        ];
    }

    /**
     * @return AppData[]
     */
    public static function getModelsName()
    {
        return (new \ReflectionClass(get_called_class()))->getShortName();
    }

    /**
     * @throws \Exception
     */
    public static function cleanData()
    {
        $models = self::find()->all();
        foreach ($models as $model) {
            if (!isset(self::$fields[$model->data_key])) {
                $model->delete();
            }
        }
    }
}