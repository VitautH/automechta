<?php
namespace common\models;

use Yii;
use yii\db\Query;
use common\models\AutoRegions;

class AutoMakes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_makes';
    }

    public function getMakes(){
        return $this->hasMany(AutoRegions::className(), ['region_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['parent_id','region_id'], 'integer'],
//            [['name'], 'required'],
//            [['name', 'description'], 'string'],
//        ];
//    }
}