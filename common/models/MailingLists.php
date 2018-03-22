<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\Event;
use common\models\AppData;

class MailingLists extends \yii\db\ActiveRecord
{
    const MAILING_EMAIL = 1;
    const MAILING_SMS = 2;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DONE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailing_lists';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['note'], 'string', 'max' => 255],
            [['text'], 'string'],
            [['type', 'status', 'title', 'text'], 'required'],
        ];
    }


    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_INACTIVE => Yii::t('app', 'Не активная'),
            self::STATUS_ACTIVE => Yii::t('app', 'Активная'),
            self::STATUS_DONE => Yii::t('app', 'Завершена'),
        ];
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::MAILING_EMAIL => Yii::t('app', 'E-mail'),
            self::MAILING_SMS => Yii::t('app', 'SMS'),
        ];
    }
}