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


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id','region_id'], 'integer'],
            [['name','region_id'], 'required'],
            [['name', 'description'], 'string'],
            [['logo'], 'safe'],
        ];
    }
}