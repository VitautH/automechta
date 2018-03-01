<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use DateTime;
use Yii;

/**
 * This is the model class for table "credit_application".
 *
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property string $phone
 * @property string $dob
 * @property integer $sex
 * @property integer $family_status
 * @property integer $previous_conviction
 * @property string $job
 * @property string $experience
 * @property integer $salary
 * @property integer $loans_payment
 * @property string $product
 * @property string $credit_amount
 * @property string $term
 * @property string $information_on_income
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class CreditApplication extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;
    const STATUS_CREATE_BY_MANAGER = 3;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    const FAMILY_STATUS_MARRIED = 1;
    const FAMILY_STATUS_SINGLE = 2;

    const CONVICTION_NO = 1;
    const CONVICTION_YES = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'credit_application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sex', 'family_status', 'previous_conviction', 'salary', 'loans_payment', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['phone'], 'required'],
            [['name', 'firstname', 'dob', 'sex', 'family_status', 'job', 'experience', 'salary', 'loans_payment', 'product', 'credit_amount', 'term', 'date_arrive','information_on_income'], 'safe'],
            [['name', 'lastname', 'firstname', 'job', 'experience', 'product', 'credit_amount', 'information_on_income'], 'string'],
            [['phone', 'dob', 'term', 'note'], 'string', 'max' => 256],
            ['phone', 'string', 'min' => 9, 'message' => 'Телефон должен содержать минимум 9 символа.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'name' => Yii::t('app', 'Name'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'phone' => Yii::t('app', 'Phone'),
            'dob' => Yii::t('app', 'Dob'),
            'sex' => Yii::t('app', 'Sex'),
            'family_status' => Yii::t('app', 'Family Status'),
            'previous_conviction' => Yii::t('app', 'Previous Conviction'),
            'job' => Yii::t('app', 'Job'),
            'experience' => Yii::t('app', 'Experience'),
            'salary' => Yii::t('app', 'Salary'),
            'loans_payment' => Yii::t('app', 'Loans Payment'),
            'product' => Yii::t('app', 'Product'),
            'credit_amount' => Yii::t('app', 'Credit Amount'),
            'term' => Yii::t('app', 'Term'),
            'information_on_income' => Yii::t('app', 'Information On Income'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'note' => Yii::t('app', 'Заметка'),
            'date_arrive' => Yii::t('app', 'Дата приезда'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            'BlameableBehavior' => [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }


  public static function dateToUnix($date){
      $date = new DateTime($date);

      return $date->getTimestamp();
  }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PUBLISHED => Yii::t('app', 'New'),
            self::STATUS_UNPUBLISHED => Yii::t('app', 'Viewed'),
        ];
    }

    /**
     * @return array
     */
    public static function getSexList()
    {
        return [
            self::SEX_MALE => Yii::t('app', 'Male'),
            self::SEX_FEMALE => Yii::t('app', 'Female'),
        ];
    }

    /**
     * @return array
     */
    public static function getFamilyStatueList()
    {
        return [
            self::FAMILY_STATUS_MARRIED => Yii::t('app', 'Married'),
            self::FAMILY_STATUS_SINGLE => Yii::t('app', 'Single'),
        ];
    }

    /**
     * @return array
     */
    public static function getConvictionList()
    {
        return [
            self::CONVICTION_NO => Yii::t('app', 'Yes'),
            self::CONVICTION_YES => Yii::t('app', 'No'),
        ];
    }

    /**
     * @return array
     */
    public static function getInformationOnIncomeList()
    {
        return [
            self::CONVICTION_YES => Yii::t('app', 'No'),
            self::CONVICTION_NO => Yii::t('app', 'Yes'),
        ];
    }

    /**
     * @return array
     */
    public static function getTermList()
    {

        return [
            '6m' => Yii::t('app', '6 month'),
            '12m' => Yii::t('app', 'One year'),
            '24m' => Yii::t('app', '2 years'),
            '36m' => Yii::t('app', '3 years'),
            '48m' => Yii::t('app', '4 years'),
            '60m' => Yii::t('app', '5 years'),
        ];
    }

    /**
     * @inheritdoc
     * @return CreditApplicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CreditApplicationQuery(get_called_class());
    }
}
