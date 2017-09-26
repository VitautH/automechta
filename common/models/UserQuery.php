<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 14.11.2015
 * Time: 15:15
 */

namespace common\models;


class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return AuthItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AuthItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}