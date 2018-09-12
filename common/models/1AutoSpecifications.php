<?php
namespace common\models;


class AutoSpecifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_specifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id','region_id'], 'integer'],
            [['model', 'make', 'years','modification','specifications'], 'string'],
        ];
    }
}