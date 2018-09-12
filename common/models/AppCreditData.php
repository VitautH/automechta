<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 08.02.2018
 * Time: 14:03
 */

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use common\models\behaviors\UploadsBehavior;
use yii\helpers\Url;

class AppCreditData extends \yii\db\ActiveRecord
{
    public  $phone_credit_provider_1;
    public $phone_credit_provider_2;
    public $phone_credit_provider_3;
    public $phone_credit_number_1;
    public $phone_credit_number_2;
    public $phone_credit_number_3;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_credit_data';
    }

}