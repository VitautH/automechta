<?php

namespace backend\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use  common\models\User;
use common\helpers\Date;
use Yii;

class Tasks extends \yii\db\ActiveRecord
{
    const LOW_PRIORITY = 0;
    const HIGH_PRIORITY = 1;
    const OPEN_STATUS = 0; // Открыта
    const DURING_STATUS = 1; //Выполняется
    const PAUSE_STATUS = 2; //На паузе
    const EXECUTED_STATUS = 3; //Выполнена
    const VEREFIED_STATUS = 4; //Ожидает проверки
    const DRAFT_STATUS = 5; //В карзине
    const CLOSED_STATUS = 6; // Закрыта
    const DECLINE_STATUS = 7; // Отклонена
    const SCENARIO_CREATETASK = 0;
    const SCENARIO_CHANGESTATUS = 1;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_to', 'title', 'execute_date'], 'required', 'on' => self::SCENARIO_CREATETASK],
            [['created_by','created_at','updated_by','updated_at','employee_to', 'status', 'priority'], 'integer'],
            [['title', 'description', 'attach', 'execute_date','comment'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATETASK => [
                'id',
                'status',
                'created_at',
                'created_by',
                'employee_to',
                'title',
                'description',
                'attach',
                'execute_date',
                'priority',
            ],
            self::SCENARIO_CHANGESTATUS => [
                'id',
                'status',
                'created_at',
                'created_by',
                'employee_to',
                'comment'
            ],
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
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->scenario == self::SCENARIO_CREATETASK) {
            $this->execute_date = Date::dateToUnix($this->execute_date);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public static function getPriority()
    {
        return [
            self::LOW_PRIORITY => Yii::t('app', 'LowPriority'),
            self::HIGH_PRIORITY => Yii::t('app', 'HighPriority'),
        ];
    }
}