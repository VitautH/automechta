<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 27.09.2017
 * Time: 15:37
 */

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use yii\db\Query;
use yii\helpers\Url;
use yii\helpers\Json;

class Complaint extends \yii\db\ActiveRecord
{
    const UNVIEWED = 0;
    const VIEWED = 1;
    public static $type_comlaint = ['not_actual' => 'Объявление не актуально', 'wrong_number' => 'Номер указан не верно'
        , 'wrong_address' => 'Адрес указан не верно', 'duplication' => 'Дублирование объявлений', 'other' => 'Иное',];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'product_id' => '№ объявления',
            'complaint_type' => 'Тип жалобы',
            'complaint_text' => 'Комментарий',
        ];
    }
}