<?php

namespace common\models;

use common\components\Uploads;
use common\models\Uploads as UploadsModel;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;

/**
 * This is the model class for table "app_data".
 *
 * @property integer $id
 * @property string $data_key
 * @property string $data_val
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property AppDataI18n[] $appDataI18ns
 */
class AppData extends \yii\db\ActiveRecord
{

    /**
     * @var array
     */
    public static $fields = [

            'phone_credit_provider_1' => [
                'data_type'=>'credit_data',
                'i18n' => false,
                'widget' => 'select',
                'label' => 'Оператор кредит. телефон 1',
            ],
            'phone_credit_provider_2' => [
                'data_type'=>'credit_data',
                'i18n' => false,
                'widget' => 'select',
                'label' => 'Оператор кредит. телефон 2',
            ],
            'phone_credit_provider_3' => [
                'data_type'=>'credit_data',
                'i18n' => false,
                'widget' => 'select',
                'label' => 'Оператор кредит. телефон 3',
            ],
            'phone_credit_1' => [
                'data_type'=>'credit_data',
                'i18n' => false,
                'widget' => 'input',
                'label' => 'Кредит. телефон 1',
            ],
            'phone_credit_2' => [
                'data_type'=>'credit_data',
                'i18n' => false,
                'widget' => 'input',
                'label' => 'Кредит. телефон 2',
            ],
            'phone_credit_3' => [
                'data_type'=>'credit_data',
                'i18n' => false,
                'widget' => 'input',
                'label' => 'Кредит. телефон 3',
            ],
        'prior_bank' => [
            'data_type'=> 'main_data',
            'i18n' => false,
            'widget' => 'input',
            'label' => 'Приорбанк %',
        ],
        'vtb_bank' => [
            'data_type'=> 'main_data',
            'i18n' => false,
            'widget' => 'input',
            'label' => 'ВТБ %',
        ],
        'idea_bank' => [
            'data_type'=> 'main_data',
            'i18n' => false,
            'widget' => 'input',
            'label' => 'Идея банк %',
        ],
        'bta_bank' => [
            'data_type'=> 'main_data',
            'i18n' => false,
            'widget' => 'input',
            'label' => 'БТА %',
        ],
        'status_bank' => [
            'data_type'=> 'main_data',
            'i18n' => false,
            'widget' => 'input',
            'label' => 'СтатусБанк %',
        ],

//        'phone' => [
//            'i18n' => false,
//            'data_type'=>'main_data',
//            'widget' => 'input',
//            'label' => 'Phone',
//        ],
//        'phone_2' => [
//            'i18n' => false,
//            'data_type'=>'main_data',
//            'widget' => 'input',
//            'label' => 'Phone 2',
//        ],
//        'phone_3' => [
//            'i18n' => false,
//            'data_type'=>'main_data',
//            'widget' => 'input',
//            'label' => 'Phone 3',
//        ],
        'logoText' => [
            'i18n' => true,
            'data_type'=>'main_data',
            'widget' => 'input',
            'label' => 'Text under logo',
        ],
        'address' => [
            'i18n' => true,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'Address',
        ],
        'email' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'input',
            'label' => 'Email',
        ],
        'adminEmail' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'input',
            'label' => 'Admin Email',
        ],
        'supportEmail' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'input',
            'label' => 'Support Email',
        ],
        'contacts' => [
            'i18n' => true,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'Contacts',
            'options' => ['class' => 'js-wysiwyg']
        ],
//        'openingHours' => [
//            'i18n' => true,
//            'data_type'=>'main_data',
//            'widget' => 'textarea',
//            'label' => 'Opening Hours',
//            'options' => ['class' => 'js-wysiwyg']
//        ],
        'openingHoursFooter' => [
            'i18n' => true,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'Время работы',
            'options' => ['class' => 'js-wysiwyg']
        ],
        'credit_information' => [
            'data_type'=> 'main_data',
            'i18n' => true,
            'widget' => 'textarea',
            'label' => 'Описание по кредиту',
            'options' => ['class' => 'js-wysiwyg']
        ],
//        'aboutUsFooter' => [
//            'i18n' => true,
//            'data_type'=>'main_data',
//            'widget' => 'textarea',
//            'label' => 'About Us Footer',
//            'options' => ['class' => 'js-wysiwyg']
//        ],
        'aboutUsHeader' => [
            'i18n' => true,
            'data_type'=>'main_data',
            'widget' => 'input',
            'label' => 'About Us Header',
        ],
        'aboutUs' => [
            'i18n' => true,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'About Us',
            'options' => ['class' => 'js-wysiwyg']
        ],
        'allAboutCredit' => [
            'i18n' => true,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'All about credit',
            'options' => ['class' => 'js-wysiwyg']
        ],
        'appName' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'Application name',
        ],
        'map' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'Map',
        ],
        'footerMap' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'textarea',
            'label' => 'Map in footer',
        ],
//        'loanRate' => [
//            'i18n' => false,
//            'widget' => 'input',
//            'label' => 'Loan rate, %',
//        ],
        'usdRate' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'input',
            'label' => 'USD rate',
        ],
        'favicon' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'upload',
            'label' => 'Favicon',
            'upload_id' => 1,
        ],
        'logo' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'upload',
            'label' => 'Logo',
            'upload_id' => 2,
        ],
        'headerBackground' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'upload',
            'label' => 'Header background',
            'upload_id' => 3,
        ],
        'aboutUsPhoto' => [
            'i18n' => false,
            'data_type'=>'main_data',
            'widget' => 'upload',
            'label' => 'Photo on page about Us',
            'upload_id' => 4,
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_val'], 'string'],
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
            ],
            [
                'class' => I18nBehavior::className(),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppDataI18ns()
    {
        return $this->hasMany(AppDataI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AppDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppDataQuery(get_called_class());
    }

    /**
     * @return AppData[]
     */
    public static function getModels()
    {
        self::cleanData();
        $models = [];
        foreach (self::$fields as $fieldKey => $fieldData) {
            $model = self::find()->where('data_key=:data_key', [':data_key' => $fieldKey])->one();
            if ($model === null) {
                $model = new self();
                $model->data_key = $fieldKey;
            } else {
                if ($fieldData['i18n']) {
                    //todo create empty values?
                } else {
                    AppDataI18n::deleteAll('parent_id=' . $model->id);
                }
            }
            $models[] = $model;
        }
        return $models;
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

    /**
     * @return array
     */
    public static function getData()
    {
        $result = [];
        $models = self::find()->all();
        foreach ($models as $model) {
            if (self::$fields[$model->data_key]['widget'] === 'upload') {
                $upload = UploadsModel::find()
                    ->where('linked_table=:linked_table AND linked_id=:linked_id')
                    ->params([':linked_table' => $model->tableName(), ':linked_id' => self::$fields[$model->data_key]['upload_id']])
                    ->one();
                $result[$model->data_key] = $upload;
            } else {
                if (self::$fields[$model->data_key]['i18n']) {
                    $result[$model->data_key] = $model->i18n()->data_val;
                } else {
                    $result[$model->data_key] = $model->data_val;
                }
            }
        }

        foreach (array_diff_key(self::$fields, $result) as $emptyDataKey => $emptyDataValue) {
            if (self::$fields[$model->data_key]['widget'] !== 'upload') {
                $result[$emptyDataKey] = '';
            }
        }

        return $result;
    }
}
