<?php

namespace common\models;

use common\models\AutoModifications;

class AutoModification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_modification';
    }

    public function getModification (){
        return $this->hasMany(AutoModifications::className(), ['modification_id' => 'id']);
    }
}