<?php
namespace frontend\models;

use common\models\User;
use common\models\AppData;
use yii\base\Model;
use yii\helpers\Url;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это имя пользователя уже занято.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот email уже зарегистрирован.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->confirm_key = Yii::$app->security->generateRandomString();
            if ($user->save()) {
                $this->sendEmail($user);
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('RegisteredUnconfirmed');
                $auth->assign($role, $user->getId());
                return $user;
            }
        }

        return null;
    }

    /**
     * @param  User  $user
     * @return boolean whether the email was sent
     */
    public function sendEmail($user)
    {
        $appData = AppData::getData();
        $view = Yii::$app->getView();
        $text = $view->render('/emailTemplates/' . Yii::$app->language . '/register', [
            'confirmationUrl' => Url::to(['@web/site/confirm', 'key' => $user->confirm_key], true)
        ]);
        $subject = Yii::t('app', 'Confirm registrations on') . ' ' . Yii::$app->name;
        return Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom($appData['adminEmail'])
            ->setSubject($subject)
            ->setTextBody($text)
            ->send();
    }

}
