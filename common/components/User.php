<?php

namespace common\components;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class User
 *
 * @package common\components
 */
class User extends \yii\web\User
{
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    public function denyAccess($message = null)
    {
        if ($this->getIsGuest()) {
            $this->loginRequired();
        } else {
            $message = $this->getDenyAccessMessage($message);
            throw new ForbiddenHttpException(Yii::t('yii', $message));
        }
    }

    protected function getDenyAccessMessage($message = null)
    {
        if ($message === null) {
            if (!Yii::$app->user->isGuest) {
                $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
                if (isset($role['RegisteredUnconfirmed'])) {
                    $message = Yii::t('app', 'Please confirm your registration');
                } else {
                    $message = Yii::t('yii', 'You are not allowed to perform this action.');
                }
            } else {
                $message = Yii::t('yii', 'You are not allowed to perform this action.');
            }
        }
        return $message;
    }
}
