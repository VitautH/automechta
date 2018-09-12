<?php
namespace common\models;

use Yii;
use yii\db\Query;

class AutoBody extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_body';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body_name', 'url','description'], 'string'],
        ];
    }
}