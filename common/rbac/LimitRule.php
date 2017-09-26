<?php

namespace common\rbac;

use yii\rbac\Rule;
use yii\db\ActiveRecord;

/**
 */
class LimitRule extends Rule
{
    public $name = 'limit';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
         if (!$user) {
             return false;
         }
        /* @var ActiveRecord $model */
        $model = $params['model'];
        $limit = $params['limit'];
        $number = $model::find()->where('created_by='.$user)->count();

        return $number < $limit;
    }
}