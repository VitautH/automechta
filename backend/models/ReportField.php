<?php

namespace backend\models;

use common\models\AuthItem;
use yii\db\Query;
use Yii;
use dastanaron\translit\Translit;

class ReportField extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_field', 'slug_field'], 'string'],
            [['name_field'], 'required'],
            [['role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name_field' => 'Имя поля',
        ];
    }

    public function beforeSave($insert)
    {
        $translit = new Translit();
        $this->slug_field = mb_strtolower($translit->translit($this->name_field, true, 'ru-en'));

        return parent::beforeSave($insert);
    }

    public static function getAdminRoles()
    {
        $query = (new Query())->select('name, id')->from(AuthItem::tableName())->where(['is_administrator' => 1])->indexBy('id');
        $roles = $query->all();

        $result = array();
        foreach ($roles as $role) {
            $result[$role['id']] = Yii::t('app', $role['name']);
        }

        return $result;
    }
}